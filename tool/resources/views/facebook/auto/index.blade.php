@extends ('facebook.layout')

@section ('content')
<div class="page-post">
    <form action="{!! url('facebook/page/add') !!}" method="POST">
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <input type="hidden" name="page_id" value="{!! request()->id !!}">
        <input type="text" name="page_id_get" placeholder="Nhập link hoặc ID của Page cần lấy...">
        <div class="distance-time">
            <label for="distance_time">Số phút giữa mỗi lần get (>= 30 phút): </label>
            <input type="number" name="distance_time" value="30"> phút
        </div>
        <input type="submit" value="Submit">
    </form>
</div>
@endsection