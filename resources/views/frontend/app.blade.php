<!DOCTYPE html>
<html>
    <head>
    <title>imgup - @yield('title')</title>
    
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- Roboto Font -->
	
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    
    <!-- MDL -->
    <link rel="stylesheet" href="https://code.getmdl.io/1.2.1/material.indigo-pink.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" >
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="http://104.236.81.1/custom.css">
    <style>
 	html, body {
	font-family: "Roboto", sans-serif;
	}
    </style>
   </head>
    <body>
    @section('sidebar')
        
   
   <nav class="navbar navbar-fixed-top navbar-dark bg-inverse">
      <div class="container">
        <a class="navbar-brand" href="#">imgup</a>
        <ul class="nav navbar-nav">
          <li class="nav-item active"><a class="nav-link" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#about">Sign In</a></li>
          <li class="nav-item"><a class="nav-link" href="/accounts/">Sign Up</a></li>
        </ul>
      </div><!-- /.container -->
    </nav><!-- /.navbar -->
     
    <div class="container">
         @yield('content')
    </div>
    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://code.getmdl.io/1.2.1/material.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js"></script>
    </body>
</html>
