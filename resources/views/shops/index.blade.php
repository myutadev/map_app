@extends('layouts.main');

@section('titile', '店舗一覧')

@section('content')
    <h1>店舗一覧</h1>
    <ul>
        @foreach ($shops as $shop)
            <li><a href="{{ route('shops.show', $shop) }}">{{ $shop->name }}</a></li>
        @endforeach
    </ul>

    <button type="button" onclick="location.href='{{ route('shops.create') }}'">登録する</button>
@endsection
