@extends('facebook.layout')

<script type="text/javascript">
	var myWindow;
	var url = '{{$data->loginUrl}}';
	url = url.replace(/amp;/g, '');

	function openTab () {
		myWindow = window.open(url,'Login with Facebook', 'width=700,height=500');

		var timeInterval = setInterval(function () {

			if(myWindow.closed) {
				location.reload();
				clearInterval(timeInterval);
			}

		},100);
	}

</script>

@section('content')

	@if ($data->loggedIn == true)
		<div class="content">
	      <div class="info-facebook text-center">
	          <h4><i class="glyphicon glyphicon-user"></i> <b>{{$data->profile['name']}}</b> and your id is: <i class="glyphicon glyphicon-info-sign"></i> <b>{{$data->profile['id']}}</b></h4></div>
	      <div class="all-page">
	      	@if(!empty($data->allPage))
		      	@foreach ($data->allPage as $key=>$value)
		          <div class="one-page" style="animation-delay: {{0.2 * $key}}s">
		              <div class="avatar"><img src="{{$value['avatar']}}"></div>
		              <div class="info-page">
	                  <div class="info-page-text">
	                    <h4 class="page-name">{{$value['name']}}</h4>
	                    <h4 class="page-id">ID: {{$value['page_id']}}</h4></div><a target="_blank" href="{!! url('facebook/page') . '/' . $value['page_id'] . '/add' !!}" class="select-page">SELECT</a></div>
		          </div>
		        @endforeach
		      @else
			      <div class="info-facebook text-center" style="padding: 50px 0">
			      	<h4><b>KHÔNG TÌM THẤY PAGE NÀO</b></h4>
			      </div>
		    	@endif
	      </div>
	  </div>
	@else
		<img src="public/images/facebook-login.png" onclick="openTab();">
	@endif

@endsection	