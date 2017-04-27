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
                            <table class="table-condensed table-bordered table-hover " id="table-plans" >
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
                                    <td width="20px;"><div class="vertical-orient">Экзамен</div></td>
                                    <td width="20px;"><div class="vertical-orient">Зачет</div></td>
                                    <td width="20px;"><div class="vertical-orient">Зачет с оценкой</div></td>
                                    <td width="20px;"><div class="vertical-orient">Курсовой проект</div></td>
                                    <td width="20px;"><div class="vertical-orient">Курсовая работа</div></td>
                                    <td width="20px;"><div class="vertical-orient">Контрольная</div></td>
                                    <td width="50px;"><div >ЗЕТ</div></td>
                                    <td width="50px;"><div >Часов</div></td>
                                </tr>
                                </thead>

{{--
                                <thead>
                                <tr>
                                    <th class="text-center">1</th>
                                    <th class="text-center">2</th>
                                    <th class="text-center">3</th>
                                    <th class="text-center">4</th>
                                    <th class="text-center">5</th>
                                    <th class="text-center">6</th>
                                    <th class="text-center">7</th>
                                    <th class="text-center">8</th>
                                    <th class="text-center">9</th>
                                    <th class="text-center">10</th>
                                    <th data-orderable="false" class="text-center">11</th>
                                    <th data-orderable="false" class="text-center">12</th>
                                    <th data-orderable="false" class="text-center">13</th>
                                </tr>
                                </thead>
--}}
                                <tbody>
                                @foreach($planAll as $disc)
                                    <tr class="ng-hide text-center
                                        @if(count(explode('.',$disc['НовИдДисциплины'])) > 3)
                                            @if((explode('.',$disc['НовИдДисциплины'])[2] == 'ДВ') AND(explode('.',$disc['НовИдДисциплины'])[count(explode('.',$disc['НовИдДисциплины']))-1] == '2'))
                                                text-gray
                                            @endif
                                        @endif
                                            ">
                                        <td>
                                            {{$disc['НовИдДисциплины']}}
                                        </td>
                                        <td class="text-left" >

                                            {{$disc['Дис'] }}
                                        </td>
                                        <td data-toggle="tooltip" data-original-title="Экзамен">
                                            @if(isset($disc['СемЭкз']))<input type="checkbox"> @endif
                                        </td>
                                        <td data-toggle="tooltip" data-original-title="Зачет">
                                            @if(isset($disc['СемЗач']))<input type="checkbox" @if(isset($disc['ИзученоЗач'])) checked @endif > @endif
                                        </td>
                                        <td data-toggle="tooltip" data-original-title="Зачет с оценкой">
                                            @if(isset($disc['СемЗачО']))<input type="checkbox"> @endif
                                        </td>
                                        <td data-toggle="tooltip" data-original-title="Курсовой проект">
                                            @if(isset($disc['СемКП']))<input type="checkbox"> @endif
                                        </td>
                                        <td data-toggle="tooltip" data-original-title="Курсовая работа">
                                            @if(isset($disc['СемКР']))<input type="checkbox"> @endif
                                        </td>
                                        <td data-toggle="tooltip" data-original-title="Контрольная">
                                            @if(isset($disc['КонтрРаб']))<input type="checkbox"> @endif
                                        </td>
                                        <td data-toggle="tooltip" data-original-title="ЗЕТ">
                                            @if(isset($disc['ПерезачетЧасов'])){{$disc['ПерезачетЧасов']/36}} @endif
                                        </td>
                                        <td data-toggle="tooltip" data-original-title="Часов">
                                            <input type="text" style="width: 40px;  text-align: center;" maxlength="5" value="{{$disc['ПерезачетЧасов']}}">
                                        </td>
                                        <td data-toggle="tooltip" data-original-title="Результат аттестации (зачтено/ незачтено/ оценка)">
                                            <select class=" " style="width: 50px;" name="" id="" title="" >
                                                <option></option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                                <option>Зач.</option>
                                            </select>
                                        </td>
                                        <td data-toggle="tooltip" data-original-title="ЗЕТ подлежит изучению">
                                            {{$disc['КредитовНаДисциплину']}}
                                        </td>
                                        <td data-toggle="tooltip" data-original-title="Часов подлежит изучению">
                                            {{$disc['ГОС']}}
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="box-footer">
                            <a class="btn btn-default" href="" target="_blank">
                                <i class="fa fa-print"></i>
                                Печать
                            </a>
                            <button type="button" class="btn btn-success pull-right"><i class="fa fa-bar-chart-o"></i> Пересчитать</button>
                            <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download" ></i> Скачать</button>
                        </div>
                    </div>
                </div>

            </div>





        </section>

    </div>



@endsection




