@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md border shadow-sm py-2 d-flex">
            <div>検索結果 {{ $products->total() }} のうち {{ $products->firstItem() }}-{{ $products->lastItem() }}件 @if(filled($specified_category))<span class="font-weight-bold">{{ $specified_category }}</span>@endif @if(filled($specified_category) && request()->filled("keyword")) : @endif @if(request()->filled("keyword"))<span class="text-danger">"{{ request("keyword") }}"</span>@endif </div>
            <form class="ml-auto" action="{{ route("products.index") }}">
                <input type="hidden" name="product_category_id" value="{{ request("product_category_id") }}">
                <input type="hidden" name="keyword" value="{{ request("keyword") }}">
                <select class="custom-select" name="sort" onchange="event.preventDefault();$(this).parent('form').submit();">
                    <option value="review_rank-desc">並び替え: レビューの評価順</option>
                    <option value="price-asc" {{ request("sort") === "price-asc" ? "selected" : "" }}>並び替え: 価格の安い順</option>
                    <option value="price-desc" {{ request("sort") === "price-desc" ? "selected" : "" }}>並び替え: 価格の高い順</option>
                    <option value="updated_at-desc" {{ request("sort") === "updated_at-desc" ? "selected" : "" }}>並び替え: 最新商品</option>
                </select>
            </form>
        </div>
    </div>

    <div class="row pt-2">
        @foreach($products as $product)
            <div class="col-md-4">
                <div class="card mb-4">
                    <a href="#" target="_blank">
                        @if(filled($product->image_path))
                            <img class="card-img-top bd-placeholder-img" src="{{ \Storage::url($product->image_path) }}">
                        @endif
                    </a>
                    <div class="card-body">
                        <a href="#" target="_blank">
                            <h5 class="card-title">{{ $product->name }}</h5>
                        </a>
                        <p class="card-text">¥{{ number_format($product->price) }}</p>
                        @auth("user")
                            <a class="toggle_wish" data-product-id="{{ $product->id }}" data-wished="{{ count($product->wishedUsers) > 0 ? "true" : "false" }}">
                                <i class="fa-heart {{ count($product->wishedUsers) > 0 ? "fas" : "far" }}"></i>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-md">
            {{ $products->appends(request()->all())->links() }}
        </div>
    </div>

@endsection
