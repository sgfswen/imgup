

@extends('frontend.layouts.master')

@section('content')

<div class="card text-xs-center mdl-shadow--2dp" style="padding:1%;">
   	@if (access()->guest()) 		
        <h1 class="display-3">Imgup</h1>
       	<p class="lead">The elegant image host.</p>
	@else
	<h1 class="display-3">Upload</h1>
	<p class="lead">Get started by uploading an image.</p>
	@endif
	
       	<br>
	@if (access()->guest())
	  <p>{{ link_to('register', "Register", ['class' => 'mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent']) }}</p>
    	@else
	 
 	        <form action="{{ URL::to('upload') }}" method="post" enctype="multipart/form-data"> 
             	  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    		     <input class="mdl-textfield__input" type="text" name="filename" id="filename">
    		     <label class="mdl-textfield__label" for="filename">Image Title</label>
 	 	  </div>   
		   
		   <input type="file" name="file" id="file" style="display:none">
	           <label for="file" class="mdl-button mdl-js-button mdl-button--fab mdl-button--colored">
  			<i class="material-icons">add</i>
		   </label>
		   <br>
		   <Button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
  			Upload!
		   </Button>
		   <input type="hidden" value="{{ csrf_token() }}">
       		 </form>
	
 
	@endif	
    
</div><!--card-->



@endsection

@section('after-scripts-end')
    <script>
        //Being injected from FrontendController
        console.log(test);
    </script>
@stop
