@extends('layout')
@php ($cartProductIds = session('cart') ? session('cart') : [])

@section('content')
    <div class="container">
        <h1 class="text-center m-4">Product catalog</h1>

        <table class="table">
            <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">
                    Name
                    @if ($nameOrder === 'desc')
                        <a class="btn btn-sm btn-secondary"
                           href="{{url()->current() . '?' . http_build_query(array_merge(['name_sort' => 'asc']))}}">Order
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down"
                                 fill="currentColor"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                            </svg>
                        </a>
                    @elseif ($nameOrder === 'asc')
                        <a class="btn btn-sm btn-secondary"
                           href="{{url()->current() . '?' . http_build_query(array_merge(['name_sort' => 'desc']))}}">Order
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up" fill="currentColor"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
                            </svg>
                        </a>
                    @else
                        <a class="btn btn-sm btn-secondary"
                           href="{{url()->current() . '?' . http_build_query(array_merge(['name_sort' => 'asc']))}}">Order
                        </a>
                    @endif
                </th>
                <th scope="col">
                    Price
                    @if ($priceOrder === 'desc')
                        <a class="btn btn-sm btn-secondary"
                           href="{{url()->current() . '?' . http_build_query(array_merge(['price_sort' => 'asc']))}}">Order
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down"
                                 fill="currentColor"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                            </svg>
                        </a>
                    @elseif ($priceOrder === 'asc')
                        <a class="btn btn-sm btn-secondary"
                           href="{{url()->current() . '?' . http_build_query(array_merge(['price_sort' => 'desc']))}}">Order
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up" fill="currentColor"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
                            </svg>
                        </a>
                    @else
                        <a class="btn btn-sm btn-secondary"
                           href="{{url()->current() . '?' . http_build_query(array_merge(['price_sort' => 'asc']))}}">Order
                        </a>
                    @endif
                </th>
                <th scope="col">Cart (<span id="cart-qty">{{ count($cartProductIds) }}</span>)</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($products as $product)
                <tr>
                    <th scope="row">{{ $product->id }}</th>
                    <td>{{ $product->name }}</td>
                    <td>${{ $product->price }}</td>
                    <td>
                        @if (!in_array($product->id, $cartProductIds))
                            <a href="{{route('cart_add_product', ['product' => $product->id])}}" class="add-product">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus-circle-fill"
                                     fill="currentColor"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                                </svg>
                            </a>
                        @endif
                    </td>
                </tr>
            @empty
                <p>No products</p>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            const cartCount = $('#cart-qty');

            $('.add-product').click(function (e) {
                const link = $(this);
                e.preventDefault();
                $.post($(this).attr('href')).done(
                    function (res) {
                        if (res.success) {
                            link.hide();
                            cartCount.text(res.data.cartProducts.length);
                        }
                    }
                );
            });
        })
    </script>
@endsection
