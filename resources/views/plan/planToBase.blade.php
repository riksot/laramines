@extends('plan.index')

@section('plan')


    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Загрузка учебного плана в базу</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>

                <div class="box-body">
                    <h5>{{array_get($planAll, 'Головная')}}</h5>
                    <h5>{{array_get($planAll, 'ИмяВуза')}}</h5>
                    <h5>{{array_get($planAll, 'ИмяВуза2')}}</h5>
                    <h5><b>{{array_get($planAll, 'Направление')}}</b></h5>
                    <h5><b>{{array_get($planAll, 'Профиль')}}</b></h5>

                    <table class="col-sm-12">
                        <tr>
                            <td class="col-sm-2" align="right">Код направления:  </td>
                            <td> {{array_get($planAll, 'ПоследнийШифр')}} </td>
                        </tr>
                        <tr>
                            <td class="col-sm-2" align="right">Год начала подготовки: </td>
                            <td>{{array_get($planAll, 'ГодНачалаПодготовки')}}</td>
                        </tr>
                        <tr>
                            <td class="col-sm-2" align="right">Квалификация: </td>
                            <td>{{array_get($planAll, 'Квалификация')}}</td>
                        </tr>
                        <tr>
                            <td class="col-sm-2" align="right">Срок обучения: </td>
                            <td> {{array_get($planAll, 'СрокОбучения')}} </td>
                        </tr>


                    </table>
                </div>
                <div class="box-footer">
                    <form role="form" action="/uploadfiletobase" method="post" enctype="multipart/form-data">
                        <input hidden name="filepath" value="{{$fileName}}">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary pull-right">Загрузить в базу</button>
                    </form>
{{--
                    <button type="submit" class="btn btn-primary pull-right">Загрузить в базу</button>
--}}

                </div>
            </div>
        </div>
    </div>

{{--
    <script type="text/javascript" src="adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script type="text/javascript">
        $('button').on('click',function (e) {
            $.ajax({
                type:'POST',
                url:'/uploadfiletobase',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "filepath": "{{$fileName}}"
                },
                success:function(data){
                    alert(data);
                }
            });
            $(this).prop("disabled", true);
        });
    </script>
--}}

@endsection