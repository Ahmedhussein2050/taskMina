@extends('layout.index')
@section('title', _i('Brands'))

@section('main')
    <nav aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb py-4">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ _i('home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{$page->title}} </li>
            </ol>
        </div>
    </nav>
    <section class="categories-nav">
        <div class="container">
            <div class="d-lg-flex section-holder">
                {!! $page->content !!}
            </div>
        </div>
    </section>

@endsection
