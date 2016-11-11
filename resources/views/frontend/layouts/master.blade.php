<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{ csrf_token() }}" />

        <title>Imgup</title>

        <!-- Meta -->
        <meta name="description" content="@yield('meta_description', 'Imgup: The simple, but elegant image host.')">
        <meta name="author" content="@yield('meta_author', 'William Fleming')">
        @yield('meta')

        <!-- Styles -->
        @yield('before-styles-end')

        
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://code.getmdl.io/1.2.1/material.blue-pink.min.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
	{{ Html::style(elixir('css/frontend.css')) }}	
	
	<!-- Check if the language is set to RTL, so apply the RTL layouts -->
        @langRTL
            {!! Html::style(elixir('css/rtl.css')) !!}
        @endif

        @yield('after-styles-end')

        <!-- Fonts -->
        {{ Html::style('https://fonts.googleapis.com/css?family=Roboto:100,300,400,700') }}
    </head>
    <body id="app-layout" style="font-family: 'Roboto', sans-serif">
        @include('includes.partials.logged-in-as')
        @include('frontend.includes.nav')

        <div class="container" style="margin-top: 100px;">
            @include('includes.partials.messages')
            @yield('content')
        </div><!-- container -->

        <!-- Scripts -->
	<script defer src="https://code.getmdl.io/1.2.1/material.min.js"></script>
        {{ HTML::script('https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js') }}
        <script>window.jQuery || document.write('<script src="{{asset('js/vendor/jquery/jquery-2.1.4.min.js')}}"><\/script>')</script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>
	
        @yield('before-scripts-end')
        {!! Html::script(elixir('js/frontend.js')) !!}
        @yield('after-scripts-end')

        @include('includes.partials.ga')
    </body>
</html>
