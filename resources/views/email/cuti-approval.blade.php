<p><strong>Dear Bapak/Ibu {{ $atasan->name }}</strong>,</p>
<p> {{ $user->name }} / {{ $user->nik }} mengajukan Cuti dan butuh persetujuan Anda.</p>

<table>
	<thead>
		<tr>
			<th style="text-align: left;">Tanggal Cuti / Izin </th>
			<th style="text-align: left;"> : {{ date('d F Y', strtotime($cuti->tanggal_cuti_start)) }} - {{ date('d F Y', strtotime($cuti->tanggal_cuti_end)) }}</th>
		</tr>
		<tr>
			<th style="text-align: left;">Jenis Cuti / Izin </th>
			<th style="text-align: left;"> : {{ isset($cuti->cuti) ? $cuti->cuti->jenis_cuti : '' }}</th>
		</tr>
		<tr>
			<th style="text-align: left;">Lama Cuti / Izin </th>
			<th style="text-align: left;"> : {{ $cuti->total_cuti }} Hari</th>
		</tr>
		<tr>
			<th style="text-align: left;">Keperluan</th>
			<th style="text-align: left;"> : {{ $cuti->keperluan }}</th>
		</tr>
	</thead>
</table>
<br />	
<hr />