@extends('layouts.admin')

@section('content')
    <ul class="list-inline pt-3">
        <li class="list-inline-item">
            <a href="{{ route("admin.product_categories.index") }}" class="btn btn-light">一覧</a>
        </li>
        <li class="list-inline-item">
            <a href="{{ route("admin.product_categories.edit", $product_category->id) }}" class="btn btn-success">編集</a>
        </li>
        @can('delete', $product_category)
            <li class="list-inline-item">
                <form action="{{ route("admin.product_categories.destroy", $product_category->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger">削除</button>
                </form>
            </li>
        @endcan
    </ul>

    <table class="table">
        <tbody>
            <tr>
                <th>ID</th>
                <td>{{ $product_category->id }}</td>
            </tr>
            <tr>
                <th>名称</th>
                <td>{{ $product_category->name }}</td>
            </tr>
            <tr>
                <th>並び順番号</th>
                <td>{{ $product_category->order_no }}</td>
            </tr>
        </tbody>
    </table>
@endsection
