@extends('oastack::master')

@section('content')

<article class="panel panel-default">

	<div class="panel-heading">
		<h3 class="panel-title">{{ trans('oastack::oauth2.app.register.title') }}</h3>
	</div>

	<div class="panel-body">
	
		<p>{{ trans('oastack::oauth2.app.register.info') }}</p>
	
		<form method="post" action="">
			
			<div class="input-group">
				<label for="name" class="input-group-addon">{{ trans('oastack::oauth2.app.register.app') }}</label>
				<input type="text" id="name" name="name" class="form-control" placeholder="Descriptive please" required>
			</div>
			<br>
			
			<div class="input-group">
				<label for="redirect" class="input-group-addon">{{ trans('oastack::oauth2.app.register.redirect') }}</label>
				<input type="url" id="redirect" name="redirect" class="form-control" placeholder="App url" required>
			</div>
			<br>
			
			<input type="submit" class="btn btn-default" value='{{ trans('oastack::oauth2.app.register.submit') }}' />
		
		</form>
	</div>
	
</article>

@stop