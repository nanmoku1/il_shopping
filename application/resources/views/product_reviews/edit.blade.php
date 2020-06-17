@extends('layouts.app')

@section('content')
    <div class="row pt-3">
        <div class="col-sm">
            <form action="{{ route("products.product_reviews.update", [$product->id, $product_review->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title">タイトル</label>
                    <input type="text" class="form-control @error("title") is-invalid @enderror" id="title" name="title" value="{{ old("title", $product_review->title) }}" placeholder="タイトル" autofocus="">
                    @include('components.form_error_message', ['input_name' => 'title'])
                </div>

                <div class="form-group">
                    <label for="body">本文</label>
                    <input type="text" class="form-control  @error("body") is-invalid @enderror" id="body" name="body" value="{{ old("body", $product_review->body) }}" placeholder="本文">
                    @include('components.form_error_message', ['input_name' => 'body'])
                </div>

                @include('product_reviews.components.rank_input_radioes', ['rank' => old("rank", $product_review->rank)])

                <hr class="mb-3">

                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="{{ route("products.show", $product->id) }}" class="btn btn-secondary">商品へ戻る</a>
                    </li>
                    <li class="list-inline-item">
                        <button type="submit" class="btn btn-primary">レビュー</button>
                    </li>
                </ul>
            </form>
        </div>
    </div>
@endsection
