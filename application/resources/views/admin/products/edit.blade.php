@extends('layouts.admin')

@section('content')
    <script>
        $(function(){
            $("#form_edit").on("submit", function(){
                let elementPrice = $("#price");
                elementPrice.val(elementPrice.val().replace(/[¥,]/g, ""));
            });
            $("#price").maskMoney({
                prefix:"¥",
                thousands:",",
                allowZero:true,
                precision:"0",
            })
                .maskMoney("mask");
        });
    </script>
    <div class="row pt-3">
        <div class="col-sm">
            <form id="form_edit" action="{{ route("admin.products.update", $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="product_category_id">商品カテゴリ</label>
                    <select class="custom-select @error("product_category_id") is-invalid @enderror" id="product_category_id" name="product_category_id">
                        <option value="" selected=""></option>
                        @foreach($product_categories as $product_category)
                            <option value="{{ $product_category->id }}" {{ old("product_category_id", $product->product_category_id) == $product_category->id ? "selected" : "" }}>{{ $product_category->name }}</option>
                        @endforeach
                    </select>
                    @error("product_category_id")
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="name">名称</label>
                    <input type="text" class="form-control @error("name") is-invalid @enderror" id="name" name="name" value="{{ old("name", $product->name) }}" placeholder="名称" autocomplete="name" autofocus="">
                    @error("name")
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="price">価格</label>
                    <input type="text" class="form-control @error("price") is-invalid @enderror" id="price" name="price" value="{{ old("price", $product->price) }}" placeholder="価格">
                    @error("price")
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">説明</label>
                    <textarea class="form-control @error("description") is-invalid @enderror" id="description" name="description" placeholder="説明">{{ old("description", $product->description) }}</textarea>
                    @error("description")
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="image_path">イメージ</label>
                    <input type="file" class="form-control-file @error("image_path") is-invalid @enderror" id="image_path" name="image_path">
                    @error("image_path")
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                @if(filled($product->image_path))
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="image_del" id="image_del" value="1">
                            <label class="form-check-label" for="image_del">イメージ削除</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <img class="img-thumbnail" src="{{ url("/storage/{$product->image_path}") }}">
                    </div>
                @endif

                <hr class="mb-3">

                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="{{ route("admin.products.show", $product->id) }}" class="btn btn-secondary">キャンセル</a>
                    </li>
                    <li class="list-inline-item">
                        <button type="submit" class="btn btn-primary">更新</button>
                    </li>
                </ul>
            </form>
        </div>
    </div>
@endsection
