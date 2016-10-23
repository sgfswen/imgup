@extends('layouts.app')

@section('title', 'Register')

@section('content')
 <div class="card text-xs-center" style="max-width: 500px; margin:auto;">
  <div class="card-block">
    <h2 class="card-title">Create an Account</h2>
    <form action="#">
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
        <input class="mdl-textfield__input" type="text" id="fname_id" name=fname>
        <label class="mdl-textfield__label" for="fname_id">First  Name</label>
      </div><br>
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
        <input class="mdl-textfield__input" type="text" id="lname_id" name="lname">
        <label class="mdl-textfield__label" for="lname_id">Last  Name</label>
      </div><br>
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
        <input class="mdl-textfield__input" type="email" id="email_id" name="email">
        <label class="mdl-textfield__label" for="email_id">Email</label>
      </div><br>
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
        <input class="mdl-textfield__input" type="text" id="user_id" name="username">
        <label class="mdl-textfield__label" for="user_id">Username</label>
      </div><br>
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
        <input class="mdl-textfield__input" type="password" id="pass1_id" name="pass1">
        <label class="mdl-textfield__label" for="pass1_id">Password</label>
      </div><br>
      <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
        <input class="mdl-textfield__input" type="password" id="pass2_id" name="pass2">
        <label class="mdl-textfield__label" for="pass2_id">Confirm Password</label>
      </div><br>
      <button role=submit class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
        Submit
      </button>
    </form>
  </div>
</div>
@endsection
