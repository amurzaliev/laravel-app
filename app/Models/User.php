<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cart_id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cart()
    {
        return $this->hasOne(Cart::class, 'user_id');
    }

    public function sessionCartData(): array
    {
        if ($this->cart) {
            return $this->cart->products()
                ->get()
                ->pluck('id')
                ->toArray();
        }

        return [];
    }

    public function syncCart(User $user, array $cartProducts)
    {
        if (!$cart = $user->cart) {
            $cart = new Cart(['user_id' => Auth::id()]);
        }

        $cart->save();
        $cart->products()->detach();

        foreach ($cartProducts as $product) {
            $cart->products()->attach($product);
        }
    }
}
