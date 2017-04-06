@extends('layouts.index')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Контингент
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
                            <h3 class="box-title">Выбор группы</h3>
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
                                    <option value="6">6</option>
                                </select>

                                <label>Группа</label>
                                <select class="form-control select2 " name="group" id="group" title="group-selector">
                                </select>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Новый студент</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6" id="groupStudentsList">
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
                    "idKurs": e.target.value
                },
                success:function(data){
                    console.log(data);
                    $('#group').empty().append('<option></option>');
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
                    "idGroup": e.target.value,
                    "idKurs": $('#kurs option:selected').val()
                },
                success:function(data){
                    $('#groupStudentsList').empty().append(data);
                }
            });
        });
    </script>


@endsection
