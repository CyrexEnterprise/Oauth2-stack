@extends('oastack::master')

@section('content')


<article @if ( isset($error) ) class="panel panel-warning" @else class="panel panel-default" @endif>

	<div class="panel-heading">
		<h3 class="panel-title">{{ trans('oastack::oauth2.app.registered.title') }}</h3>
	</div>

	<div class="panel-body">

	@if ( isset ($error) )
	
		<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="sr-only">Error:</span>
			
			@foreach ($error as $message) 
				{{ $message }}
				<br>
			@endforeach
		</div>
		
		<input type="submit" class="btn btn-default" value='@if ( !empty ($error) ) {{ trans('oastack::oauth2.app.registered.retry') }} @else {{ trans('oastack::oauth2.app.registered.more') }} @endif' />
		
	@else
	
		<p>{{ trans('oastack::oauth2.app.registered.info') }}</p>
		
		<div class="well well-sm">
			<strong>{{ $name or "" }}</strong>
		</div>
		
		<div class="input-group">
			<label for="clientid" class="input-group-addon">{{ trans('oastack::oauth2.app.registered.client_id') }}</label>
			<div id="clientid" class="well well-sm form-control">{{ $id or '' }}</div>
			
			<span class="input-group-btn">
				<button class="btn btn-default" type="button">
					<span class="glyphicon glyphicon-copy" aria-hidden="true"></span>
				</button>
			</span>
		</div>
		<br>
		
		<div class="input-group">
			<label for="secret" class="input-group-addon">{{ trans('oastack::oauth2.app.registered.client_secret') }}</label>
			<div id="secret" class="well well-sm form-control">{{ $secret or '' }}</div>

			<span class="input-group-btn">
				<button class="btn btn-default" type="button">
					<span class="glyphicon glyphicon-copy" aria-hidden="true"></span>
				</button>
			</span>
		</div>
		<br>
		
		<div class="well well-sm">
			{{ $redirecturi or "" }}
		</div>

	@endif
	
	<input type="submit" class='btn btn-default' value='@if ( !empty ($error) ) {{ trans('oastack::oauth2.app.registered.retry') }} @else {{ trans('oastack::oauth2.app.registered.more') }} @endif' onclick="history.go(-1);" />
	
	
	</div>
	
</article>

@stop