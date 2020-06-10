@extends('layouts.app')

@section('content')
    <div class="row pt-3">
        <div class="col-sm">
            <form action="{{ route("product_reviews.update", [$product->id, $product_review->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title">タイトル</label>
                    <input type="text" class="form-control @error("title") is-invalid @enderror" id="title" name="title" value="{{ old("title", $product_review->title) }}" placeholder="タイトル" autofocus="">
                    @error("title")
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="body">本文</label>
                    <input type="text" class="form-control  @error("body") is-invalid @enderror" id="body" name="body" value="{{ old("body", $product_review->body) }}" placeholder="本文">
                    @error("body")
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" id="rank1" name="rank" value="1" checked>
                    <label class="form-check-label" for="rank1">星1つ</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" id="rank2" name="rank" value="2" {{ old("rank", $product_review->rank) == 2 ? "checked" : "" }}>
                    <label class="form-check-label" for="rank2">星2つ</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" id="rank3" name="rank" value="3" {{ old("rank", $product_review->rank) == 3 ? "checked" : "" }}>
                    <label class="form-check-label" for="rank3">星3つ</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" id="rank4" name="rank" value="4" {{ old("rank", $product_review->rank) == 4 ? "checked" : "" }}>
                    <label class="form-check-label" for="rank4">星4つ</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" id="rank5" name="rank" value="5" {{ old("rank", $product_review->rank) == 5 ? "checked" : "" }}>
                    <label class="form-check-label" for="rank5">星5つ</label>
                </div>

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
