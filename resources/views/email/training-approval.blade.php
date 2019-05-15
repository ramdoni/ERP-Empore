@extends('email.general')

@section('content')
{!! $text !!}

<table>
	<thead>
		<tr>
			<th style="text-align: left;">Business Trip Date </th>
			<th style="text-align: left;"> : {{ date('d F Y', strtotime($data->tanggal_kegiatan_start)) }} - {{ date('d F Y', strtotime($data->tanggal_kegiatan_end)) }}</th>
		</tr>
		<tr>
			<th style="text-align: left;">Business Trip Type </th>
			<th style="text-align: left;"> : {{ isset($item->trainingtype) ? $item->trainingtype->name:'' }}</th>
		</tr>
		<tr>
			<th style="text-align: left;">Destination </th>
			<th style="text-align: left;"> : {{ $data->tempat_tujuan }}</th>
		</tr>
		<tr>
			<th style="text-align: left;">Activity Topic </th>
			<th style="text-align: left;"> : {{ $data->topik_kegiatan }}</th>
		</tr>
	</thead>
</table>
<br />	



@endsection