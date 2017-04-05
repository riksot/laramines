@extends('layouts.index')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                ПАК
                <small>Выбор учебного плана</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li class="active">ПАК</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="box box-info">

                <div class="box-header with-border">
                    <h3 class="box-title">Факультет</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">

                        <select class="form-control select2 " name="fakults" id="fakults" title="facultet-selector">

                            <option></option>

                            @foreach ($faculty as $fac)
                                <option value="{{$fac->FAKID}}">{{ $fac->FAKN }}</option>
                            @endforeach

                        </select>
                    </div>
                </div>

            </div>

            <div id="getRequestData"></div>

        </section>
        <!-- /.content -->
    </div>

    <script type="text/javascript" src="adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script type="text/javascript">  // Вывод списка учебных планов при выборе факультета
        $('#fakults').on('change',function (e) {
//            console.log(e);
            var fakult = e.target.value;

            $.get('/ajax-plans?fakult='+fakult,function (data) {
                $('#getRequestData').empty();
                $('#getRequestData').append(data);
//                console.log(data);
            })
        })
    </script>


@endsection
