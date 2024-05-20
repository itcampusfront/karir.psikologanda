<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts/admin/_head')
    @yield('css')

    <title>@yield('title') :: Sistem Rekruitmen | Promosi | Penjajakan Karyawan</title>
</head>
<body>
	<div class="wrapper">
        @include('layouts/admin/_sidebar')
        
		<div class="main">
            @include('layouts/admin/_header')

			<main class="content">
				<div class="container-fluid p-0">
                    @yield('content')
				</div>
			</main>

            @include('layouts/admin/_footer')

		</div>
	</div>
    
    @if(Auth::user()->role_id == role('super-admin'))
        @include('faturhelper::layouts/admin/_offcanvas')
    @endif

    @include('layouts/admin/_js')
    @yield('js')

    <script type="text/javascript">
        $('.checkbox-all').click(function(){
            if(this.checked){
                $('.checkbox1').each(function() {
                    this.checked = true;                        
                })
            }
            else{
                $('.checkbox1').each(function() {
                    this.checked = false;                        
                })
            }
        })

        function deleteAll(){
            var id = [];
            $('.checkbox1').each(function() {
                if(this.checked){
                    id.push($(this).val());
                }
            })
            $('input[name="id[]"]').val(id);

            if(id.length > 0){
                $('.form-deleteAll').submit();
            }
        }
    </script>
</body>
</html>