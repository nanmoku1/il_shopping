@extends('layouts.admin')

@section('content')
    <form class="shadow p-3 mt-3" action={{ route("admin.admin_users_index") }}>
        <div class="row">
            <div class="col-md-6 mb-3">
                <input type="text" class="form-control" id="name" name="name" value="{{ isset($parameter["name"]) ? $parameter["name"]:"" }}" placeholder="名称" />
            </div>
            <div class="col-md mb-3">
                <input type="text" class="form-control" id="email" name="email" value="{{ isset($parameter["email"]) ? $parameter["email"]:"" }}" placeholder="メールアドレス" />
            </div>
        </div>

        <div class="row">
            <div class="col-md mb-3">
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" id="authority-all" name="authority" value="" checked />
                    <label class="form-check-label" for="authority-all">すべての権限</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" id="authority-owner" name="authority" value="1" {{ isset($parameter["authority"]) && intval($parameter["authority"]) === 1 ? "checked":"" }} />
                    <label class="form-check-label" for="authority-owner">オーナー</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" id="authority-general" name="authority" value="0" {{ isset($parameter["authority"]) && intval($parameter["authority"]) === 0 ? "checked":"" }} />
                    <label class="form-check-label" for="authority-general">一般</label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <select class="custom-select" name="sort_column">
                    <option value="id">並び替え: ID</option>
                    <option value="name" {{ isset($parameter["sort_column"]) && $parameter["sort_column"] === "name" ? "selected":"" }}>並び替え: 名称</option>
                    <option value="email" {{ isset($parameter["sort_column"]) && $parameter["sort_column"] === "email" ? "selected":"" }}>並び替え: メールアドレス</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <select class="custom-select" name="sort_direction">
                    <option value="asc" {{ isset($parameter["sort_direction"]) && $parameter["sort_direction"] === "asc" ? "selected":"" }}>並び替え方向: 昇順</option>
                    <option value="desc" {{ isset($parameter["sort_direction"]) && $parameter["sort_direction"] === "desc" ? "selected":"" }}>並び替え方向: 降順</option>
                </select>
            </div>
            <div class="col-md-2 mb-3">
                <select class="custom-select" name="page_unit">
                    <option value="10">表示: 10件</option>
                    <option value="20" {{ isset($parameter["page_unit"]) && $parameter["page_unit"] == 20 ? "selected":"" }}>表示: 20件</option>
                    <option value="50" {{ isset($parameter["page_unit"]) && $parameter["page_unit"] == 50 ? "selected":"" }}>表示: 50件</option>
                    <option value="100" {{ isset($parameter["page_unit"]) && $parameter["page_unit"] == 100 ? "selected":"" }}>表示: 100件</option>
                </select>
            </div>
            <div class="col-sm mb-3">
                <button type="submit" class="btn btn-block btn-primary">検索</button>
            </div>
        </div>
    </form>

    <ul class="list-inline pt-3">
        <li class="list-inline-item">
            <a href="{{ route("admin.admin_users_create") }}" class="btn btn-success">新規</a>
        </li>
    </ul>

    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>ID</th>
                <th>名称</th>
                <th>メールアドレス</th>
                <th>権限</th>
            </tr>
            </thead>
            <tbody>
            @foreach($admin_users as $admin_user)
                <tr>
                    <td>{{ $admin_user->id }}</td>
                    <td><a href="{{ route("admin.admin_users_show", $admin_user->id) }}">{{ $admin_user->name }}</a></td>
                    <td>{{ $admin_user->email }}</td>
                    <td>{{ $admin_user->is_owner ? "オーナー":"一般" }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{ $admin_users->appends($parameter)->links() }}
@endsection
