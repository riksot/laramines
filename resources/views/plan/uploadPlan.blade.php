@extends('plan.index')

@section('plan')


    <div class="row">
    <div class="col-xs-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Загрузка учебного плана</h3>
            </div>
            <div class="box-body">
                <form role="form" action="/uploadfile" method="post" enctype="multipart/form-data" >
                    <div class="box-body">
                        <div class="form-group">
                            <label for="uploadfile">Выбрать учебный план в формате xml</label>
                            <input id="uploadfile" type="file" name="uploadfile" accept="application/xml">
                            {{ csrf_field() }}
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Загрузить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection