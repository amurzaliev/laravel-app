<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $nameSort = $request->get('name_sort');
        $priceSort = $request->get('price_sort');
        $nameOrder = in_array($nameSort, ['asc', 'desc']) ? $nameSort : null;
        $priceOrder = in_array($priceSort, ['asc', 'desc']) ? $priceSort : null;

        $products = Product::listProducts($nameOrder, $priceOrder);

        return view('product.index', [
            'products'   => $products,
            'nameOrder'  => $nameOrder,
            'priceOrder' => $priceOrder,
        ]);
    }
}
