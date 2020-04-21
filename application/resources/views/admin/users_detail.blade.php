@extends('layouts.admin')

@section('content')
<ul class="list-inline pt-3">
    @if(auth('admin')->user()->is_owner)
    <li class="list-inline-item">
        <a href="{{ route("admin.admin_users_list") }}" class="btn btn-light">一覧</a>
    </li>
    @endif
    @if( auth('admin')->user()->is_owner || auth('admin')->user()->id === $adminUser->id )
    <li class="list-inline-item">
        <a href="{{ route("admin.admin_users_edit_page", ["id"=>$adminUser->id]) }}" class="btn btn-success">編集</a>
    </li>
    @endif
    @if( auth('admin')->user()->is_owner && auth('admin')->user()->id !== $adminUser->id )
    <li class="list-inline-item">
        <form action="{{ route("admin.admin_users_delete", ["id"=>$adminUser->id]) }}" method="POST">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn btn-danger">削除</button>
        </form>
    </li>
    @endif
</ul>

<table class="table">
    <tbody>
        <tr>
            <th>ID</th>
            <td>{{ $adminUser->id }}</td>
        </tr>
        <tr>
            <th>名称</th>
            <td>{{ $adminUser->name }}</td>
        </tr>
        <tr>
            <th>メールアドレス</th>
            <td>{{ $adminUser->email }}</td>
        </tr>
        <tr>
            <th>権限</th>
            <td>{{ $adminUser->is_owner ? "オーナー":"一般" }}</td>
        </tr>
    </tbody>
</table>
@endsection
