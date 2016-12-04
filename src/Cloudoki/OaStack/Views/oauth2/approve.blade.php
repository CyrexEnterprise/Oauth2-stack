@extends('oastack::master')

@section('content')

<article class="panel panel-default">

	<div class="panel-heading">
		<h3 class="panel-title">{{ trans('oastack::oauth2.user.approve.title', (array) $client) }}</h3>
	</div>

	<div class="panel-body cp-panel-content">
		
		<p class="cp-info">{{ trans('oastack::oauth2.user.approve.info', (array) $client) }}</p>
		
		{!! Form::open (['before' => 'csrf', 'action'=> ['\Cloudoki\OaStack\Controllers\OaStackViewController@approve', 'approve'=> $user->id, 'session_token'=> $session_token]]) !!}
			
		<div class="btn-group cp-input" role="group">
			{!! Form::submit(trans('oastack::oauth2.user.approve.allow'), ['class'=> 'btn btn-default form-btn']) !!}
			<a href="logout" type="button" class="btn btn-default cp-btn">{{ trans('oastack::oauth2.user.approve.deny') }}</a>
		</div>
		
		{!! Form::close () !!}

	</div>
	
	<div class="panel-footer">
	
		{{ trans('oastack::oauth2.user.approve.footer', (array) $user) }}
		
	</div>
	
</article>

@stop