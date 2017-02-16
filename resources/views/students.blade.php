@extends('layouts.index')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Контенгент
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li class="active">Контенгент</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Выбор студента</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>

                        <div class="box-body" style="display: block;">
                                <label>Курс</label>
                                <select class="form-control select2 " name="" id="" title="kurs">
                                    <option></option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                                <label>Группа</label>
                                <select class="form-control select2 " name="" id="" title="group">
                                    <option></option>
                                    <option>33</option>
                                    <option>44</option>
                                    <option>55</option>
                                </select>

                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Список группы</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="box-body" style="display: block;">
                            <div class="form-group">
                                <label>
                                    Специальность (направление подготовки):
                                </label>
                                <label>
                                    13.03.02-4 Электроэнергетика и электротехника (профиль: Электроснабжение)
                                </label>
                                <table class="table table-bordered table-hover">
                                    <thead style="text-align: center;">
                                        <th>№</th>
                                        <th>Ф.И.О.</th>
                                    </thead>
                                    <tbody>
                                    @for($i=1; $i < 10; $i++)
                                        <tr class="ng-hide" id="{{$i}}">
                                            <td width="30px;">{{$i}}</td>
                                            <td>Иванов Иван Иванович</td>
                                        </tr>
                                    @endfor
                                    </tbody>
                                </table>

                            </div>


                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Новый студент</button>
                            <button type="submit" class="btn btn-primary">Печать списка</button>
{{--
                            <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
--}}
                        </div>
                    </div>
                </div>
            </div>


        </section>
        <!-- /.content -->
    </div>

@endsection
