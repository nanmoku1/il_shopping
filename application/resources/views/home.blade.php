@extends('layouts.app')

@section('content')
    @auth('user')
        <div class="row">
            <div class="col-md">
                <h3 class="border-bottom mb-3">ほしいものリスト</h3>
            </div>
        </div>

        <div class="row">
            @foreach(auth("user")->user()->wishProducts as $product)
                @include('products.components.product_card', ['product' => $product])
            @endforeach
        </div>
    @endauth
@endsection
