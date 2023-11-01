@extends('layouts.main')

@section('titile', '店舗情報登録')

@section('content')
    <h1>店舗情報登録</h1>
    @if ($errors->any())
        <div class="error">
            @if ($errors->has('latitude'))
                {{-- {{ dd($errors->toArray()) }} --}}
                <p>
                    <b>{{ count($errors) - 1 }}件のエラーがあります。</b>
                </p>
                <ul>
                    @if ($errors->has('name'))
                        <li>{{ $errors->first('name') }}</li>
                    @endif
                    @if ($errors->has('description'))
                        <li>{{ $errors->first('description') }}</li>
                    @endif
                    @if ($errors->has('address'))
                        <li>{{ $errors->first('address') }}</li>
                    @endif
                    <li>マップをクリックして店舗の位置を取得してください</li>
                </ul>
            @else
                <p>
                    <b>{{ count($errors) }}件のエラーがあります。</b>
                </p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif
    <form action="{{ route('shops.store') }}" method="post">
        @csrf
        <div>
            <label for="name">店舗名:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}">

        </div>
        <div>
            <label for="description">詳細:</label>
            <textarea name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
        </div>
        <div>
            <label for="address">住所:</label>
            <input type="text" name="address" id="address" value="{{ old('address') }}">
        </div>
        {{-- map用 --}}
        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
        <div id="map" style="height: 50vh"></div>

        <div>
            <input type="submit" value="登録">
            <button type="button" onclick="location.href='{{ route('shops.index') }}'">一覧へ戻る</button>
        </div>
    </form>
@endsection

@section('script')
    @include('partial.map')

    <script>
        const lat = document.getElementById('latitude');
        const lng = document.getElementById('longitude');
        let clicked;
        map.on('click', function(e) {
            if (clicked !== true) {
                clicked = true;
                const marker = L.marker([e.latlng['lat'], e.latlng['lng']], {
                    draggable: true
                }).addTo(map);
                lat.value = e.latlng['lat'];
                lng.value = e.latlng['lng'];
                marker.on('dragend', function(e) {
                    // 座標は、e.target.getLatLng()で取得
                    lat.value = e.target.getLatLng()['lat'];
                    lng.value = e.target.getLatLng()['lng'];
                });
            }
        });

        //ピンを選択後にエラーになった場合にピンが消えないようにする処理
        @if (!empty(old('latitude')))
            clicked = true;
            const marker = L.marker([{{ old('latitude') }}, {{ old('longitude') }}], {
                    draggable: true
                })
                .addTo(map);

            marker.on('dragend', function(e) {
                lat.value = e.target.getLatLng()['lat'];
                lng.value = e.target.getLatLng()['lng'];
            });
        @endif
    </script>
@endsection
