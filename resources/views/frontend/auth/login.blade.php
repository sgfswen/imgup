@extends('frontend.layouts.master')

@section('content')
            <div class="card" style="margin:auto; margin-top:50px; max-width:512px;">
                <div class="card-block">
		   <h4 class="card-title text-xs-center">Login</h4>	
                    {{ Form::open(['route' => 'auth.login', 'class' => 'form-horizontal']) }}

                    <div class="form-group">
                        {{ Form::label('email', trans('validation.attributes.frontend.email'), ['class' => 'col-md-4 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::input('email', 'email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.email')]) }}
                        </div><!--col-md-6-->
                    </div><!--form-group-->

                    <div class="form-group">
                        {{ Form::label('password', trans('validation.attributes.frontend.password'), ['class' => 'col-md-4 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.password')]) }}
                        </div><!--col-md-6-->
                    </div><!--form-group-->

                    @if (isset($captcha) && $captcha)
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {!! Form::captcha() !!}
                                {{ Form::hidden('captcha_status', 'true') }}
                            </div><!--col-md-6-->
                        </div><!--form-group-->
                    @endif
		    <div class="card-block">	
                    	<div class="form-group">    
                            <div class="checkbox">
                                <label>
                                    {{ Form::checkbox('remember') }} {{ trans('labels.frontend.auth.remember_me') }}
                                </label>
                            </div>
                    	</div><!--form-group-->
		  	
                    	<div class="form-group">
                            {{ Form::submit(trans('labels.frontend.auth.login_button'), ['class' => 'btn btn-primary', 'style' => 'margin-right:15px']) }}

                            {{ link_to('password/reset', trans('labels.frontend.passwords.forgot_password')) }}
                    	</div><!--form-group-->
		    </div><!-- Card Block -->	
                    {{ Form::close() }}

                    <div class="row text-center">
                        {!! $socialite_links !!}
                    </div>
                </div><!-- card block -->

            </div><!-- card -->

@endsection

@section('after-scripts-end')
    @if (isset($captcha) && $captcha)
        {!! Captcha::script() !!}
    @endif
@stop
