@extends('layouts.login')

@section('content')
    <form class="form-signin" method="POST" action="{{ route('admin.login') }}">
        @csrf

        <h1 class="h3 mb-3 font-weight-normal">管理画面</h1>

        <label for="email" class="sr-only">メールアドレス</label>
        <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="メールアドレス" autofocus>
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <label for="password" class="sr-only">パスワード</label>
        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="パスワード">
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <button class="btn btn-lg btn-primary btn-block" type="submit">ログイン</button>
    </form>
@endsection
