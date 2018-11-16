@extends('layouts.app')
@section('content')
	<h1>Inside cool.blade.php</h1>
	
	@if(isset($data['last_name']))
	{{{
		$data['last_name']
	}}}
	@else
		no last name set
	@endif

	@foreach ($data as $item)
		<li>
			{{{ $item }}}
		</li>
	@endforeach


	{{-- {{{
		$data['location']
	}}}
	 --}}

@stop