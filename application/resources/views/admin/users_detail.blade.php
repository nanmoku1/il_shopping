@extends('layouts.admin')

@section('content')
<ul class="list-inline pt-3">
    @can('manager-admin-only')
    <li class="list-inline-item">
        <a href="{{ route("admin.admin_users_list") }}" class="btn btn-light">一覧</a>
    </li>
    @endcan
    @can('manager-admin-or-me', $adminUser)
    <li class="list-inline-item">
        <a href="{{ route("admin.admin_users_edit_page", $adminUser->id) }}" class="btn btn-success">編集</a>
    </li>
    @endcan
    @can('manager-admin-and-not-me', $adminUser)
    <li class="list-inline-item">
        <form action="{{ route("admin.admin_users_delete", ["id"=>$adminUser->id]) }}" method="POST">
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
