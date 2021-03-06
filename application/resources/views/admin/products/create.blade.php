@extends('layouts.admin')

@section('content')
    <div class="row pt-3">
        <div class="col-sm">
            <form id="form_create" class="form_money" action="{{ route("admin.products.store") }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="product_category_id">商品カテゴリ</label>
                    <select class="custom-select @error("product_category_id") is-invalid @enderror" id="product_category_id" name="product_category_id" autofocus="">
                        <option value="" selected=""></option>
                        {{ old("name") }}
                        @foreach($product_categories as $product_category)
                            <option value="{{ $product_category->id }}" {{ old("product_category_id") == $product_category->id ? "selected" : "" }}>{{ $product_category->name }}</option>
                        @endforeach
                    </select>
                    @include('components.form_error_message', ['input_name' => 'product_category_id'])
                </div>
                <div class="form-group">
                    <label for="name">名称</label>
                    <input type="text" class="form-control @error("name") is-invalid @enderror" id="name" name="name" value="{{ old("name") }}" placeholder="名称" autocomplete="name">
                    @include('components.form_error_message', ['input_name' => 'name'])
                </div>
                <div class="form-group">
                    <label for="price">価格</label>
                    <input type="text" class="form-control input_money @error("price") is-invalid @enderror" id="price" name="price" value="{{ old("price") }}" placeholder="価格">
                    @include('components.form_error_message', ['input_name' => 'price'])
                </div>
                <div class="form-group">
                    <label for="description">説明</label>
                    <textarea class="form-control @error("description") is-invalid @enderror" id="description" name="description" placeholder="説明">{{ old("description") }}</textarea>
                    @include('components.form_error_message', ['input_name' => 'description'])
                </div>
                <div class="form-group">
                    <label for="image_path">イメージ</label>
                    <input type="file" class="form-control-file @error("image_path") is-invalid @enderror" id="image_path" name="image_path">
                    @include('components.form_error_message', ['input_name' => 'image_path'])
                </div>

                <hr class="mb-3">

                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="{{ route("admin.products.index") }}" class="btn btn-secondary">キャンセル</a>
                    </li>
                    <li class="list-inline-item">
                        <button type="submit" class="btn btn-primary">作成</button>
                    </li>
                </ul>
            </form>
        </div>
    </div>
@endsection
