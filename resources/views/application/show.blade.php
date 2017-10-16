@extends('layouts.front')

@section('content')

    <section class="application" id="application">
        <div class="container">
            <h2>Zgłoszenie</h2>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 text-center">
                    <h1>{{ $contest->title }} - {{ $contest->firstname }} {{ $contest->lastname }}</h1>

                    @if($contest->img_tip)
                        <div class="content-image">
                            <img src="{{ asset(str_replace('public','storage',$contest->img_tip)) }}"
                                 alt="' + json.parameters.title + '"/>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('front.application.id', ['contest' => $contest->id]) }}"
                               class="fb"></a>
                        </div>
                    @endif

                    @if($contest->video_url && $contest->video_type == 'youtube')
                        <div class="content-video">
                            <iframe src="https://www.youtube.com/embed/{{ $contest->video_id }}?&showinfo=0" frameborder="0"
                                    allowfullscreen></iframe>
                        </div>
                    @endif

                    @if($contest->video_url && $contest->video_type == 'vimeo')
                        <div class="content-video">
                            <iframe
                                    src="https://player.vimeo.com/video/{{ $contest->video_id }}?color=000000&title=0&byline=0&portrait=0"
                                    frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                        </div>
                    @endif

                    @if($contest->video_url && $contest->video_type == 'facebook')
                        <div class="content-video">
                            <iframe
                                    src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook%2Fvideos%2F{{ $contest->video_id }}%2F&width=500&show_text=false&appId=1835975633290418&height=280"
                                    style="border:none;overflow:hidden" scrolling="no" frameborder="0"
                                    allowTransparency="true"></iframe>
                        </div>
                    @endif

                    <p>{{ $contest->message }}</p>

                    <a href="/zgloszenia/" class="cta-button">POWRÓT</a>
                </div>
            </div>

        </div>
    </section>


@endsection
