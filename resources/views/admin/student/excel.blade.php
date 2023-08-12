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
	@foreach($students as $key=>$student)
	<tr>
		<td>{{ $student->id }}</td>
		<td>{{ ($key+1) }}</td>
        <td>{{ $student->name }}</td>
        <td>{{ $student->attribute->birthdate != null ? date('d/m/Y', strtotime($student->attribute->birthdate)) : '' }}</td>
        <td>{{ $student->attribute->gender }}</td>
        <td>{{ $student->email }}</td>
        <td>{{ $student->attribute->phone_number }}</td>
        <td>{{ $student->attribute->address }}</td>
        <td>{{ $student->attribute->latest_education }}</td>
        <td>{{ $student->attribute->start_date != null ? date('d/m/Y', strtotime($student->attribute->start_date)) : '' }}</td>
        <td>{{ $student->attribute->office ? $student->attribute->office->name : '' }}</td>
        <td>{{ $student->attribute->position ? $student->attribute->position->name : '' }}</td>
		<td>{{ $student->attribute->inspection }}</td>
		@if(Auth::user()->role->is_global === 1)
        <td>{{ $student->attribute->company->name }}</td>
        @endif
	</tr>
	@endforeach
</table>