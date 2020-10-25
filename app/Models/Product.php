<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
    ];

    public function carts()
    {
        return $this->belongsToMany(Cart::class);
    }

    public static function listProducts(?string $nameOrder = 'asc', ?string $priceOrder = 'asc'): Collection
    {
        $qb = DB::table('products');

        if ($nameOrder) {
            $qb->orderBy('name', $nameOrder);
        }

        if ($priceOrder) {
            $qb->orderBy('price', $priceOrder);
        }

        return $qb->get();
    }

    public static function cartProducts(array $ids): Collection
    {
        return DB::table('products')
            ->whereIn('id', $ids)
            ->get();
    }

    public static function totalCartAmount(array $ids): int
    {
        return DB::table('products')
            ->whereIn('id', $ids)
            ->sum('price');
    }
}
