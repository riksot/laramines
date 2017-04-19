{{--
|--------------------------------------------------------------------------
| Работа с учебным планом
|--------------------------------------------------------------------------
--}}
@extends('layouts.index')

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Учебный план
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('index')}}">Главная</a></li>
                <li class="active">Учебный план</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            @yield('plan')
        </section>
    </div>

@endsection




