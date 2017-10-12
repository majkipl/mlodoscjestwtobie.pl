<section class="contact" id="contact">
    <div class="container">
        <h2>kontakt</h2>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                <div class="row">
                    <h3>Skontaktuj się z nami</h3>
                </div>
                <div class="row form" id="formContact">
                    <form class="form row" method="post" action="{{ route('front.contact.send') }}">
                        @csrf
                        <div class="col-xs-12 message">
                            <p></p>
                        </div>
                        <div class="col-xs-12 cf">
                            @component('components.forms.input.text', [
                                'name' => 'name',
                                'value' => '',
                                'placeholder' => 'Imię i  nazwisko',
                                'required' => true,
                                'max' => 128,
                                'error' => ''])
                            @endcomponent
                        </div>
                        <div class="col-xs-12 cf">
                            @component('components.forms.input.email', [
                                'name' => 'email',
                                'value' => '',
                                'placeholder' => 'Adres e-mail',
                                'required' => true,
                                'max' => 255,
                                'error' => ''])
                            @endcomponent
                        </div>
                        <div class="col-xs-12 cf">
                            @component('components.forms.textarea', [
                                'name' => 'message',
                                'value' => '',
                                'placeholder' => 'Treść wiadomości',
                                'required' => true,
                                'max' => 1024,
                                'error' => ''])
                            @endcomponent
                        </div>
                        <div class="col-xs-12 cf text-center">
                            <a href="#" class="send cta-button">wyślij</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
