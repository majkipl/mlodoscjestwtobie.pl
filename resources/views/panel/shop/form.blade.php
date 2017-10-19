@extends('layouts.panel')

@section('content')
    <div class="container">
        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Sklep</h1>
                </div>
            </div><!--/.row-->
            <form class="form row save" id="saveForm" method="{{ isset($shop) ? 'put' : 'post' }}"
                  action="{{ route(isset($shop) ? 'api.shop.update' : 'api.shop.add') }}">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                        @component('components.forms.input.text', [
                            'name' => 'name',
                            'value' => isset($shop) ? $shop->name : '',
                            'placeholder' => 'Nazwa',
                            'required' => true,
                            'max' => 128,
                            'error' => '',
                            ])
                        @endcomponent
                    </div>

                    <div class="col-12 col-lg-10 col-lg-offset-1 text-center">
                        <button class="button button-red mx-auto submit" type="submit">ZAPISZ</button>
                        @if(isset($shop) && $shop->id)
                            @component('components.forms.input.hidden', [
                                'name' => 'id',
                                'value' => $shop->id,
                                'error' => '',
                                ])
                            @endcomponent
                        @endif
                    </div>
                </div><!--/.row-->
            </form>
        </div><!--/.main-->
    </div>
@endsection
