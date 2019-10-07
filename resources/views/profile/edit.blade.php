@extends('adminlte::page')

@section('title', 'CRM')

@section('content_header')
    <h1>Страница редактирования</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <div class="page-block">
                @include('_common._form')
            </div>
        </div>
        <div class="col-sm-6">
            <div class="page-block">
                <h3>Файлы сотрудника</h3>
            </div>
        </div>
    </div>
@stop
