{{--
|--------------------------------------------------------------------------
| Загруженный учебный план
 {{dd(array_get($planAll, 'Дисциплины'))}}

|--------------------------------------------------------------------------
--}}
@extends('layouts.index')

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Загруженный учебный план
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li class="active">Загруженный учебный план</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Учебный план</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>

                        <div class="box-body">
                            <h5>{{array_get($planAll, 'Информация')['Головная']}}</h5>
                            <h5>{{array_get($planAll, 'Информация')['ОбразовательноеУчреждение']}}</h5>
                            <h5>{{array_get($planAll, 'Информация')['СтруктурноеПодразделение']}}</h5>

                            <table class="col-sm-8">
                                <tr>
                                    <td class="col-sm-3" align="right">Направление:  </td>
                                    <td><b>{{array_get($planAll, 'Информация')['Направление']}}</b></td>
                                </tr>
                                <tr>
                                    <td class="col-sm-3" align="right">Профиль:  </td>
                                    <td><b>{{array_get($planAll, 'Информация')['Профиль']}}</b></td>
                                </tr>
                                <tr>
                                    <td class="col-sm-3" align="right">Код направления:  </td>
                                    <td><b>{{array_get($planAll, 'Информация')['КодНаправления']}}</b></td>
                                </tr>
                                <tr>
                                    <td class="col-sm-3" align="right">Год начала подготовки: </td>
                                    <td><b>{{array_get($planAll, 'Информация')['ГодНачалаПодготовки']}}</b></td>
                                </tr>
                                <tr>
                                    <td class="col-sm-3" align="right">Квалификация: </td>
                                    <td><b>{{array_get($planAll, 'Информация')['Квалификация']}}</b></td>
                                </tr>
                                <tr>
                                    <td class="col-sm-3" align="right">Срок обучения: </td>
                                    <td><b>{{array_get($planAll, 'Информация')['СрокОбучения']}}</b></td>
                                </tr>
                            </table>


                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Дисциплины</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <table class="table-condensed table-bordered table-hover">
                                <thead>
                                <tr style="text-align: center;">
                                    <td rowspan="2">Индекс</td>
                                    <td rowspan="2">Наименование дисциплин учебного плана СамГТУ</td>
                                    <td rowspan="2" class="vertical-orient">Семестр</td>
                                    <td colspan="11">План СамГТУ</td>
                                    <td colspan="4">Объем перезачтенных часов</td>
                                    <td colspan="1" rowspan="2">Подлежит изучению</td>
                                </tr>

                                <tr style="text-align: center;">
                                    <td><div class="vertical-orient">Часы</div></td>
                                    <td><div class="vertical-orient">Лекции</div></td>
                                    <td><div class="vertical-orient">Лаборат.</div></td>
                                    <td><div class="vertical-orient">Практ.</div></td>
                                    <td><div class="vertical-orient">КСР</div></td>
                                    <td><div class="vertical-orient">СРС</div></td>
                                    <td><div class="vertical-orient">Контроль</div></td>
                                    <td><div class="vertical-orient">ЗЕТ</div></td>
                                    <td><div class="vertical-orient">Экз., зач.</div></td>
                                    <td><div class="vertical-orient">КП, КР</div></td>
                                    <td><div class="vertical-orient">Контр.раб.</div></td>
                                    <td><div class="">Часы, все</div></td>
                                    <td><div class="">Экз., зач.</div></td>
                                    <td><div class="">КП, КР</div></td>
                                    <td><div class="">ЗЕТ</div></td>
                                </tr>
                                </thead>
                                <tbody>

{{--================================================== Разбираем дисциплины=========================================--}}
                                @foreach (array_get($planAll, 'Дисциплины') as $disc)
                                    <tr class="ng-hide text-center">
                                        <td>
                                            {{array_get($disc, 'Индекс')}}
                                        </td>
                                        <td class="text-left">
                                            {{array_get($disc, 'Наименование')}}
                                        </td>
                                        <td>
                                            @if (array_get($disc, 'НомерСеместра'))
                                                {{array_get($disc, 'НомерСеместра')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if (array_get($disc, 'Часы'))
                                                {{array_get($disc, 'Часы')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if (array_get($disc, 'Лекции'))
                                                {{array_get($disc, 'Лекции')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if (array_get($disc, 'Лабораторные'))
                                                {{array_get($disc, 'Лабораторные')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if (array_get($disc, 'Практики'))
                                                {{array_get($disc, 'Практики')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if (array_get($disc, 'КСР'))
                                                {{array_get($disc, 'КСР')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if (array_get($disc, 'СРС'))
                                                {{array_get($disc, 'СРС')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if (array_get($disc, 'ЧасЭкз'))
                                                {{array_get($disc, 'ЧасЭкз')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if (array_get($disc, 'ЗЕТ'))
                                                {{array_get($disc, 'ЗЕТ')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if (array_get($disc, 'ВидКонтроля'))
                                                {{array_get($disc, 'ВидКонтроля')}}
                                            @endif
                                        </td>
                                        <td>
                                            @if (array_get($disc, 'КП'))
                                                КП
                                            @endif
                                            @if (array_get($disc, 'КР'))
                                                КР
                                            @endif
                                        </td>
                                        <td>
                                            @if (array_get($disc, 'КонтрольнаяРабота'))
                                                X
                                            @endif
                                        </td>
{{--========================================= Перезачтенные часы====================================================--}}
                                        <td> {{--Часы все--}}
                                            <input type="text" style="width: 40px;  text-align: center;" maxlength="5" >
                                        </td>
                                        <td> {{--Экз., зач. 1,2,3,4,5 Зач--}}
                                            <select class=" " style="width: 50px;" name="" id="" title="">
                                                <option></option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                                <option>Зач.</option>
                                            </select>
                                        </td>
                                        <td>{{--КП КР-- 1,2,3,4,5--}}
                                            @if (array_get($disc, 'КП'))
                                                <select class=" " style="width: 50px;" name="" id="" title="">
                                                    <option>КП</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                </select>                                            @endif
                                            @if (array_get($disc, 'КР'))
                                                <select class=" " style="width: 50px;" name="" id="" title="">
                                                    <option>КР</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                </select>                                            @endif
                                        </td>
                                        <td>{{-- ЗЕТ--}}
                                            <input type="text" style="width: 40px;  text-align: center;" maxlength="5" >
                                        </td>
                                        <td>{{-- Подлежит изучению --}}

                                        </td>
                                    </tr>
                                @endforeach
{{--=================================================== Разбираем практики =========================================--}}
                                @foreach (array_get($planAll, 'Практики') as $pract)
                                    <tr class="ng-hide text-center">
                                        <td>

                                        </td>
                                        <td class="text-left">
                                            {{array_get($pract, '@Наименование')}}
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                        </td>
                                        {{--========================================= Перезачтенные часы====================================================--}}
                                        <td> {{--Часы все--}}
                                            <input type="text" style="width: 40px;  text-align: center;" maxlength="5" >
                                        </td>
                                        <td> {{--Экз., зач.--}}
                                            <input type="text" style="width: 40px;  text-align: center;" maxlength="5" >
                                        </td>
                                        <td>{{--КП КР--}}
                                            <input type="text" style="width: 40px;  text-align: center;" maxlength="5" >
                                        </td>
                                        <td>{{-- ЗЕТ--}}
                                            <input type="text" style="width: 40px;  text-align: center;" maxlength="5" >
                                        </td>
                                        <td>{{-- Подлежит изучению --}}

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




