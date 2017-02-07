<div class="row">
    <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Учебные планы</h3>
                <div class="box-tools">
                    <div class="input-group input-group-sm" style="width: 200px;">
                        <input name="table_search" class="form-control pull-right" placeholder="Поиск" type="text">

                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-hover" style="margin-bottom: 0px; ">
                <thead>
                <tr>
                    <th style="width: 50px">Кафедра</th>
                    <th style="width: 120px">Заведующий</th>
                    <th>Форма</th>
                    <th style="width: 20px">Год</th>
                    <th>Номер</th>
                    <th>Наименование учебной программы</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($plans as $plan)

                    <tr class="ng-hide" >
                        <td>{{$plan->RPRNK}}</td>
                        <td></td>
                        <td></td>
                        <td>{{$plan->RPRG}}</td>
                        <td>{{$plan->RPRKS}}</td>
                        <td>{{$plan->RPRNS}}</td>
                    </tr>

                @endforeach

                </tbody>
            </table>
        </div>
    </div>


</div>







