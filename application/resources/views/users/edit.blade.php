@extends('layouts.login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">編集</div>

                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="{{ route('users.update', $user->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">ユーザ名</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" autocomplete="name" autofocus="">
                                @include('components.form_error_message', ['input_name' => 'name'])
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" autocomplete="email">
                                @include('components.form_error_message', ['input_name' => 'email'])
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                                @include('components.form_error_message', ['input_name' => 'password'])
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">パスワード(確認)</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="image_path" class="col-md-4 col-form-label text-md-right">イメージ</label>
                            <div class="col-md-6">
                                <input type="file" class="form-control-file @error('image_path') is-invalid @enderror" id="image_path" name="image_path">
                                @include('components.form_error_message', ['input_name' => 'image_path'])
                                @if(filled($user->image_path))
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="image_delete" name="image_delete" value="1">
                                        <label for="image_delete">削除</label>
                                    </div>
                                    <img class="img-thumbnail" width="100" src="{{ \Storage::url($user->image_path) }}">
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    更新
                                </button>
                            <a class="btn btn-secondary" href="{{ route("home") }}">
                                    キャンセル
                                </a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
