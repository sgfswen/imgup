@extends('layouts.app')

@section('title', 'Sign In')

@section('sidebar')

@section('content')
<div class="card text-xs-center" style="max-width: 500px; margin:auto;">
  <div class="card-block">
    <h2 class="card-title">Welcome Back</h2>
    <h6 class="card-subtitle text-muted">Don't have an account? Register <a href="/accounts/login/">here</a>.</h6>
    <form action="#">
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
        <input class="mdl-textfield__input" type="text" id="user_id" name="username">
        <label class="mdl-textfield__label" for="user_id">Username</label>
      </div><br>
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
        <input class="mdl-textfield__input" type="password" id="pass_id" name="pass">
        <label class="mdl-textfield__label" for="pass_id">Password</label>
      </div><br>
      <button role=submit class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
        Login
      </button>
    </form>
  </div>
</div>    
@endsection
