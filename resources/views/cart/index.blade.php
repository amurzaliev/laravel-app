@extends('layout')
@php ($cartProductIds = session('cart') ? session('cart') : [])

@section('content')
    <div class="container">
        <h1 class="text-center m-4">Cart</h1>

        <table class="table">
            <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Cart</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($products as $product)
                <tr>
                    <th scope="row">{{ $product->id }}</th>
                    <td>{{ $product->name }}</td>
                    <td>${{ $product->price }}</td>
                    <td>
                        @if (in_array($product->id, $cartProductIds))
                            <a href="{{route('cart_remove_product', ['product' => $product->id])}}" class="remove-product">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x-square-fill"
                                     fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                                </svg>
                            </a>
                        @endif
                    </td>
                </tr>
            @empty
                <p>No products in Cart</p>
            @endforelse
            </tbody>
        </table>
        <p class="text-right">
            <strong>Total amount: $<span id="total-cart-amount">{{$totalCartAmount}}</span></strong>
        </p>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            const totalCartAmount = $('#total-cart-amount');

            $('.remove-product').click(function (e) {
                const link = $(this);
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('href'),
                    type: 'DELETE',
                    success: function (res) {
                        if (res.success) {
                            link.parent().parent().hide();
                            totalCartAmount.text(res.data.totalCartAmount);
                        }
                    }
                });
            });
        })
    </script>
@endsection
