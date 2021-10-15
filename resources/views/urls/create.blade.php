@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    @include('flash::message')
    <div class="jumbotron jumbotron-fluid bg-dark">
        <div class="container-lg">
            <div class="row">
                <div class="col-12 col-md-10 col-lg-8 mx-auto text-white">
                    <h1 class="display-3">Анализатор страниц</h1>
                    <p class="lead">Бесплатно проверяйте сайты на SEO пригодность</p>
                    {{ Form::open(['url' => route('urls.store'), 'class' => 'd-flex justify-content-center']) }}
                    {{ Form::text('url[name]', '', ['class' => 'form-control form-control-lg', 'placeholder' => 'https://example.com']) }}
                    {{ Form::submit('Проверить', ['class' => 'btn btn-primary btn-lg ml-3 px-3 text-uppercase']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
