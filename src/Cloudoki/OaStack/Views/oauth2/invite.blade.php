@extends('oastack::master')

@section('content')

<article class="panel panel-default">

	@if ( empty ($error) )
	
	<div class="panel-heading">
		<h3 class="panel-title">{{ trans('oastack::oauth2.user.invite.title') }}</h3>
	</div>
	
	@endif

	<div class="panel-body">
		
		@if ( !empty ($error) )
	
			<div class="alert alert-danger" role="alert">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<span class="sr-only">Error:</span>
				
				{{ $message }}
			</div>
			
		@else
		
		<p>{{ trans('oastack::oauth2.user.invite.info') }}</p>
	
		{{ Form::open (['url' => '#']) }}
					
			<div class="input-group">
				{{ Form::label ('firstname', trans('oastack::oauth2.user.invite.firstname'), ['class'=> 'input-group-addon']) }}
				{{ Form::text ('firstname', '', ['placeholder'=> trans('oastack::oauth2.user.invite.fholder'), 'required'=> 'required', 'class'=> 'form-control']) }}
			</div>
			<br>
			
			<div class="input-group">
				{{ Form::label ('lastname', trans('oastack::oauth2.user.invite.lastname'), ['class'=> 'input-group-addon']) }}
				{{ Form::text ('lastname', '', ['placeholder'=> trans('oastack::oauth2.user.invite.lholder'), 'required'=> 'required', 'class'=> 'form-control']) }}
			</div>
			<br>
			
			<div class="input-group">
				{{ Form::label ('email', trans('oastack::oauth2.user.invite.email'), ['class'=> 'input-group-addon']) }}
				{{ Form::email ('email', '', ['placeholder'=> trans('oastack::oauth2.user.invite.eholder'), 'required'=> 'required', 'class'=> 'form-control']) }}
			</div>
			<br>
			
			<div class="input-group">
				<span class="input-group-addon">{{ trans('oastack::oauth2.user.invite.account') }}</span>
				{{ Form::select('size', $accounts, ['class'=> 'input-group-addon']) }}
			</div>
			<br>
						
			{{ Form::submit(trans('oastack::oauth2.user.invite.submit'), ['class'=> 'btn btn-primary']) }}
		
		{{ Form::close () }}
		
		@endif
	</div>
	
	<div class="panel-footer">
	
		{{ trans ('oastack::oauth2.user.invite.footer') }}
		<a href="{{ Config::get ('oastack::config.privacy_url') }}">{{ Config::get ('oastack::config.privacy_url') }}</a>
		
	</div>
		
</article>

@stop