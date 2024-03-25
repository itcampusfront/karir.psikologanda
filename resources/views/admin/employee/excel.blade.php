<table border="1">
	<tr>
		<td width="0"></td>
		<td align="center" width="5" style="background-color: #f88315;"><strong>No.</strong></td>
		<td align="center" width="40" style="background-color: #f88315;"><strong>Nama</strong></td>
		<td align="center" width="20" style="background-color: #f88315;"><strong>Tanggal Lahir</strong></td>
		<td align="center" width="20" style="background-color: #f88315;"><strong>Jenis Kelamin</strong></td>
		<td align="center" width="40" style="background-color: #f88315;"><strong>Email</strong></td>
		<td align="center" width="20" style="background-color: #f88315;"><strong>Nomor HP</strong></td>
		<td align="center" width="40" style="background-color: #f88315;"><strong>Alamat</strong></td>
		<td align="center" width="40" style="background-color: #f88315;"><strong>Pend. Terakhir</strong></td>
		<td align="center" width="20" style="background-color: #f88315;"><strong>Awal Bekerja</strong></td>
		<td align="center" width="40" style="background-color: #f88315;"><strong>Kantor</strong></td>
		<td align="center" width="40" style="background-color: #f88315;"><strong>Posisi</strong></td>
		<td align="center" width="40" style="background-color: #f88315;"><strong>Tujuan Pemeriksaan</strong></td>
		@if(Auth::user()->role->is_global === 1)
		<td align="center" width="40" style="background-color: #f88315;"><strong>Perusahaan</strong></td>
		@endif
	</tr>
	@foreach($employees as $key=>$employee)
	<tr>
		<td>{{ $employee->id }}</td>
		<td>{{ ($key+1) }}</td>
        <td>{{ $employee->user->name }}</td>
        <td>{{ $employee->birthdate != null ? date('d/m/Y', strtotime($employee->birthdate)) : '' }}</td>
        <td>{{ $employee->gender }}</td>
        <td>{{ $employee->email }}</td>
        <td>{{ $employee->phone_number }}</td>
        <td>{{ $employee->address }}</td>
        <td>{{ $employee->latest_education }}</td>
        <td>{{ $employee->start_date != null ? date('d/m/Y', strtotime($employee->start_date)) : '' }}</td>
        <td>{{ $employee->office ? $employee->office->name : '' }}</td>
        <td>{{ $employee->position ? $employee->position->name : '' }}</td>
		<td>{{ $employee->inspection }}</td>
		@if(Auth::user()->role->is_global === 1)
        <td>{{ $employee->company->name }}</td>
        @endif
	</tr>
	@endforeach
</table>