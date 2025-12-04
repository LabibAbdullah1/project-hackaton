@extends('layouts.landing')

@section('content')

     {{-- HERO SECTION --}}
    @include('landing.sections.hero')


    {{-- FEATURES SECTION --}}
    @include('landing.sections.features')

        {{-- CTA SECTION --}}
    @include('landing.sections.cta')

    {{-- TESTIMONIAL SECTION --}}
    @include('landing.sections.testimonials')


@endsection
