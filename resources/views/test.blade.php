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

                <select class="form-control" name="fakults" id="fakults">

                    <option></option>

                    @for ($i = 0; $i < 10; $i++)
                        <option value="{{$i}}">{{$i}}</option>
                    @endfor

                </select>


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
                   // console.log(data);
               });
                // alert($(this).text())
            });
        })
    </script>

    <script type="text/javascript">  // Вывод списка учебных планов
        $('#fakults').on('change',function (e) {
            console.log(e);
            var fakult = e.target.value;

            $.get('/ajax-plans?fakult='+fakult,function (data) {
                $('#getRequestData').empty();
                $('#getRequestData').append(data);
                console.log(data);
            })
        })

    </script>

@endsection