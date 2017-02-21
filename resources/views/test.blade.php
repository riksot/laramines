@extends('layouts.index')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Тестовая страница
                <small>{{$studid === null?'Нет идентификатора studid':$studid}}</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="/">Главная</a></li>

            </ol>
        </section>

        <section class="content">

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Заголовок блока</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">



















                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>




        </section>
    </div>

@endsection