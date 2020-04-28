@extends('layouts.admin')

@section('content')
<ul class="list-inline pt-3">
    @can('viewAny', \App\Models\AdminUser::class)
    <li class="list-inline-item">
        <a href="{{ route("admin.admin_users.index") }}" class="btn btn-light">一覧</a>
    </li>
    @endcan
    @can('update', $admin_user)
    <li class="list-inline-item">
        <a href="{{ route("admin.admin_users.edit", $admin_user->id) }}" class="btn btn-success">編集</a>
    </li>
    @endcan
    @can('delete', $admin_user)
    <li class="list-inline-item">
        <form action="{{ route("admin.admin_users.destroy", $admin_user->id) }}" method="POST">
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
            <td>{{ $admin_user->id }}</td>
        </tr>
        <tr>
            <th>名称</th>
            <td>{{ $admin_user->name }}</td>
        </tr>
        <tr>
            <th>メールアドレス</th>
            <td>{{ $admin_user->email }}</td>
        </tr>
        <tr>
            <th>権限</th>
            <td>{{ $admin_user->is_owner ? "オーナー":"一般" }}</td>
        </tr>
    </tbody>
</table>
@endsection
