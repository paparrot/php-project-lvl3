@extends('layouts.app')

@section('title', 'Сайты')

@section('content')
    @include('flash::message')
    <div class="container-lg">
        <h1 class="mt-5 mb-3">Сайты</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Последняя проверка</th>
                    <th>Код ответа</th>
                </tr>
                @if (!empty($urls))

                    @foreach ($urls as $url)
                        <tr>
                            <td>{{ $url->id }}</td>
                            <td><a href="{{ route('urls.show', $url->id) }}">{{ $url->name }}</a></td>
                            <td>{{ $url->updated_at }}</td>
                            <td>{{ $checks[$url->id]->status_code ?? '' }}</td>
                        </tr>
                    @endforeach

                @endif
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {{ $urls->links() }}
        </div>
    </div>
@endsection
