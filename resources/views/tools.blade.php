{{--
|--------------------------------------------------------------------------
| Утилиты
|--------------------------------------------------------------------------
--}}
@extends('layouts.index')

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Утилиты
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li class="active">Утилиты</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Добавление КСР в xml файл</h3>
                        </div>
                        <div class="box-body">
                            <form role="form" action="/uploadxmlfile" method="post" enctype="multipart/form-data" >
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="exampleInputFile">Выбрать учебный план в формате xml</label>
                                        <input id="exampleInputFile" type="file" name="uploadxmlfile" accept="application/xml">
                                        {{ csrf_field() }}
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary" id="sendxmlfile">Обработать файл</button>
                                    <div id="footxmlfile"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>

    <script type="text/javascript" src="adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script type="text/javascript">  // Вывод списка учебных планов при выборе факультета
        $('#sendxmlfile').on('click',function (e) {
            //console.log(e);
           // var fakult = e.target.value;

            $.get('/ajax-plans?fakult='+fakult,function (data) {
                $('#footxmlfile').empty();
                $('#footxmlfile').append(data);
//                console.log(data);
            })
        })
    </script>



@endsection