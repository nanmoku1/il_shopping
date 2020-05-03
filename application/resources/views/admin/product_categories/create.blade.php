@extends('layouts.admin')

@section('content')
<div class="row pt-3">
    <div class="col-sm">
        <form action="{{ route("admin.product_categories.store") }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">名称</label>
                <input type="text" class="form-control @error("name") is-invalid @enderror" id="name" name="name" value="{{ old("name") }}" placeholder="名称" autocomplete="name" autofocus="">
                @error("name")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="order-no">並び順番号</label>
                <input type="number" class="form-control @error("order_no") is-invalid @enderror" id="order-no" name="order_no" value="{{ old("order_no") }}" placeholder="並び順番号">
                @error("order_no")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <hr class="mb-3">

            <ul class="list-inline">
                <li class="list-inline-item">
                    <a href="{{ route("admin.product_categories.index") }}" class="btn btn-secondary">キャンセル</a>
                </li>
                <li class="list-inline-item">
                    <button type="submit" class="btn btn-primary">作成</button>
                </li>
            </ul>
        </form>
    </div>
</div>
@endsection
