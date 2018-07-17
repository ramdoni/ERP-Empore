<h3>Acceptance Report</h3>
<p>The company handover/deliver asset to employee with following detail:</p>
<table>
	<tr>
		<td>Employee Name</td>
		<td> : {{ $data->user->name }}</td>
	</tr>
	<tr>
		<td>Asset Number</td>
		<td> : {{ $data->asset_number }}</td>
	</tr>
	<tr>
		<td>Employee Name</td>
		<td> : {{ $data->asset_name }}</td>
	</tr>
	<tr>
		<td>Employee Name</td>
		<td> : {{ $data->asset_name }}</td>
	</tr>
	<tr>
		<td>Asset S/N or code</td>
		<td> : {{ $data->asset_sn }}</td>
	</tr>
</table>
<a href="{{ route('accept-asset', $data->id) }}" style="display: inline-block; padding: 11px 30px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #1e88e5; border-radius: 60px; text-decoration:none;">Accept</a>