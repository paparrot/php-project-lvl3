@extends('layouts.app')

@section('title', "{{ $url->name }}")

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
        {{ Form::open(['url' => secure_url('url_checks.store', $url->id)]) }}
        @csrf
        {{ Form::submit('Запустить проверку', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}

        @if (!empty($checks))
            <table class="table table-bordered table-hover text-nowrap mt-3">
                <tr>
                    <th>ID</th>
                    <th>Код ответа</th>
                    <th>h1</th>
                    <th>keywords</th>
                    <th>description</th>
                    <th>Дата создания</th>
                </tr>
                @foreach ($checks as $check)
                    <tr>
                        <td>{{ $check->id }}</td>
                        <td>{{ $check->status_code }}</td>
                        <td>{{ Str::limit($check->h1, 10) }}</td>
                        <td>{{ Str::limit($check->keywords, 10) }}</td>
                        <td>{{ Str::limit($check->description, 10) }}</td>
                        <td>{{ $check->created_at }}</td>
                    </tr>
                @endforeach
            </table>
        @endif
        <div class="mt-3 d-flex">
            {{ $checks->links() }}
        </div>
    </div>

@endsection
