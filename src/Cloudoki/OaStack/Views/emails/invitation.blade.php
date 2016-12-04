@extends('oastack::emails.master')

@section('content')

<article class="panel panel-default">

	<div class="panel-heading">
		<h3 class="panel-title">{{ trans('oastack::emails.invite.title', ['account'=> $account]) }}</h3>
	</div>

	<div class="panel-body">
	
		<p>{{ trans('oastack::emails.invite.info', ['account'=> $account]) }}</p>
		<strong>{!! $url !!}</strong>
		
	</div>
	
	<div class="panel-footer">
	
		{{ trans('oastack::emails.invite.footer') }}
	
	</div>

	
</article>

@stop