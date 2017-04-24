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

{{--
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
                            <h5><b>{{array_get($planAll, 'Информация')['Направление']}}</b></h5>
                            <h5><b>{{array_get($planAll, 'Информация')['Профиль']}}</b></h5>

                            <table class="col-sm-12">
                                <tr>
                                    <td class="col-sm-2" align="right">Код направления:  </td>
                                    <td><b>{{array_get($planAll, 'Информация')['КодНаправления']}}</b></td>
                                </tr>
                                <tr>
                                    <td class="col-sm-2" align="right">Год начала подготовки: </td>
                                    <td><b>{{array_get($planAll, 'Информация')['ГодНачалаПодготовки']}}</b></td>
                                </tr>
                                <tr>
                                    <td class="col-sm-2" align="right">Квалификация: </td>
                                    <td><b>{{array_get($planAll, 'Информация')['Квалификация']}}</b></td>
                                </tr>
                                <tr>
                                    <td class="col-sm-2" align="right">Срок обучения: </td>
                                    <td><b>{{array_get($planAll, 'Информация')['СрокОбучения']}}</b></td>
                                </tr>

                                @if (array_get($planAll, 'Информация')['ВидыДеятельности'])
                                    <tr>
                                        <td class="col-sm-2" align="right" valign="top">Виды деятельности:  </td>
                                        <td><b>
                                                @foreach (array_get($planAll, 'Информация')['ВидыДеятельности'] as $item)
                                                    {{$item['@Название']}} <br/>
                                                @endforeach
                                            </b></td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Загрузить в базу</button>
                        </div>
                    </div>
                </div>
            </div>
--}}

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
                                @foreach($planAll as $disc)
                                    <tr class="ng-hide text-center">
                                        <td>
                                            {{$disc['НовИдДисциплины']}}
                                        </td>
                                        <td class="text-left">
                                            {{$disc['Дис']}}
                                        </td>
                                        <td>
                                            @if($disc['Экз'] == 1)<input type="checkbox">@endif
                                        </td>
                                        <td>
                                            @if($disc['Зач'] == 1)<input type="checkbox"> @endif
                                        </td>
                                        <td>
                                            @if($disc['ЗачО'] == 1)<input type="checkbox"> @endif
                                        </td>
                                        <td>
                                            @if($disc['КП'] == 1)<input type="checkbox"> @endif
                                        </td>
                                        <td>
                                            @if($disc['КР'] == 1)<input type="checkbox"> @endif
                                        </td>
                                        <td>
                                            @if($disc['КонтрРаб'] == 1)<input type="checkbox"> @endif
                                        </td>
                                        <td>
                                            {{$disc['ЗЕТ']}}
                                        </td>
                                        <td>
                                            <input type="text" style="width: 40px;  text-align: center;" maxlength="5" value="{{$disc['Часов']}}">
                                        </td>
                                        <td>
                                            1/1
                                        </td>
                                        <td>
                                            {{$disc['ЗЕТ']}}
                                        </td>
                                        <td>
                                            {{$disc['Часов']}}
                                        </td>
                                    </tr>
                                @endforeach

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
    </div>

@endsection




