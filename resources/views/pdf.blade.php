<!DOCTYPE html>
<html lang="ru" >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Печать</title>
</head>
<style type="text/css">
    * {font-family: 'times';}
    html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary, time,mark,audio,video{margin:0;padding:0;border:0;font-size:100%;vertical-align:baseline}
    article,aside,details,figcaption,figure,footer,header,menu,nav,section{display:block;}

    table td.disc {text-align: left;}
    table td {font-size: 60%; border: solid 1px; word-wrap: break-word; text-align: center; padding: 1px;}
    body {padding: 10px;}
    table thead td {vertical-align: middle;}
</style>
<body>
<h3>Протокол аттестации</h3>

<div class="">
    <table class="" cellspacing="0" cellpadding="0">
        <thead>
        <tr style="text-align: center;">
            <td width="20px;" rowspan="3">Индекс</td>
            <td rowspan="3">Наименование дисциплин учебного плана СамГТУ</td>
            <td colspan="8">ИЗУЧЕНО И ПЕРЕЗАЧТЕНО</td>
            <td width="20px;" rowspan="3">Результат аттестации <br/>(зачтено/ незачтено/ оценка)</td>
            <td colspan="2" rowspan="2">Всего подлежит изучению</td>
        </tr>
        <tr style="text-align: center;">
            <td colspan="6">Формы контроля</td>
            <td width="20px;" rowspan="2">ЗЕТ</td>
            <td width="20px;" rowspan="2">Часов</td>
        </tr>
        <tr style="text-align: center;">
            <td width="20px;">Экз.</td>
            <td width="20px;">Зач.</td>
            <td width="20px;">Зач. с оц.</td>
            <td width="20px;">КП</td>
            <td width="20px;">КР</td>
            <td width="20px;">Кон.</td>
            <td width="20px;">ЗЕТ</td>
            <td width="20px;">Часов</td>
        </tr>
        </thead>
        <tbody>
        @for($i=1; $i < 11; $i++)
            <tr class="ng-hide">
                <td>
                    {{$i}}
                </td>
                <td class="disc">
                    Наименование дисциплин учебного плана СамГТУ Наименование дисциплин учебного плана СамГТУ
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


</body>
</html>
