@extends('layouts.index')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h3> {{$student->name}} ({{$student->kurs}} курс, {{$student->groupname}} группа) </h3>
            <h1>{{$idPlan==null?null:$idPlan}}</h1>
            <button class="btn btn-primary" type="button">Протокол аттестации</button>
            <button class="btn btn-default" type="button">Титул</button>
            <button class="btn btn-default" type="button">График</button>
            <button class="btn btn-default" type="button">План</button>
            <button class="btn btn-default" type="button">Свод</button>
            <button class="btn btn-default" type="button">Индивидуальный график</button>
            <button class="btn btn-default" type="button">Зачетка</button>

            <ol class="breadcrumb">
                <li><a href="{{route('index')}}">Главная</a></li>
                <li><a href="{{route('students')}}">Контингент</a></li>
                <li class="active">Студент</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            @yield('student')
        </section>
        <!-- /.content -->
    </div>

@endsection
