@extends('oastack::emails.master')

@section('content')

<article class="panel panel-default">

	<div class="panel-heading">
		<h3 class="panel-title">{{ trans('oastack::emails.reset.title', ['firstname'=> $user->firstname]) }}</h3>
	</div>

	<div class="panel-body">
	
		<p>{{ trans('oastack::emails.reset.info', ['firstname'=> $user->firstname]) }}</p>
		<strong>{{ $url }}</strong>
		
	</div>
	
	<div class="panel-footer">
	
		{{ trans('oastack::emails.reset.footer') }}
	
	</div>

</article>

@stop