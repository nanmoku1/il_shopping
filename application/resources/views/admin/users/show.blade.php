@extends('layouts.admin')

@section('content')
<ul class="list-inline pt-3">
    <li class="list-inline-item">
        <a href="{{ route("admin.users.index") }}" class="btn btn-light">一覧</a>
    </li>
    <li class="list-inline-item">
        <a href="{{ route("admin.users.edit", $user->id) }}" class="btn btn-success">編集</a>
    </li>
    <li class="list-inline-item">
        <form action="{{ route("admin.users.destroy", $user->id) }}" method="POST">
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
            <td>{{ $user->id }}</td>
        </tr>
        <tr>
            <th>名称</th>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th>メールアドレス</th>
            <td>{{ $user->email }}</td>
        </tr>
        @if(filled($user->image_path))
        <tr>
            <th>イメージ</th>
            <td><img class="img-thumbnail" src="{{ url("/storage/{$user->image_path}") }}"></td>
        </tr>
        @endif
    </tbody>
</table>
@endsection
