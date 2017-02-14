@extends('layouts.index')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Test
                <small>Информация</small>
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
                            <h3 class="box-title">Проверка сортировок таблицы</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-hover" width="100%" cellspacing="0" id="table-plans">
                                <thead>
                                <tr>
                                    <th style="width: 50px">Кафедра</th>
                                    <th style="width: 120px">Заведующий</th>
                                    <th>Форма</th>
                                    <th style="width: 20px">Год</th>
                                    <th>Номер</th>
                                    <th>Наименование учебной программы</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>


                                <tr class="ng-hide" id="112">
                                    <td>301</td>
                                    <td></td>
                                    <td></td>
                                    <td>2011</td>
                                    <td>19.03.02</td>
                                    <td>Технология бродильных производств и виноделие</td>
                                    <td class="input-group-btn">

                                        <a href="/selectplan/?id=112" class="btn btn-xs"><i class="glyphicon glyphicon-triangle-right"></i></a>
                                    </td>
                                </tr>


                                <tr class="ng-hide" id="198">
                                    <td>302</td>
                                    <td></td>
                                    <td></td>
                                    <td>2012</td>
                                    <td>19.03.02</td>
                                    <td>Технология общественного питания</td>
                                    <td class="input-group-btn">

                                        <a href="/selectplan/?id=198" class="btn btn-xs"><i class="glyphicon glyphicon-triangle-right"></i></a>
                                    </td>
                                </tr>


                                <tr class="ng-hide" id="213">
                                    <td>301</td>
                                    <td></td>
                                    <td></td>
                                    <td>2011</td>
                                    <td>260501</td>
                                    <td>Технология продуктов общественного питания</td>
                                    <td class="input-group-btn">

                                        <a href="/selectplan/?id=213" class="btn btn-xs"><i class="glyphicon glyphicon-triangle-right"></i></a>
                                    </td>
                                </tr>


                                <tr class="ng-hide" id="15">
                                    <td>301</td>
                                    <td></td>
                                    <td></td>
                                    <td>2001</td>
                                    <td>260202</td>
                                    <td>Технология хлеба, кондитерских и макаронных изделий</td>
                                    <td class="input-group-btn">

                                        <a href="/selectplan/?id=15" class="btn btn-xs"><i class="glyphicon glyphicon-triangle-right"></i></a>
                                    </td>
                                </tr>


                                <tr class="ng-hide" id="16">
                                    <td>301</td>
                                    <td></td>
                                    <td></td>
                                    <td>2001</td>
                                    <td>260204</td>
                                    <td>Технология бродильных производств и виноделие</td>
                                    <td class="input-group-btn">

                                        <a href="/selectplan/?id=16" class="btn btn-xs"><i class="glyphicon glyphicon-triangle-right"></i></a>
                                    </td>
                                </tr>


                                <tr class="ng-hide" id="17">
                                    <td>301</td>
                                    <td></td>
                                    <td></td>
                                    <td>2001</td>
                                    <td>260402</td>
                                    <td>Технология жиров, эфирных масел  и парфюмерно-косметических продуктов</td>
                                    <td class="input-group-btn">

                                        <a href="/selectplan/?id=17" class="btn btn-xs"><i class="glyphicon glyphicon-triangle-right"></i></a>
                                    </td>
                                </tr>


                                <tr class="ng-hide" id="229">
                                    <td>302</td>
                                    <td></td>
                                    <td></td>
                                    <td>2013</td>
                                    <td>19.03.02</td>
                                    <td>Технология общественного питания</td>
                                    <td class="input-group-btn">

                                        <a href="/selectplan/?id=229" class="btn btn-xs"><i class="glyphicon glyphicon-triangle-right"></i></a>
                                    </td>
                                </tr>


                                <tr class="ng-hide" id="230">
                                    <td>301</td>
                                    <td></td>
                                    <td></td>
                                    <td>2013</td>
                                    <td>260501</td>
                                    <td>Технология продуктов общественного питания</td>
                                    <td class="input-group-btn">

                                        <a href="/selectplan/?id=230" class="btn btn-xs"><i class="glyphicon glyphicon-triangle-right"></i></a>
                                    </td>
                                </tr>


                                <tr class="ng-hide" id="231">
                                    <td>301</td>
                                    <td></td>
                                    <td></td>
                                    <td>2013</td>
                                    <td>260501</td>
                                    <td>Технология продуктов общественного питания</td>
                                    <td class="input-group-btn">

                                        <a href="/selectplan/?id=231" class="btn btn-xs"><i class="glyphicon glyphicon-triangle-right"></i></a>
                                    </td>
                                </tr>


                                <tr class="ng-hide" id="232">
                                    <td>301</td>
                                    <td></td>
                                    <td></td>
                                    <td>2013</td>
                                    <td>260501</td>
                                    <td>Технология продуктов общественного питания</td>
                                    <td class="input-group-btn">

                                        <a href="/selectplan/?id=232" class="btn btn-xs"><i class="glyphicon glyphicon-triangle-right"></i></a>
                                    </td>
                                </tr>


                                <tr class="ng-hide" id="308">
                                    <td>302</td>
                                    <td></td>
                                    <td></td>
                                    <td>2013</td>
                                    <td>19.03.02</td>
                                    <td>Технология общественного питания</td>
                                    <td class="input-group-btn">

                                        <a href="/selectplan/?id=308" class="btn btn-xs"><i class="glyphicon glyphicon-triangle-right"></i></a>
                                    </td>
                                </tr>


                                <tr class="ng-hide" id="309">
                                    <td>302</td>
                                    <td></td>
                                    <td></td>
                                    <td>2013</td>
                                    <td>19.03.02</td>
                                    <td>Технология общественного питания</td>
                                    <td class="input-group-btn">

                                        <a href="/selectplan/?id=309" class="btn btn-xs"><i class="glyphicon glyphicon-triangle-right"></i></a>
                                    </td>
                                </tr>


                                <tr class="ng-hide" id="310">
                                    <td>302</td>
                                    <td></td>
                                    <td></td>
                                    <td>2013</td>
                                    <td>19.03.02</td>
                                    <td>Технология общественного питания</td>
                                    <td class="input-group-btn">

                                        <a href="/selectplan/?id=310" class="btn btn-xs"><i class="glyphicon glyphicon-triangle-right"></i></a>
                                    </td>
                                </tr>


                                <tr class="ng-hide" id="311">
                                    <td>302</td>
                                    <td></td>
                                    <td></td>
                                    <td>2013</td>
                                    <td>19.03.02</td>
                                    <td>Технология общественного питания</td>
                                    <td class="input-group-btn">

                                        <a href="/selectplan/?id=311" class="btn btn-xs"><i class="glyphicon glyphicon-triangle-right"></i></a>
                                    </td>
                                </tr>


                                <tr class="ng-hide" id="312">
                                    <td>302</td>
                                    <td></td>
                                    <td></td>
                                    <td>2013</td>
                                    <td>260501</td>
                                    <td>Технология общественного питания</td>
                                    <td class="input-group-btn">

                                        <a href="/selectplan/?id=312" class="btn btn-xs"><i class="glyphicon glyphicon-triangle-right"></i></a>
                                    </td>
                                </tr>


                                <tr class="ng-hide" id="313">
                                    <td>302</td>
                                    <td></td>
                                    <td></td>
                                    <td>2013</td>
                                    <td>260501</td>
                                    <td>Технология общественного питания</td>
                                    <td class="input-group-btn">

                                        <a href="/selectplan/?id=313" class="btn btn-xs"><i class="glyphicon glyphicon-triangle-right"></i></a>
                                    </td>
                                </tr>


                                <tr class="ng-hide" id="314">
                                    <td>302</td>
                                    <td></td>
                                    <td></td>
                                    <td>2013</td>
                                    <td>260501</td>
                                    <td>Технология общественного питания</td>
                                    <td class="input-group-btn">

                                        <a href="/selectplan/?id=314" class="btn btn-xs"><i class="glyphicon glyphicon-triangle-right"></i></a>
                                    </td>
                                </tr>


                                <tr class="ng-hide" id="374">
                                    <td>302</td>
                                    <td></td>
                                    <td></td>
                                    <td>2015</td>
                                    <td>190302</td>
                                    <td>Технология продуктов общественного питания</td>
                                    <td class="input-group-btn">

                                        <a href="/selectplan/?id=374" class="btn btn-xs"><i class="glyphicon glyphicon-triangle-right"></i></a>
                                    </td>
                                </tr>


                                <tr class="ng-hide" id="375">
                                    <td>302</td>
                                    <td></td>
                                    <td></td>
                                    <td>2015</td>
                                    <td>190302</td>
                                    <td>Технология продуктов общественного питания</td>
                                    <td class="input-group-btn">

                                        <a href="/selectplan/?id=375" class="btn btn-xs"><i class="glyphicon glyphicon-triangle-right"></i></a>
                                    </td>
                                </tr>


                                <tr class="ng-hide" id="420">
                                    <td>301</td>
                                    <td></td>
                                    <td></td>
                                    <td>2015</td>
                                    <td>190401</td>
                                    <td>Биотехнология</td>
                                    <td class="input-group-btn">

                                        <a href="/selectplan/?id=420" class="btn btn-xs"><i class="glyphicon glyphicon-triangle-right"></i></a>
                                    </td>
                                </tr>


                                <tr class="ng-hide" id="469">
                                    <td>301</td>
                                    <td></td>
                                    <td></td>
                                    <td>2016</td>
                                    <td>190401</td>
                                    <td>Биотехнология функциональных продуктов питания и биологически активных веществ</td>
                                    <td class="input-group-btn">

                                        <a href="/selectplan/?id=469" class="btn btn-xs"><i class="glyphicon glyphicon-triangle-right"></i></a>
                                    </td>
                                </tr>


                                <tr class="ng-hide" id="495">
                                    <td>302</td>
                                    <td></td>
                                    <td></td>
                                    <td>2016</td>
                                    <td>190304</td>
                                    <td>Технология производства продуктов и организация общественного питания</td>
                                    <td class="input-group-btn">

                                        <a href="/selectplan/?id=495" class="btn btn-xs"><i class="glyphicon glyphicon-triangle-right"></i></a>
                                    </td>
                                </tr>


                                <tr class="ng-hide" id="496">
                                    <td>302</td>
                                    <td></td>
                                    <td></td>
                                    <td>2016</td>
                                    <td>190304</td>
                                    <td>Технология производства продуктов и организация общественного питания</td>
                                    <td class="input-group-btn">

                                        <a href="/selectplan/?id=496" class="btn btn-xs"><i class="glyphicon glyphicon-triangle-right"></i></a>
                                    </td>
                                </tr>


                                </tbody>                            </table>

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>

            <script type="text/javascript" src="adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
            <script type="text/javascript" src="adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script>
            <link rel="stylesheet" href="adminlte/plugins/datatables/jquery.dataTables.min.css">

            <script type="text/javascript">
                $(window).ready(function() {
                    $('#table-plans').DataTable({
                        "paging":   false,
                        "info":     false,
                        "language": {
                            "zeroRecords": "Ничего не найдено!",
                            "search": "Поиск:"
                        }
                    });
                });
            </script>




        </section>
    </div>

@endsection