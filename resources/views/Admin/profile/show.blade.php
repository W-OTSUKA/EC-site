@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品情報詳細</h1>

    <a href="{{ route('Admin.dashboard') }}" class="btn btn-primary mt-3">商品一覧画面に戻る</a>

    <dl class="row mt-3" >
        <dt class="col-sm-3">商品情報ID</dt>
        <dd class="col-sm-9">{{ $item->id }}</dd>

        <dt class="col-sm-3">商品名</dt>
        <dd class="col-sm-9">{{ $item->name }}</dd>

        <dt class="col-sm-3">カテゴリー</dt>
        <dd class="col-sm-9">{{ $item->category->name }}</dd>

        <dt class="col-sm-3">価格</dt>
        <dd class="col-sm-9">{{ $item->price }}</dd>

        <dt class="col-sm-3">説明</dt>
        <dd class="col-sm-9">{{ $item->comment }}</dd>

        <dt class="col-sm-3">商品画像</dt>
        <dd class="col-sm-9"><img src="{{ asset($item->img_path) }}" width="300"></dd>
    </dl>
    <a href="{{ route('Admin.edit', $item) }}" class="btn btn-primary btn-sm mx-1">商品情報を編集する</a>

</div>
@endsection

