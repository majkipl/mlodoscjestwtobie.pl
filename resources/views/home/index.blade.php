@extends('layouts.front')

@section('content')

    @include('home.sections.baner')
    @include('home.sections.prizes')
    @include('home.sections.baner-take')

    @if($isEndContest)
{{--        @if($isEndPromotion)--}}
{{--            @if($isEndResult)--}}
{{--                section-take-end-result--}}
{{--                section-winner-end-result--}}
{{--            @else--}}
{{--                section-take-end-promotion--}}
{{--                section-winner-end-promotion--}}
{{--            @endif--}}
{{--        @else--}}
{{--            section-take-end-contest--}}
{{--            section-winner-end-contest--}}
{{--        @endif--}}
    @else
        @include('home.sections.take')
    @endif

    @include('home.sections.week')
    @include('home.sections.applications')
    @include('home.sections.products')
    @include('home.sections.baner-contact')
    @include('home.sections.contact')

@endsection
