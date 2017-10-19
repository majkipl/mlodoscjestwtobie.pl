@extends('layouts.panel')

@section('content')
    <div class="container">
        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Kategoria</h1>
                </div>
            </div><!--/.row-->
            <form class="form row save" id="saveForm" method="{{ isset($category) ? 'put' : 'post' }}"
                  action="{{ route(isset($category) ? 'api.category.update' : 'api.category.add') }}">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                    @component('components.forms.input.text', [
                        'name' => 'name',
                        'value' => isset($category) ? $category->name : '',
                        'placeholder' => 'Nazwa',
                        'required' => true,
                        'max' => 128,
                        'error' => '',
                        ])
                    @endcomponent
                    </div>

                    <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                    @component('components.forms.input.text', [
                        'name' => 'slug',
                        'value' => isset($category) ? $category->slug : '',
                        'placeholder' => 'Slug',
                        'required' => true,
                        'max' => 128,
                        'error' => '',
                        ])
                    @endcomponent
                    </div>

                    <div class="col-12 col-lg-10 col-lg-offset-1 text-center">
                        <button class="button button-red mx-auto submit" type="submit">ZAPISZ</button>
                        @if(isset($category) && $category->id)
                            @component('components.forms.input.hidden', [
                                'name' => 'id',
                                'value' => $category->id,
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
