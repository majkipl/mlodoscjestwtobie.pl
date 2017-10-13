@extends('layouts.front')

@section('content')

    <section class="thx" id="thx">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-lg-10 col-lg-offset-1">
                    <img src="{{ asset('images/thx/thx_03.jpg') }}" alt="arrow" class="baner-thx"/>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1 text-center thx-container">
                    <h2>Potwierdzenie zgłoszenia do promocji</h2>
                    <h1>Dziękujemy Ci za potwierdzenie zgłoszenia!</h1>
                    <div class="row">
                        <div class="col-xs-12 col-lg-10 col-lg-offset-1 text-center">
                            <p>Czerwona szminka GOSH zostanie wysłana na podany przez Ciebie adres w przeciągu 30 dni
                                roboczych od daty zweryfikowania poprawności Twojego zgłoszenia.</p>

                            <a href="/" class="cta-button"><span>WRÓĆ DO STRONY GŁÓWNEJ</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
