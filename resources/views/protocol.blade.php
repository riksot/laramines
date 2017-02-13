@extends('layouts.index')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Протокол аттестации
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li class="active">ПАК</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-6">
                    <div class="box box-info">
                    <div class="box-header with-border">
    {{--
                        <h3 class="box-title">Протокол аттестации</h3>
    --}}
                        <input name="" class="form-control " placeholder="ФИО" type="text">
    {{--
                        <div class="box-tools">
                            <div class="input-group" style="width: 300px;">

                            </div>
                        </div>
    --}}
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <label>Претендующего на зачисление в порядке</label>
                            <select  name="" id="" title="">
                                <option>Приёма</option>
                                <option>Перевода</option>
                                <option>Зачисления</option>
                            </select>
                            <label>на</label>
                            <select name="" id="" title="">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                            <label>курс</label>
                            <input id="" placeholder="Заочного факультета" type="">
                        </div>
                        <div class="form-group">
                            <label>Для обучения по направлению подготовки (специальности)</label>
                            <input class="form-control " id="" placeholder="ЗАПОЛНИТСЯ ПОСЛЕ ВЫБОРА УЧЕБНОГО ПЛАНА" type="">
                            {{--<label>ЗАПОЛНИТСЯ ПОСЛЕ ВЫБОРА УЧЕБНОГО ПЛАНА</label>--}}
                        </div>
                        <div class="form-group">
                            <label">по образовательной программе</label>
                            <input class="form-control " id="" placeholder="ЗАПОЛНИТСЯ ПОСЛЕ ВЫБОРА УЧЕБНОГО ПЛАНА" type="">
                            {{--<label>ЗАПОЛНИТСЯ ПОСЛЕ ВЫБОРА УЧЕБНОГО ПЛАНА</label>--}}
                        </div>
                        <div class="form-group">
                            <label>по результатам освоения в</label>
                            <input class="form-control " id="" placeholder="Наименование вуза" type="">
                        </div>
                        <div class="form-group">
                            <label>образовательной программы</label>
                            <input class="form-control" id="" placeholder="Наименование программы" type="">
                        </div>
                        <div class="form-group">
                            <label>по направлению подготовки</label>
                            <input class="form-control" id="" placeholder="Наименование направления" type="">
                        </div>

                    </div>

                </div>
                </div>

                <div class="col-md-6">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Выводы аттестационной комиссии</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
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
                                        <td>XX курс, ХХ семестр</td>
                                    </tr>
                                    <tr>
                                        <td>Ориентировочный срок обучения</td>
                                        <td>== года</td>
                                    </tr>
                                    <tr>
                                        <td>Итого зачетных единиц по учебному плану СамГТУ</td>
                                        <td><b>ХХХХ</b></td>
                                    </tr>
                                    <tr>
                                        <td>Перезачтено, зачетных единиц</td>
                                        <td><b>ХХХХ</b></td>
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
                                        <td><input class="form-control" type="text" ></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Дисциплины</h3>
                        </div>
                        <div class="box-body">
                            <table class="table-condensed table-bordered table-hover">
                                <thead>
                                <tr style="text-align: center;">
                                    <td rowspan="3">Индекс</td>
                                    <td rowspan="3">Наименование дисциплин учебного плана СамГТУ</td>
                                    <td colspan="8">ИЗУЧЕНО И ПЕРЕЗАЧТЕНО</td>
                                    <td rowspan="3">Результат аттестации <br/>(зачтено/ незачтено/ оценка)</td>
                                    <td colspan="2" rowspan="2">Всего подлежит изучению</td>
                                </tr>
                                <tr style="text-align: center;">
                                    <td colspan="6">Формы контроля</td>
                                    <td width="50px;" rowspan="2">ЗЕТ</td>
                                    <td width="50px;" rowspan="2">Часов</td>
                                </tr>
                                <tr style="text-align: center;">
                                    <td width="80px;">Экзамены</td>
                                    <td width="80px;">Зачеты</td>
                                    <td width="80px;">Зачеты с оценкой</td>
                                    <td width="80px;">Курсовые проекты</td>
                                    <td width="80px;">Курсовые работы</td>
                                    <td width="80px;">Контрольные</td>
                                    <td width="50px;">ЗЕТ</td>
                                    <td width="50px;">Часов</td>
                                </tr>
                                </thead>
                                <tbody>
                                @for($i=1; $i < 10; $i++)
                                    <tr class="ng-hide">
                                        <td>
                                            {{$i}}
                                        </td>
                                        <td>
                                            Наименование дисциплин учебного плана СамГТУ
                                        </td>
                                        <td>
                                           3
                                        </td>
                                        <td>
                                           4
                                        </td>
                                        <td>
                                            5
                                        </td>
                                        <td>
                                            6
                                        </td>
                                        <td>
                                            7
                                        </td>
                                        <td>
                                            8
                                        </td>
                                        <td>
                                            9
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
                                @endfor

                                </tbody>
                            </table>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Пересчитать</button>
                        </div>
                    </div>
                </div>

            </div>

        </section>
        <!-- /.content -->
    </div>

@endsection
