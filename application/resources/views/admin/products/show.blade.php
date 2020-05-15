@extends('layouts.admin')

@section('content')
<ul class="list-inline pt-3">
    <li class="list-inline-item">
        <a href="{{ route("admin.products.index") }}" class="btn btn-light">一覧</a>
    </li>
    <li class="list-inline-item">
        <a href="{{ route("admin.products.edit", $product->id) }}" class="btn btn-success">編集</a>
    </li>
    <li class="list-inline-item">
        <form action="{{ route("admin.products.destroy", $product->id) }}" method="POST">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn btn-danger">削除</button>
        </form>
    </li>
</ul>

<table class="table">
    <tbody>
        <tr>
            <th>ID</th>
            <td>{{ $product->id }}</td>
        </tr>
        <tr>
            <th>商品カテゴリー</th>
            <td>{{ $product->productCategory->name }}</td>
        </tr>
        <tr>
            <th>名称</th>
            <td>{{ $product->name }}</td>
        </tr>
        <tr>
            <th>価格</th>
            <td>¥{{ number_format($product->price) }}</td>
        </tr>
        <tr>
            <th>説明</th>
            <td>{{ $product->description }}</td>
        </tr>
        @if(filled($product->image_path))
            <tr>
                <th>イメージ</th>
                <td><img class="img-thumbnail" src="{{ url("/storage/{$product->image_path}") }}"></td>
            </tr>
        @endif
    </tbody>
</table>
@endsection
