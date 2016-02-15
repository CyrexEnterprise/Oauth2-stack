@extends('oastack::master')

@section('content')

<article class="panel panel-default">

	<div class="panel-heading">
		<h3 class="panel-title">{{ trans('oastack::oauth2.user.login.title') }}</h3>
	</div>

	<div class="panel-body">
		
		@if ( !empty ($error) )
	
			<div class="alert alert-danger" role="alert">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<span class="sr-only">Error:</span>
				
				{{ $error }}
			</div>
			
			<input type="submit" class='btn btn-default' onclick="history.go(-1);" value="{{ trans('oastack::oauth2.user.login.retry') }}" />
			
		@else
			
			<p>{{ trans('oastack::oauth2.user.login.info') }}</p>
			
		
	
		{{ Form::open (['before' => 'csrf', 'action'=> 
		   [
			'\Cloudoki\OaStack\Controllers\OaStackViewController@loginrequest',
			'client_id'=> Request::input ('client_id'), 'redirect_uri'=> Request::input ('redirect_uri'), 'response_type'=> Request::input ('response_type'), 'state'=> Request::input ('state')
			]])
		}}
			
			<div class="input-group">
				{{ Form::label ('email', trans('oastack::oauth2.user.login.email'), ['class'=> 'input-group-addon']) }}
				{{ Form::email ('email', '', ['required'=> 'required', 'class'=> 'form-control']) }}
			</div>
			<br>
			
			<div class="input-group">
				{{ Form::label ('password', trans('oastack::oauth2.user.login.password'), ['class'=> 'input-group-addon']) }}
				{{ Form::password ('password', ['required'=> 'required', 'class'=> 'form-control']) }}
			</div>
			<br>
			
			<a href="forgot" class="btn btn-link pull-right">{{ trans('oastack::oauth2.user.login.forgot') }}</a>
			
			{{ Form::submit(trans('oastack::oauth2.user.login.submit'), ['class'=> 'btn btn-default']) }}
		
		{{ Form::close() }}
		
		@endif
	</div>
	
</article>

@stop