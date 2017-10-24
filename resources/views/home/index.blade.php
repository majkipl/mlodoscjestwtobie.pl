@extends('layouts.front')

@section('content')

    @include('home.sections.baner')
    @include('home.sections.prizes')
    @include('home.sections.baner-take')

    @if($isEndContest)
        @if($isEndPromotion)
            @if($isEndResult)
                @include('home.sections.take-end-result')
                @include('home.sections.winner-end-result')
            @else
                @include('home.sections.take-end-promotion')
                @include('home.sections.winner-end-promotion')
            @endif
        @else
            @include('home.sections.take-end-contest')
            @include('home.sections.winner-end-contest')
        @endif
    @else
        @include('home.sections.take')
    @endif

    @include('home.sections.week')
    @include('home.sections.applications')
    @include('home.sections.products')
    @include('home.sections.baner-contact')
    @include('home.sections.contact')

@endsection
