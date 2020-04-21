@extends('layouts.admin')

@section('content')
    <form class="shadow p-3 mt-3" action={{ route("admin.admin_users_list") }}>
        <div class="row">
            <div class="col-md-6 mb-3">
                <input type="text" class="form-control" id="name" name="name" value="{{ isset($para["name"]) ? $para["name"]:"" }}" placeholder="名称" />
            </div>
            <div class="col-md mb-3">
                <input type="text" class="form-control" id="email" name="email" value="{{ isset($para["email"]) ? $para["email"]:"" }}" placeholder="メールアドレス" />
            </div>
        </div>

        <div class="row">
            <div class="col-md mb-3">
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" id="authority-all" name="authority" value="" checked />
                    <label class="form-check-label" for="authority-all">すべての権限</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" id="authority-owner" name="authority" value="1" {{ isset($para["authority"]) && intval($para["authority"]) === 1 ? "checked":"" }} />
                    <label class="form-check-label" for="authority-owner">オーナー</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" id="authority-general" name="authority" value="0" {{ isset($para["authority"]) && intval($para["authority"]) === 0 ? "checked":"" }} />
                    <label class="form-check-label" for="authority-general">一般</label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <select class="custom-select" name="sort_column">
                    <option value="id">並び替え: ID</option>
                    <option value="name" {{ isset($para["sort_column"]) && $para["sort_column"] === "name" ? "selected":"" }}>並び替え: 名称</option>
                    <option value="email" {{ isset($para["sort_column"]) && $para["sort_column"] === "email" ? "selected":"" }}>並び替え: メールアドレス</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <select class="custom-select" name="sort_direction">
                    <option value="asc" {{ isset($para["sort_direction"]) && $para["sort_direction"] === "asc" ? "selected":"" }}>並び替え方向: 昇順</option>
                    <option value="desc" {{ isset($para["sort_direction"]) && $para["sort_direction"] === "desc" ? "selected":"" }}>並び替え方向: 降順</option>
                </select>
            </div>
            <div class="col-md-2 mb-3">
                <select class="custom-select" name="page_unit">
                    <option value="10">表示: 10件</option>
                    <option value="20" {{ isset($para["page_unit"]) && $para["page_unit"] == 20 ? "selected":"" }}>表示: 20件</option>
                    <option value="50" {{ isset($para["page_unit"]) && $para["page_unit"] == 50 ? "selected":"" }}>表示: 50件</option>
                    <option value="100" {{ isset($para["page_unit"]) && $para["page_unit"] == 100 ? "selected":"" }}>表示: 100件</option>
                </select>
            </div>
            <div class="col-sm mb-3">
                <button type="submit" class="btn btn-block btn-primary">検索</button>
            </div>
        </div>
    </form>

    <ul class="list-inline pt-3">
        <li class="list-inline-item">
            <a href="{{ route("admin.admin_users_create_page") }}" class="btn btn-success">新規</a>
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
            @foreach($adminUsers as $au)
                <tr>
                    <td>{{ $au->id }}</td>
                    <td><a href="{{ route("admin.admin_users_detail", ["id"=>$au->id]) }}">{{ $au->name }}</a></td>
                    <td>{{ $au->email }}</td>
                    <td>{{ $au->is_owner ? "オーナー":"一般" }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{ $adminUsers->appends($para)->links() }}
@endsection
