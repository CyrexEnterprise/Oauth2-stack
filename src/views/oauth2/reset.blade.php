@extends('oastack::master')

@section('content')

<article class="panel panel-default">

	<div class="panel-heading">
		<h3 class="panel-title">{{ trans('oastack::oauth2.user.reset.title') }}</h3>
	</div>

	<div class="panel-body">
		
		@if ( !empty ($error) )
	
			<div class="alert alert-danger" role="alert">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<span class="sr-only">Error:</span>
				
				{{ $error }}
			</div>
			
			<input type="submit" class='btn btn-default' onclick="history.go(-1);" value="{{ trans('oastack::oauth2.user.forgot.retry') }}" />
			
		@else
			
			<p>{{ trans('oastack::oauth2.user.reset.info') }}</p>
			
		{{ Form::open (['before' => 'csrf', 'action'=> 
		   [
			'\Cloudoki\OaStack\OaStackViewController@changepassword',
			'reset_token'=> $reset_token
			]])
		}}
			
			<div class="input-group">
				{{ Form::label ('email', trans('oastack::oauth2.user.reset.email'), ['class'=> 'input-group-addon']) }}
				{{ Form::email ('email', '', ['required'=> 'required', 'class'=> 'form-control']) }}
			</div>
			<br>
			
			<div class="input-group">
				{{ Form::label ('password', trans('oastack::oauth2.user.reset.password'), ['class'=> 'input-group-addon']) }}
				{{ Form::password ('password', ['required'=> 'required', 'minlength'=> 6, 'class'=> 'form-control']) }}
				<span class="input-group-addon">{{trans('oastack::oauth2.user.reset.minchars')}}</span>
			</div>
			<br>
			
			<div class="input-group">
				{{ Form::label ('password_confirmation', trans('oastack::oauth2.user.reset.password_conf'), ['class'=> 'input-group-addon']) }}
				{{ Form::password ('password_confirmation', ['required'=> 'required', 'minlength'=> 6, 'class'=> 'form-control']) }}
			</div>
			<br>
			
			{{ Form::submit(trans('oastack::oauth2.user.reset.submit'), ['class'=> 'btn btn-primary']) }}
		
		{{ Form::close() }}
		
		@endif
	</div>
	
</article>

@stop