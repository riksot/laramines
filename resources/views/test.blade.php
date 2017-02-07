@extends('layouts.index')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Test
                <small>Информация</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="/">Главная</a></li>

            </ol>
        </section>

        <section class="content">
        <div class="box box-info">
            <div class="box-body">
                <h2>Get request</h2>
                <button type="button" class="btn btn-warning" id="getRequest">GetRequest</button>



                <div id="getRequestData"></div>
            </div>
        </div>

        </section>
    </div>

    <script type="text/javascript" src="adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#getRequest').click(function () {
               $.get('getRequest',function (data) {
                   $('#getRequestData').append(data);
                   console.log(data);
               });
                // alert($(this).text())
            });
        })
    </script>
@endsection