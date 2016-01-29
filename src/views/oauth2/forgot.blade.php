@extends('oastack::master')

@section('content')

<article class="panel panel-default">

	<div class="panel-heading">
		<h3 class="panel-title">{{ trans('oastack::oauth2.user.forgot.title') }}</h3>
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
			
			<p>{{ trans('oastack::oauth2.user.forgot.info') }}</p>
			
		
	
		{{ Form::open (['before' => 'csrf', 'action'=> 
		   [
			'OaStackViewController@resetrequest',
			'client_id'=> Request::input ('client_id'), 'redirect_uri'=> Request::input ('redirect_uri'), 'response_type'=> Request::input ('response_type'), 'state'=> Request::input ('state')
			]])
		}}
			
			<div class="input-group">
				{{ Form::label ('email', trans('oastack::oauth2.user.forgot.email'), ['class'=> 'input-group-addon']) }}
				{{ Form::email ('email', '', ['required'=> 'required', 'class'=> 'form-control']) }}
			</div>
			<br>
			
			{{ Form::submit(trans('oastack::oauth2.user.forgot.submit'), ['class'=> 'btn btn-primary']) }}
			{{ Form::button(trans('oastack::oauth2.user.forgot.back'), ['onclick'=> 'history.go(-1);', 'class'=> 'btn btn-default']) }}
		
		{{ Form::close() }}
		
		@endif
	</div>
	
</article>

@stop