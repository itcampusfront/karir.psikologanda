<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" integrity="sha256-+N4/V/SbAFiW1MPBCXnfnP9QSN3+Keu+NlB+0ev/YKQ=" crossorigin="anonymous" />
	<title>Hasil Tes {{ $test }}</title>
	<link rel="shortcut icon" href="{{ asset('assets/images/icon.png') }}">
	<style>
	    @page, body {margin-bottom: 10px;, padding-top: 10px; padding-bottom: 10px;}
	    table {font-size: 13px;}
		table tr td {vertical-align: top;}
		.content {font-size: 13px;}
	    #header, #footer {position: fixed; left: 0; right: 0; color: #333; font-size: 0.9em;}
        #header {top: -20px; border-bottom: 0.1pt solid #aaa; text-align: right;}
        #header img {position: absolute; top: -3px; left: 0;}
	    #footer {bottom: 0; border-top: 0.1pt solid #aaa; text-align: right;}
	    .page-number {font-size: 12px;}
        .page-number:before {content: attr(data-nama) " | " attr(data-site) " | Page " counter(page);}
	</style>
</head>
<body>
    <script type="text/pdf">
        if(isset($pdf)){
            $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
            $size = 10;
            $font = $pdf->getDomPDF()->getFontMetrics()->getFont("helvetica");
            $width = $pdf->getDomPDF()->getFontMetrics()->getTextWidth($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 35;
            $pdf->getDomPDF()->getCanvas()->text($x, $y, $text, $font, $size);
        }
    </script>
    <div id="header">
        <img src="{{ asset('assets/images/logo-2-black.png') }}" height="20">
        <div class="page-number" data-nama="{{ $name }}" data-site="www.psikologanda.com"></div>
    </div>
    <h5 class="text-center font-weight-bold mt-3 mb-4">Hasil Tes {{ $test }}</h5>
    <table width="100%" border="0" style="margin-top: 20px;">
		<tr>
			<td width="50%">
				<table width="100%" border="0">
					{{-- <tr>
						<td align="center">Nama : {{ $name }}</td>
					</tr> --}}
					
				</table>
			</td>
			<td width="50%">
				<table width="100%" border="0">
					
				</table>
			</td>
		</tr>
    </table>
	<hr class="my-2">
	<div class="content">
		<h4 class="text-center font-weight-bold">{{ $tipe }}</h4>
		<p class="text-center"> {{ $kepanjangan }}</p>
	</div>
	<hr class="my-2">
	<div class="content" style="text-align: justify;">
		<div class="penjelasan mb-3">
			{{ $penjelasan }}
		</div>
		<div class="preferensi mb-3">
			<h3 class="fw-bold">Preferensi</h3>
			<ul>
				@for($i=0;$i<count($preferensi);$i++)
					<li>{{ $preferensi[$i] }}</li>
				@endfor
			</ul>
		</div>
		<div class="lingkungan mb-3">
			<h3 class="fw-bold">Lingkungan</h3>
			<ul>
				@for($i=0;$i<count($lingkungan);$i++)
					<li>{{ $lingkungan[$i] }}</li>
				@endfor
			</ul>
		</div>
		<div class="keseimbangan mb-3">
			<h3 class="fw-bold">Keseimbangan</h3>
			<ul>
				@for($i=0;$i<count($keseimbangan);$i++)
					<li>{{ $keseimbangan[$i] }}</li>
				@endfor
			</ul>
		</div>
		@if($pendukung != null)
		<div class="pendukung mb-3">
			<h3 class="fw-bold">Pendukung</h3>
			<ul>
				@for($i=0;$i<count($pendukung);$i++)
					<li>{{ $pendukung[$i] }}</li>
				@endfor
			</ul>
		</div>
		@endif
		<div class="penilaian1 mb-3">
			<h3 class="fw-bold">{{ $penilaian10 }}</h3>
			<ul>
				@for($i=0;$i<count($penilaian1);$i++)
				<li>{{ $penilaian1[$i] }}</li>
				@endfor
			</ul>
		</div>
		<div class="penilaian2 mb-3">
			<h3 class="fw-bold">{{ $penilaian20 }}</h3>
			<ul>	
			@for($i=0;$i<count($penilaian2);$i++)
				<li>{{ $penilaian2[$i] }}</li>
			@endfor
			</ul>
		</div>
	</div>
</body>
</html>