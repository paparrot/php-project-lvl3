@extends('layouts.app')

@section('title',"{{$url->name}}")

@section('content')
    <div class="container">
        <h1 class="mt-5 mb-3">
            Сайт: {{ $url->name }}
        </h1>
        <table class="table table-bordered table-hovered">
            <tr>
                <td>ID</td>
                <td>{{ $url->id }}</td>
            </tr>
            <tr>
                <td>Имя</td>
                <td>{{ $url->name }}</td>
            </tr>
            <tr>
                <td>Дата создания</td>
                <td>{{ $url->created_at }}</td>
            </tr>
            <tr>
                <td>Дата обновления</td>
                <td>{{ $url->updated_at }}</td>
            </tr>
        </table>
    </div>
@endsection
