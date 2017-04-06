{{--
|--------------------------------------------------------------------------
| Создание списка студентов в группе
|--------------------------------------------------------------------------
--}}

<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Список группы</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body" style="display: block;">
        <div class="form-group">
            <label>
                Направление подготовки:
            </label>
            <label>
                {{$groupId}}
            </label>
            <table class="table table-bordered table-hover">
                <thead style="text-align: center;">
                <th>№</th>
                <th>Ф.И.О.</th>
                </thead>
                <tbody>
                @foreach($studentsList as $id => $student)
                    <tr class="ng-hide" id="{{$id+1}}">
                        <td width="30px;">{{$id+1}}</td>
                        <td>{{$student->name}}</td>
                        <td class="input-group-btn">
                            <form action="/paklist" method="get">
                                <input type="hidden" name="studentid" value="{{$student->id}}">
                                <button class="btn btn-xs" type="submit"><i class="glyphicon glyphicon-triangle-right"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>


    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <button type="submit" class="btn btn-primary">Новый студент</button>
        <button type="submit" class="btn btn-primary">Печать списка</button>
        {{--
                                    <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
        --}}
    </div>
</div>








