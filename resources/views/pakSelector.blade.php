@extends('layouts.index')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                ПАК
                <small>Информация</small>
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
                    <h3 class="box-title">Выбор учебного плана</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">

                        <select class="form-control">

                            <option>Факультет</option>

                            @foreach ($faculty as $fac)
                                <option>{{ $fac->FAKN }}</option>
                            @endforeach

                        </select>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Учебные планы</h3>
                            <div class="box-tools">
                                <div class="input-group input-group-sm" style="width: 200px;">
                                    <input name="table_search" class="form-control pull-right" placeholder="Поиск" type="text">

                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table class="table table-hover" style="margin-bottom: 0px; ">
                            <thead>
                            <tr>
                                <th style="width: 50px">Кафедра</th>
                                <th style="width: 120px">Заведующий</th>
                                <th>Форма</th>
                                <th style="width: 20px">Год</th>
                                <th>Номер</th>
                                <th>Наименование учебной программы</th>
                            </tr>
                            </thead>
                            <tbody>

                            @for ($i = 0; $i < 10; $i++)
                                <tr class="ng-hide" ng-show="selectedPlanTimeType.needHours == 1">
                                    <td>801 АУТС</td>
                                    <td>Митрошин В.Н.</td>
                                    <td>Б</td>
                                    <td>2016 </td>
                                    <td>27.03.0401</td>
                                    <td>Управление в технических системах / Управление и информатика в технических системах {{$i}}</td>
                                </tr>
                            @endfor


                            </tbody>
                        </table>
                    </div>
                </div>


            </div>




        </section>
        <!-- /.content -->
    </div>

@endsection
