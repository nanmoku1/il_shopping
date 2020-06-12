@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-5">
            @if(filled($product->image_path))
                <img class="img-thumbnail" src="{{ \Storage::url($product->image_path) }}">
            @endif
        </div>
        <div class="col-md-7">
            <div class="row">
                <h2 class="col-md">{{ $product->name }}</h2>
            </div>
            <hr>
            <div class="row">
                <div class="col-md">
                    <span class="mr-3">価格:</span>
                    <soan class="h5 text-danger">¥{{ number_format($product->price) }}</soan>
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-md">
                    {{ $product->description }}
                </div>
            </div>
            <hr>
            @auth("user")
                <div class="row">
                    <div class="col-md">
                        <a class="toggle_wish" data-product-id="{{ $product->id }}" data-wished="{{ count($product->wishedUsers) > 0 ? "true" : "false" }}">
                            <i class="fa-heart {{ count($product->wishedUsers) > 0 ? "fas" : "far" }}"></i>
                        </a>
                    </div>
                </div>
            @endauth
        </div>
    </div>

    @auth("user")
        <div class="row mt-3">
            <div class="col-md">
                <a class="btn btn-primary" href="{{ route("products.product_reviews.create", $product->id) }}">レビューを書く</a>
            </div>
        </div>
    @endauth

    <div class="row mt-3">
        <div class="col-md">
            <ul class="list-unstyled">
                @foreach($product->productReviews as $product_review)
                    <li class="media bg-white p-2 mb-3">
                        @if(filled($product_review->user->image_path))
                            <img src="{{ \storage::url($product_review->user->image_path) }}" width="30" height="30" class="mr-3" alt="...">
                        @endif
                        <div class="media-body">
                            <h6>{{ $product_review->user->name }}</h6>
                            <h5>
                                @if(auth('user')->check() && auth('user')->user()->id === $product_review->user_id)
                                    <a href="{{ route("products.product_reviews.edit", [$product->id, $product_review->id]) }}">
                                        {{ $product_review->title }}
                                    </a>
                                @else
                                    {{ $product_review->title }}
                                @endif
                            </h5>
                            <div class="review_star">
                                <i class="fa-star {{ $product_review->rank >= 1 ? "fas" : "far" }}"></i>
                                <i class="fa-star {{ $product_review->rank >= 2 ? "fas" : "far" }}"></i>
                                <i class="fa-star {{ $product_review->rank >= 3 ? "fas" : "far" }}"></i>
                                <i class="fa-star {{ $product_review->rank >= 4 ? "fas" : "far" }}"></i>
                                <i class="fa-star {{ $product_review->rank >= 5 ? "fas" : "far" }}"></i>
                            </div>
                            {{ $product_review->body }}
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
