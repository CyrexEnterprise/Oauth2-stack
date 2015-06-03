@extends('oastack::master')

@section('content')

<article class="panel panel-default">

	@if ( empty ($error) )
	
	<div class="panel-heading">
		<h3 class="panel-title">{{ trans('oastack::oauth2.user.subscribe.title', ['account'=> $account['name']]) }}</h3>
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
		
		<p>{{ trans('oastack::oauth2.user.subscribe.info', ['account'=> $account['name']]) }}</p>
	
		{{ Form::open (['url' => '#']) }}
					
			<div class="input-group">
				{{ Form::label ('firstname', trans('oastack::oauth2.user.subscribe.firstname'), ['class'=> 'input-group-addon']) }}
				{{ Form::text ('firstname', $user['firstname'], ['placeholder'=> trans('oastack::oauth2.user.subscribe.fholder'), 'required'=> 'required', 'class'=> 'form-control']) }}
			</div>
			<br>
			
			<div class="input-group">
				{{ Form::label ('lastname', trans('oastack::oauth2.user.subscribe.lastname'), ['class'=> 'input-group-addon']) }}
				{{ Form::text ('lastname', $user['lastname'], ['placeholder'=> trans('oastack::oauth2.user.subscribe.lholder'), 'required'=> 'required', 'class'=> 'form-control']) }}
			</div>
			<br>
			
			<div class="input-group">
				{{ Form::label ('email', trans('oastack::oauth2.user.subscribe.email'), ['class'=> 'input-group-addon']) }}
				{{ Form::email ('email', $user['email'], ['placeholder'=> trans('oastack::oauth2.user.subscribe.eholder'), 'required'=> 'required', 'class'=> 'form-control']) }}
			</div>
			<br>
			
			<div class="input-group">
				
				{{ Form::label ('password', trans('oastack::oauth2.user.subscribe.password'), ['class'=> 'input-group-addon']) }}
				{{ Form::text ('password', '', ['placeholder'=> trans('oastack::oauth2.user.subscribe.pholder'), 'required'=> 'required', 'minlength'=> 6, 'class'=> 'form-control']) }}
				<span class="input-group-btn">
					<button type="button" class="btn btn-default">
						<span class="glyphicon glyphicon-cloud-download" aria-hidden="true" onclick="javascript:generate ();"></span>
					</button>
				</span>
			</div>
			<br>
			
			{{ Form::submit(trans('oastack::oauth2.user.subscribe.submit'), ['class'=> 'btn btn-default']) }}
		
		{{ Form::close () }}
		
		@endif
	</div>
	
	<div class="panel-footer">
	
		{{ trans ('oastack::oauth2.user.subscribe.footer') }}
		<a href="{{ Config::get ('oastack::config.privacy_url') }}">{{ Config::get ('oastack::config.privacy_url') }}</a>
		
	</div>
	
	<script type="application/javascript">
		
		function generate ()
		{
			// Some randomness
			if (window.crypto)
			{
				var numeric = new Uint32Array(2);
				window.crypto.getRandomValues (numeric);
			}
			else var numeric = ['01234','56789'];
			
			// Build password			
			var alphanum = numeric[0] + 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ#@&-+=!?_.' + numeric[1];
			var password = '';
			
			for (var n=0; n < 32; n++) password += alphanum[Math.floor(Math.random()*alphanum.length)];
			
			document.getElementById('password').value = password;
		}
		
	</script>
	
</article>

@stop