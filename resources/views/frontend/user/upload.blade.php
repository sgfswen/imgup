@extends('frontend.layouts.master')
@section('content')


<div class="card text-xs-center mdl-shadow--2dp" style="padding:1%;">

        <h1 class="display-3">Upload Your Image</h1>
	<form action="" method="post" enctype="multipart/form-data">
	    <input type="file" name="file" id="file">
	    <input type="submit" value="Upload" name="submit">
	</form>

</div><!--container-->
@endsection

@section('after-scripts-end')
    <script>
        //Being injected from FrontendController
        console.log(test);
    </script>
@stop

