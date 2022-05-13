@extends('layout.index')
@section('title', _i('Home'))

@section('main')
    @include('portal.include.slider')

    @include('portal.include.category')
    @include('portal.include.home_section')
    @include('portal.include.brands')
@endsection
