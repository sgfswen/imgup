

@extends('frontend.layouts.master')

@section('content')
<div class="container">
    <div class="jumbotron">
       	<h1 class="display-3">Imgup</h1>
       	<p class="lead">The simple, but elegant image host.</p>
       	<br>
	@if (access()->guest())
	  <p>{{ link_to('register', "Register", ['class' => 'btn btn-lg btn-success']) }}</p>
    	@else
	  <p><a href="#" class="btn btn-lg btn-success">Upload</a></p> 
	@endif	
    </div>
</div><!--container-->
@endsection

@section('after-scripts-end')
    <script>
        //Being injected from FrontendController
        console.log(test);
    </script>
@stop
