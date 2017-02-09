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
        <div class="box box-info">
            <div class="box-body">
                <h2>Get request</h2>
                <button type="button" class="btn btn-warning" id="getRequest">GetRequest</button>

                <select class="form-control" name="fakults" id="fakults" title="Facultet selector">

                    <option></option>

                    @for ($i = 0; $i < 10; $i++)
                        <option value="{{$i}}">{{$i}}</option>
                    @endfor

                </select>



                <div id="getRequestData">


                </div>
            </div>
        </div>

        </section>
    </div>

    <script type="text/javascript" src="adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script>

{{--    <script type="text/javascript"> // Определяем индекс строки/столбца
        $('tr').on('click', function () {
            console.log($(this).attr('id'));
            alert($(this).attr('id'));
//            console.log($(this).index());
        });
    </script>--}}





    /*
        $('tbody > tr').on('click', '.ng-hide', function() {
            var it = $(this).children('td').find('id').alert;
            console.log(it);
        });


        $('#plan-id').click(function () {
            //alert($(this).text());
        })
*/




    <script type="text/javascript"> // Вывод сообщения после нажатия кнопки
        $(document).ready(function () {
            $('#getRequest').click(function () {
               $.get('getRequest',function (data) {
                   $('#getRequestData').append(data);
                   // console.log(data);
               });
                // alert($(this).text())
            });
            $('h2').click(function () {
                console.log($(this).attr('id'));
                alert($(this).attr('id'));
            });
        })

    </script>

    <script type="text/javascript">  // Вывод списка учебных планов
        $('#fakults').on('change',function (e) {
//            console.log(e);
            var fakult = e.target.value;

            $.get('/ajax-plans?fakult='+fakult,function (data) {
                $('#getRequestData').empty();
                $('#getRequestData').append(data);
//                console.log(data);
            })
        })
    </script>




@endsection