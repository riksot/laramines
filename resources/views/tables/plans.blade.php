{{--
|--------------------------------------------------------------------------
| Выбор учебного плана
|--------------------------------------------------------------------------
--}}

<div class="row">
    <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Учебные планы</h3>
                <div class="box-tools">
                    <div class="input-group input-group-sm" style="width: 200px;">
{{--
                        <input name="table_search" class="form-control pull-right" placeholder="Поиск" type="text">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
--}}
                    </div>
                </div>
            </div>


            <table class="table table-hover" style="margin-bottom: 0px;" id="table-plans">
                <thead>
                <tr>
                    <th style="width: 30px">Каф.</th>
                    <th style="width: 120px">Заведующий</th>
                    <th>Форма</th>
                    <th style="width: 20px">Год</th>
                    <th>Номер</th>
                    <th>Наименование учебной программы</th>
                    <th data-orderable="false"></th>
                </tr>
                </thead>
                <tbody>

                @foreach ($plans as $plan)

                    <tr class="ng-hide" id="{{$plan->RPRID}}">
                        <td>{{$plan->RPRNK}}</td>
                        <td>{{$plan->KAFZAV}}</td>
                        <td>{{$plan->RPRKVF}}</td>
                        <td>{{$plan->RPRG}}</td>
                        <td>{{$plan->RPRKS}}</td>
                        <td>{{$plan->RPRNS}}</td>
                        <td class="input-group-btn">
                            <form action="/paklist" method="get">
                                <input type="hidden" name="planid" value="{{$plan->RPRID}}">
                                <input type="hidden" name="studid" value="{{Session::get('studid')}}">

                                <button class="btn btn-xs" type="submit"><i class="glyphicon glyphicon-triangle-right"></i></button>
                            </form>
{{--
                            <a href="/printplan/?id={{$plan->RPRID}}" class="btn btn-xs"><i class="fa fa-print"></i></a>
                            <button type="button" class="btn btn-info btn-flat"><a href="/editplan/?id={{$plan->RPRID}}" class="btn btn-xs"><i class="fa fa-edit"></i></a></button>
--}}
                        </td>
                    </tr>

                @endforeach

                </tbody>
            </table>
    </div>
    <script type="text/javascript"> // Вывод id строки
        $('tr.ng-hide').click(function () {
            console.log($(this).attr('id'));
//            location.href = '/selectplan/?id={{$plan->RPRID}}';
        });
    </script>

        <script type="text/javascript">
            $(window).ready(function() {
                $('#table-plans').DataTable({
                    "paging":   false,
                    "info":     false,
                    "language": {
                        "zeroRecords": "Ничего не найдено!",
                        "search": ""
                    }
                });
                $("div.box-tools div").replaceWith($("div.dataTables_filter"));
                $("div.dataTables_filter input").attr("placeholder", "Поиск");
                $('tr.ng-hide').css('cursor','pointer');
            });
        </script>
</div>







