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
    @for($i=1; $i < 10; $i++)
        <tr class="ng-hide text-center">
            <td>
                {{$i}}
            </td>
            <td class="text-left">
                Наименование дисциплины учебного плана учебного плана учебного плана СамГТУ учебного плана учебного плана СамГТУ учебного плана учебного плана СамГТУ
            </td>
            <td>
                <input type="checkbox" checked disabled>
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
    @endfor

    </tbody>
</table>