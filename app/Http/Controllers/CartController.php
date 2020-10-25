<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public const SESSION_CART = 'cart';

    public function index(Request $request)
    {
        $productIds = $request->session()->get(self::SESSION_CART, []);
        $cartProducts = Product::cartProducts($productIds);
        $totalCartAmount = Product::totalCartAmount($productIds);

        return view('cart.index', [
            'products'        => $cartProducts,
            'totalCartAmount' => $totalCartAmount,
        ]);
    }

    // TODO: Move logic to a separate service - CartService
    public function addProduct(Product $product, Request $request)
    {
        $productIds = $request->session()->get(self::SESSION_CART, []);

        if (in_array($product->id, $productIds, true)) {
            return $this->responseFail('Product has already been added.');
        }

        $productIds[] = $product->id;
        $request->session()->put(self::SESSION_CART, $productIds);

        $cartProducts = Product::cartProducts($productIds)->toArray();

        /** @var User $user */
        if ($user = Auth::user()) {
            $user->syncCart($user, $productIds);
        }

        return $this->responseSuccess(['cartProducts' => $cartProducts]);
    }

    // TODO: Move logic to a separate service - CartService
    public function removeProduct(Product $product, Request $request)
    {
        $productIds = $request->session()->get(self::SESSION_CART, []);

        if (!in_array($product->id, $productIds, true)) {
            return $this->responseFail('Product not found in cart.');
        }

        unset($productIds[array_search($product->id, $productIds)]);
        $request->session()->put(self::SESSION_CART, $productIds);

        $totalCartAmount = Product::totalCartAmount($productIds);

        /** @var User $user */
        if ($user = Auth::user()) {
            $user->syncCart($user, $productIds);
        }

        return $this->responseSuccess(['totalCartAmount' => $totalCartAmount]);
    }

    private function responseSuccess(?array $data = [], ?string $message = '')
    {
        return response()->json([
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ]);
    }

    private function responseFail(string $message, ?int $code = 200)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], $code);
    }
}
