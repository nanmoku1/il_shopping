@extends('layouts.admin')

@section('content')
<div class="row pt-3">
    <div class="col-sm">
        <form action="{{ route("admin.users.update", $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">名称</label>
                <input type="text" class="form-control @error("name") is-invalid @enderror" id="name" name="name" value="{{ old("name", $user->name) }}" placeholder="名称" autocomplete="name" autofocus="">
                @include('components.form_error_message', ['input_name' => 'name'])
            </div>

            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="text" class="form-control @error("email") is-invalid @enderror" id="email" name="email" value="{{ old("email", $user->email) }}" placeholder="メールアドレス" autocomplete="email">
                @include('components.form_error_message', ['input_name' => 'email'])
            </div>

            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" class="form-control @error("password") is-invalid @enderror" id="password" name="password" placeholder="パスワード" autocomplete="new-password">
                @include('components.form_error_message', ['input_name' => 'password'])
            </div>

            <div class="form-group">
                <label for="password-confirm">パスワード(確認)</label>
                <input type="password" class="form-control" id="password-confirm" name="password_confirmation" placeholder="パスワード(確認)" autocomplete="new-password">
            </div>

            <div class="form-group">
                <label for="image_path">イメージ</label>
                <input type="file" class="form-control-file @error("image_path") is-invalid @enderror" id="image_path" name="image_path">
                @include('components.form_error_message', ['input_name' => 'image_path'])
            </div>

            @if(filled($user->image_path))
                <div class="form-group">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="image_delete" id="image_delete" value="1">
                        <label class="form-check-label" for="image_delete">イメージ削除</label>
                    </div>
                </div>
                <div class="form-group">
                    <img class="img-thumbnail" src="{{ \Storage::url($user->image_path) }}">
                </div>
            @endif

            <hr class="mb-3">

            <ul class="list-inline">
                <li class="list-inline-item">
                    <a href="{{ route("admin.users.show", $user->id) }}" class="btn btn-secondary">キャンセル</a>
                </li>
                <li class="list-inline-item">
                    <button type="submit" class="btn btn-primary">更新</button>
                </li>
            </ul>
        </form>
    </div>
</div>
@endsection
