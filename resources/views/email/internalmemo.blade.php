@extends('email.general')

@section('content')
{!! $text !!}

<table>
	<thead>
		<tr>
			<th style="text-align: left;">Title </th>
			<th style="text-align: left;"> : {{ $data->title }}</th>
		</tr>
		<tr>
			<th style="text-align: left;">Description </th>
			<th style="text-align: left;"> : {{ $data->description }}</th>
		</tr>
	</thead>
</table>
<br />	



@endsection