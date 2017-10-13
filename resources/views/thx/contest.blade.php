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
                    <h2>Potwierdzenie zgłoszenia do konkursu</h2>
                    <h1>Dziękujemy Ci za potwierdzenie zgłoszenia!</h1>
                    <div class="row">
                        <div class="col-xs-12 col-lg-10 col-lg-offset-1 text-center">
                            <p>Czerwona szminka GOSH zostanie wysłana na podany przez Ciebie adres w przeciągu 30 dni
                                roboczych od daty zweryfikowania poprawności Twojego zgłoszenia.</p>

                            <p>Twoje zgłoszenie zostanie opublikowane na naszej stronie po akceptacji przez Moderatora.
                                Życzymy Ci powodzenia i mamy nadzieję, że zobaczymy się na spotkaniu i warsztatach z Red
                                Lipstick Monster! Wyniki konkursu pojawią się na naszej stronie 18 stycznia 2018 r. </p>

                            <p>Nie zapomnij też udostępnić swojego zgłoszenia na FB lub Instagramie z hasztagiem <span>#remington80yearsyoung</span>
                                i grać o nagrody tygodnia! Co środę na naszej stronie znajdziesz wyróżnione zgłoszenia!
                            </p>

                            <a href="/" class="cta-button"><span>WRÓĆ DO STRONY GŁÓWNEJ</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
