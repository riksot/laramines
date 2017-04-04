{{--
|--------------------------------------------------------------------------
| Утилиты
|--------------------------------------------------------------------------
--}}
@extends('layouts.index')

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Утилиты
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="/">Главная</a></li>
                <li class="active">Утилиты</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Добавление КСР в xml файл</h3>
                        </div>
                        <div class="box-body">
                            <form role="form" action="/uploadxmlfile" method="post" enctype="multipart/form-data" >
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="inputXMLFile">Выбрать учебный план в формате xml</label>
                                        <input id="inputXMLFile" type="file" name="uploadxmlfile" accept="application/xml">
                                        {{ csrf_field() }}
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary" id="sendxmlfile">Обработать файл</button>
                                    <div id="footxmlfile"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Подготовка карточки студента</h3>
                        </div>
                        <div class="box-body">
                            <form role="form" action="/makestudentcard" method="post" enctype="multipart/form-data" >
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="inputXMLFile">Выбрать учебный план в формате xml</label>
                                        <input id="inputXMLFile" type="file" name="file" accept="application/xml">
                                        {{ csrf_field() }}
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary" id="makestudentcard">Создать карточку</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>




    </div>



@endsection

{{--
<script type="text/javascript" src="adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script type="text/javascript">  // Вывод списка учебных планов при выборе факультета
    $('#sendxmlfile').on('click', function() {
        var file_data = $('#uploadxmlfile').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);

        $.ajax({
            url         : '/ajax-xml',     // point to server-side PHP script
            dataType    : 'text',           // what to expect back from the PHP script, if anything
            cache       : false,
            contentType : false,
            processData : false,
            data        : form_data,
            type        : 'post',
            success     : function(output){
                alert(output);              // display response from the PHP script, if any
            }
        });
        $('#uploadxmlfile').val('');                     /* Clear the file container */
    });
</script>
--}}
