@extends('layouts.admin')

@section('content')
    <form class="shadow p-3 mt-3" action={{ route("admin.products.index") }}>
        <div class="row">
            <div class="col-md-4 mb-3">
                <select class="custom-select" id="product_category_id" name="product_category_id">
                    <option value="" selected="">すべてのカテゴリー</option>
                    @foreach($product_categories as $product_category)
                    <option value="{{ $product_category->id }}" {{ request("product_category_id") == $product_category->id ? "selected" : "" }}>{{ $product_category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-8 mb-3">
                <input type="text" class="form-control" id="name" name="name" value="{{ request("name") }}" placeholder="名称">
            </div>
        </div>
        <div class="row">
            <div class="col-md mb-3">
                <div class="input-group">
                    <input type="number" class="form-control" id="price" name="price" value="{{ request("price") }}" min="0" placeholder="価格">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="price_compare" id="price-compare-gteq" value="gteq" checked="">
                                <label class="form-check-label" for="price-compare-gteq">以上</label>
                            </div>
                            <div class="form-check form-check-inline mr-0">
                                <input class="form-check-input" type="radio" name="price_compare" id="price-compare-lteq" value="lteq" {{ request("price_compare") === "lteq" ? "checked" : "" }}>
                                <label class="form-check-label" for="price-compare-lteq">以下</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <select class="custom-select" name="sort_column">
                    <option value="id" selected="">並び替え: ID</option>
                    <option value="product_category" {{ request("sort_column") === "product_category" ? "selected" : "" }}>並び替え: 商品カテゴリ</option>
                    <option value="name" {{ request("sort_column") === "name" ? "selected" : "" }}>並び替え: 名称</option>
                    <option value="price" {{ request("sort_column") === "price" ? "selected" : "" }}>並び替え: 価格</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <select class="custom-select" name="sort_direction">
                    <option value="asc" {{ request("sort_direction") === "asc" ? "selected" : "" }}>並び替え方向: 昇順</option>
                    <option value="desc" {{ request("sort_direction") === "desc" ? "selected" : "" }}>並び替え方向: 降順</option>
                </select>
            </div>
            <div class="col-md-2 mb-3">
                <select class="custom-select" name="page_unit">
                    <option value="10">表示: 10件</option>
                    <option value="20" {{ request("page_unit") == 20 ? "selected" : "" }}>表示: 20件</option>
                    <option value="50" {{ request("page_unit") == 50 ? "selected" : "" }}>表示: 50件</option>
                    <option value="100" {{ request("page_unit") == 100 ? "selected" : "" }}>表示: 100件</option>
                </select>
            </div>
            <div class="col-sm mb-3">
                <button type="submit" class="btn btn-block btn-primary">検索</button>
            </div>
        </div>
    </form>

    <ul class="list-inline pt-3">
        <li class="list-inline-item">
            <a href="{{ route("admin.products.create") }}" class="btn btn-success">新規</a>
        </li>
    </ul>

    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>ID</th>
                <th>商品カテゴリ</th>
                <th>名称</th>
                <th>価格</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->product_category_name }}</td>
                    <td><a href="{{ route("admin.products.show", $product->id) }}">{{ $product->name }}</a></td>
                    <td>¥{{ number_format($product->price) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{ $products->appends(request()->all())->links() }}
@endsection
