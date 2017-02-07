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
