@extends('layouts.app')

@section('title',"{{$url->name}}")

@section('content')
    @include("flash::message")
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
        <h2 class="mt-5 mb-3">Проверки</h2>
        {{ Form::open(['url' => route('url_check.store', $url->id)]) }}
        @csrf
        {{ Form::submit('Запустить проверку', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}

            @if(!empty($checks))
            <table class="table table-bordered table-hover text-nowrap mt-3">
                <tr>
                    <th>ID</th>
                    <th>Дата создания</th>
                    <th>Код ответа</th>
                </tr>
                @foreach($checks as $check)
                    <tr>
                        <td>{{$check->id}}</td>
                        <td>{{$check->created_at}}</td>
                        <td>{{$check->status_code}}</td>
                    </tr>
                @endforeach
            </table>
            @endif

    </div>

@endsection
