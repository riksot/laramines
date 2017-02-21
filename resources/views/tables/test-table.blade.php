@extends('layouts.index')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{$student->name}} ({{$student->kurs}} курс {{$student->gruppa}} группа)
                <small>Тестовая страница </small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="/">Главная</a> </li>

            </ol>
        </section>

        <section class="content">

            <div class="row">
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Протокол аттестации</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>


                            {{--
                            <input name="" class="form-control " placeholder="ФИО" type="text">
    --}}
                            {{--
                                                <div class="box-tools">
                                                    <div class="input-group" style="width: 300px;">

                                                    </div>
                                                </div>
                            --}}
                        </div>

                        <div class="box-body">
                            <div class="form-group">
                                <form action="/pak" method="get">
                                    <input type="hidden" name="studid" value="00000">
                                    {{ csrf_field() }}
                                    {{Session::put('studid','11111100000')}}
                                    {{--
                                                                    @if(isset($_REQUEST['id']))
                                                                        <div>{{$_REQUEST['id']}}</div>
                                                                    @endif
                                    --}}

                                    <button class="btn btn-primary" type="submit">Выбор учебного плана</button><br/>
                                </form>
                                <label>Претендующего на зачисление в порядке</label>
                                <select class="form-control-static" name="poryadok" id="" title="">
                                    <option value="1">Приёма</option>
                                    <option value="2">Перевода</option>
                                    <option value="3">Зачисления</option>
                                </select>
                                <label>на</label>
                                <select class="form-control-static" name="kurs" id="" title="">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                                <label>курс</label>
                                <input class="form-control-static" id="fakultet" placeholder="Заочного факультета" type="">
                            </div>
                            <div class="form-group">
                                <label>Для обучения по направлению подготовки (специальности)</label>
                                <input class="form-control " id="napravlenie" placeholder="ЗАПОЛНИТСЯ ПОСЛЕ ВЫБОРА УЧЕБНОГО ПЛАНА" type="" value="{{$plan->RPRKS.' '.$plan->RPRNAPR}}">
                                {{--<label>ЗАПОЛНИТСЯ ПОСЛЕ ВЫБОРА УЧЕБНОГО ПЛАНА</label>--}}
                            </div>
                            <div class="form-group">
                                <label>по образовательной программе</label>
                                <input class="form-control " id="programma" placeholder="ЗАПОЛНИТСЯ ПОСЛЕ ВЫБОРА УЧЕБНОГО ПЛАНА" type="" value="{{$plan->RPRSP.' '.$plan->RPRNS}}">
                                {{--<label>ЗАПОЛНИТСЯ ПОСЛЕ ВЫБОРА УЧЕБНОГО ПЛАНА</label>--}}
                            </div>
                            <div class="form-group">
                                <label>по результатам освоения в</label>
                                <input class="form-control " id="izuchVuz" placeholder="Наименование вуза" type="">
                            </div>
                            <div class="form-group">
                                <label>образовательной программы</label>
                                <input class="form-control" id="izuchProgramma" placeholder="Наименование программы" type="">
                            </div>
                            <div class="form-group">
                                <label>по направлению подготовки</label>
                                <input class="form-control" id="izuchNapravlenie" placeholder="Наименование направления" type="">
                            </div>

                        </div>

                    </div>
                </div>

                <div class="col-md-6">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Выводы аттестационной комиссии</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body" style="display: block;">
                            <div class="form-group">

                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td>Рекомендован к зачислению на</td>
                                        <td><div id="rekomKurs">XX курс, XX семестр</div></td>
                                    </tr>
                                    <tr>
                                        <td>Ориентировочный срок обучения</td>
                                        <td><div id="rekomSrok">XX года</div></td>
                                    </tr>
                                    <tr>
                                        <td>Итого зачетных единиц по учебному плану СамГТУ</td>
                                        <td><b><div id="itigoZet">XXXX</div></b></td>
                                    </tr>
                                    <tr>
                                        <td>Перезачтено, зачетных единиц</td>
                                        <td><b><div id="perezachZet">XXXX</div></b></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <label>Подписи</label>
                                <table class="table table-condensed">
                                    <tbody>
                                    <tr>
                                        <td>Декан заочного факультета</td>
                                        <td>Л.М.Инаходова </td>
                                    </tr>
                                    <tr>
                                        <td>Доцент кафедры</td>
                                        <td>И.И.Иванов </td>
                                    </tr>
                                    <tr>
                                        <td>Заведующий кафедрой</td>
                                        <td>И.И.Иванов</td>
                                    </tr>
                                    <tr>
                                        <td>Составитель протокола</td>
                                        <td>И.И.Иванов</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <label>Утверждаю</label>
                                <table class="table table-condensed">
                                    <tbody>
                                    <tr>
                                        <td>Проректор по ВЗО</td>
                                        <td>Г.В.Бичуров </td>
                                    </tr>
                                    <tr>
                                        <td>Дата</td>
                                        <td><input class="form-control" type="text" id="" ></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Печать</button>
                            <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Заголовок блока</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <table class="table-condensed table-bordered table-hover">
                                <thead>
                                <tr style="text-align: center;">
                                    <td rowspan="3">Индекс</td>
                                    <td rowspan="3">Наименование дисциплин учебного плана СамГТУ</td>
                                    <td colspan="8">ИЗУЧЕНО И ПЕРЕЗАЧТЕНО</td>
                                    <td width="80px;" rowspan="3">Результат аттестации <br/>(зачтено/ незачтено/ оценка)</td>
                                    <td colspan="2" rowspan="2">Всего подлежит изучению</td>
                                </tr>
                                <tr style="text-align: center;">
                                    <td colspan="6">Формы контроля</td>
                                    <td width="50px;" rowspan="2"><div >ЗЕТ</div></td>
                                    <td width="50px;" rowspan="2"><div >Часов</div></td>
                                </tr>
                                <tr style="text-align: center;">
                                    <td><div class="vertical-orient">Экзамен</div></td>
                                    <td><div class="vertical-orient">Зачет</div></td>
                                    <td><div class="vertical-orient">Зачет с оценкой</div></td>
                                    <td><div class="vertical-orient">Курсовой проект</div></td>
                                    <td><div class="vertical-orient">Курсовая работа</div></td>
                                    <td><div class="vertical-orient">Контрольная</div></td>
                                    <td width="50px;"><div >ЗЕТ</div></td>
                                    <td width="50px;"><div >Часов</div></td>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($discs as $disc)
                                    <tr class="ng-hide text-center">
                                        <td>
                                            {{$disc->UPIND}}
                                        </td>
                                        <td class="text-left">
                                            {{$disc->UPDSC}}
                                        </td>
                                        <td>
                                            <input type="checkbox" checked >
                                        </td>
                                        <td>
                                            <input type="checkbox">
                                        </td>
                                        <td>
                                            <input type="checkbox">
                                        </td>
                                        <td>
                                            <input type="checkbox">
                                        </td>
                                        <td>
                                            <input type="checkbox">
                                        </td>
                                        <td>
                                            <input type="checkbox">
                                        </td>
                                        <td>
                                            32
                                        </td>
                                        <td>
                                            10
                                        </td>
                                        <td>
                                            11
                                        </td>
                                        <td>
                                            12
                                        </td>
                                        <td>
                                            13
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

















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