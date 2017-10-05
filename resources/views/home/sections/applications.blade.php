<section class="applications" id="applications">
    <div class="container">
        <h2>zgłoszenia</h2>
        <div class="row">
            <div class="col-xs-12 col-sm-7">
                @if($isEndContest)
                    <p>Dziękujemy wszystkim za zgłoszenia!</p>
                @else
                    <p>Wiek to tylko liczba. Masz tyle lat, na ile się czujesz, bo młodość jest w Tobie! Pokaż nam swój
                        sposób na to, by czuć się młodo i wygraj wyjątkowe nagrody. Razem z Red Lipstick Monster czekamy
                        na Twoje zgłoszenie!</p>
                @endif
            </div>
            <div class="col-xs-12 col-sm-5 search">
                <div class="row">
                    <div class="col-xs-12">
                        <input type="text" name="find" id="find" value="" placeholder="imię i nazwisko / tytuł pracy"
                               autocomplete="off"/>
                        <a href="#" class="submit"></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 list">
                <div class="row items"></div>
            </div>

            <div class="col-xs-12 text-center">
                <a href="#" id="getMoreItem" class="cta-button">POKAŻ WIĘCEJ</a>
            </div>
        </div>
    </div>
</section>
