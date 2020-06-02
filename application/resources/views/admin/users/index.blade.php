@extends('layouts.admin')

@section('content')
    <form class="shadow p-3 mt-3" action={{ route("admin.users.index") }}>
        <div class="row">
            <div class="col-md-6 mb-3">
                <input type="text" class="form-control" id="name" name="name" value="{{ request("name") }}" placeholder="名称" />
            </div>
            <div class="col-md mb-3">
                <input type="text" class="form-control" id="email" name="email" value="{{ request("email") }}" placeholder="メールアドレス" />
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <select class="custom-select" name="sort_column">
                    <option value="id">並び替え: ID</option>
                    <option value="name" {{ request("sort_column") === "name" ? "selected":"" }}>並び替え: 名称</option>
                    <option value="email" {{ request("sort_column") === "email" ? "selected":"" }}>並び替え: メールアドレス</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <select class="custom-select" name="sort_direction">
                    <option value="asc" {{ request("sort_direction") === "asc" ? "selected":"" }}>並び替え方向: 昇順</option>
                    <option value="desc" {{ request("sort_direction") === "desc" ? "selected":"" }}>並び替え方向: 降順</option>
                </select>
            </div>
            <div class="col-md-2 mb-3">
                <select class="custom-select" name="page_unit">
                    <option value="10">表示: 10件</option>
                    <option value="20" {{ request("page_unit") == 20 ? "selected":"" }}>表示: 20件</option>
                    <option value="50" {{ request("page_unit") == 50 ? "selected":"" }}>表示: 50件</option>
                    <option value="100" {{ request("page_unit") == 100 ? "selected":"" }}>表示: 100件</option>
                </select>
            </div>
            <div class="col-sm mb-3">
                <button type="submit" class="btn btn-block btn-primary">検索</button>
            </div>
        </div>
    </form>

    <ul class="list-inline pt-3">
        <li class="list-inline-item">
            <a href="{{ route("admin.users.create") }}" class="btn btn-success">新規</a>
        </li>
    </ul>

    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>ID</th>
                <th>名称</th>
                <th>メールアドレス</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td><a href="{{ route("admin.users.show", $user->id) }}">{{ $user->name }}</a></td>
                    <td>{{ $user->email }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{ $users->appends(request()->all())->links() }}
@endsection
