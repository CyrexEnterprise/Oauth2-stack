@extends('master')

@section('content')


<article @if ( count ($errors) ) class="panel panel-warning" @else class="panel panel-default" @endif>

	<div class="panel-heading">
		<h3 class="panel-title">{{ trans('oastack::oauth2.user.subscribed.title', ['appname'=> Config::get ('app.name')]) }}</h3>
	</div>

	<div class="panel-body">

	@if ( count ($errors) )
		
		<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
			
			@foreach ($errors as $message) 
				{{ $message }}
				<br>
			@endforeach
		</div>
		
		<form action="">
			<input type="submit" class="btn btn-default" value='{{ trans('oastack::oauth2.user.subscribed.retry') }}' />
		</form>
		
	@else
		
		<p>{{ trans('oastack::oauth2.user.subscribed.info', ['account'=> $name]) }}</p>
		
		<a class="btn btn-default" href='{{ Config::get ('app.url') }}'>{{ trans('oastack::oauth2.user.subscribed.proceed') }}</a>
		
	@endif
	
	</div>
	
</article>

@stop