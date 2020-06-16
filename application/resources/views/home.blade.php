@extends('layouts.app')

@section('content')
    @auth('user')
        <div class="row">
            <div class="col-md">
                <h3 class="border-bottom mb-3">ほしいものリスト</h3>
            </div>
        </div>

        <div class="row">
            @each('products.components.product_card', auth("user")->user()->wishProducts, 'product')
        </div>
    @endauth
@endsection
