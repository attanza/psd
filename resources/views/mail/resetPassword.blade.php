@extends('mail.master')
@section('content')
<div class="content">
	<p>
		Dear {{$user->name}},
	</p>
	<p>
		Your password has been reset to <b>{{$hash}}</b> by Administrator. <br>
		Please change this temporary password immidietly.
	</p>
	<p>
		Thank you.
	</p>
	<hr>
	<p>
		<i>This email generated automaticaly by the System, do not reply this email.</i>
	</p>
</div>
@stop