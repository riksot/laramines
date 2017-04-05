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

                                <select class="form-control select2 " name="kurs" id="kurs" title="kurs-selector">
                                    <option></option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>

                                <label>Группа</label>
                                <select class="form-control select2 " name="group" id="group" title="group-selector">

                                </select>
                        <div id="getRequestData"></div>
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

    <script type="text/javascript" src="adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script type="text/javascript">
        $('select[name=kurs]').on('change',function (e) {
            $.ajax({
                type:'POST',
                url:'/getListGroupsForStudents',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": e.target.value
                },
                success:function(data){
                    console.log(data);
                    $('#group').empty();
                    $.each(data, function (index, groups) {
                        $('#group').append('<option value="'+groups.id+'">'+groups.name+'</option>')
                    })
                }
            });
        });

        $('select[name=group]').on('change',function (e) {
            $.ajax({
                type:'POST',
                url:'/getListStudentsForStudents',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": e.target.value
                },
                success:function(data){
                    alert(data);
                }
            });
        });
    </script>


@endsection
