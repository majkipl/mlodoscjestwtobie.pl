@extends('layouts.panel')

@section('content')
    <div class="container">
        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Zgłoszenie do konkursu</h1>
                </div>
            </div><!--/.row-->

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Zgłoszenie do konkursu {{ $contest->id }}</div>
                        <div class="panel-body">
                            <table class="item show data">
                                <tbody>
                                <tr>
                                    <td>Imię: </td>
                                    <td>{{ $contest->firstname }}</td>
                                </tr>
                                <tr>
                                    <td>Nazwisko: </td>
                                    <td>{{ $contest->lastname }}</td>
                                </tr>
                                <tr>
                                    <td>Data urodzenia: </td>
                                    <td>{{ $contest->birthday }}</td>
                                </tr>
                                <tr>
                                    <td>Adres e-mail: </td>
                                    <td>{{ $contest->email }}</td>
                                </tr>

                                <tr>
                                    <td>Tytuł: </td>
                                    <td>{{ $contest->title }}</td>
                                </tr>
                                <tr>
                                    <td>Wiadomość: </td>
                                    <td>{{ $contest->message }}</td>
                                </tr>
                                <tr>
                                    <td>Zdjęcie porady: </td>
                                    <td><img src="{{ asset('storage/' . $contest->img_tip) }}" alt="Dowód zakupu dla zgłoszenia: {{ $contest->id }}" /></td>
                                </tr>
                                <tr>
                                    <td>Video URL: </td>
                                    <td>{{ $contest->video_url }}</td>
                                </tr>
                                <tr>
                                    <td>Legal 1: </td>
                                    <td>{{ $contest->legal_1 }}</td>
                                </tr>
                                <tr>
                                    <td>Legal 2: </td>
                                    <td>{{ $contest->legal_2 }}</td>
                                </tr>
                                <tr>
                                    <td>Legal 3: </td>
                                    <td>{{ $contest->legal_3 }}</td>
                                </tr>
                                <tr>
                                    <td>Legal 4: </td>
                                    <td>{{ $contest->legal_4 }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div><!--/.row-->
        </div><!--/.main-->
    </div>
@endsection
