@extends('layouts.admin')

@section('content')
<div class="row pt-3">
    <div class="col-sm">
        <form action="{{ route("admin.admin_users_store") }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">名称</label>
                <input type="text" class="form-control {{ $errors->has("name") ? "is-invalid":"" }}" id="name" name="name" value="{{ old("name") }}" placeholder="名称" autocomplete="name" autofocus="">
                @foreach($errors->get("name") as $err)
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $err }}</strong>
                </span>
                @endforeach
            </div>

            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="text" class="form-control {{ $errors->has("email") ? "is-invalid":"" }}" id="email" name="email" value="{{ old("email") }}" placeholder="メールアドレス" autocomplete="email">
                @foreach($errors->get("email") as $err)
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $err }}</strong>
                </span>
                @endforeach
            </div>

            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" class="form-control  {{ $errors->has("password") ? "is-invalid":"" }}" id="password" name="password" placeholder="パスワード" autocomplete="new-password">
                @foreach($errors->get("password") as $err)
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $err }}</strong>
                </span>
                @endforeach
            </div>

            <div class="form-group">
                <label for="password-confirm">パスワード(確認)</label>
                <input type="password" class="form-control" id="password-confirm" name="password_confirmation" placeholder="パスワード(確認)" autocomplete="new-password">
            </div>

            <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" id="general" name="is_owner" value="0" checked>
                <label class="form-check-label" for="general">一般</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" id="owner" name="is_owner" value="1" {{ old("is_owner") == 1 ? "checked":""  }}>
                <label class="form-check-label" for="owner">オーナー</label>
            </div>

            <hr class="mb-3">

            <ul class="list-inline">
                <li class="list-inline-item">
                    <a href="{{ route("admin.admin_users_index") }}" class="btn btn-secondary">キャンセル</a>
                </li>
                <li class="list-inline-item">
                    <button type="submit" class="btn btn-primary">作成</button>
                </li>
            </ul>
        </form>
    </div>
</div>
@endsection
