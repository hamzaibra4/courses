@extends('layouts.front')

@section('customcss')
    <style>
        .video-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #000;
        }

        video {
            max-width: 100%;
            max-height: 80vh;
            outline: none;
            pointer-events: auto;
        }

        .video-watermark {
            position: fixed;
            inset: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 32px;
            color: rgba(255,255,255,0.15);
            transform: rotate(-30deg);
            pointer-events: none;
            z-index: 9999;
        }
    </style>
@endsection

@section('watermark')
    <div class="video-watermark">
        TECHNOMATH – INTERNAL MATERIAL • {{ auth()->user()->email }}
    </div>
@endsection

@section('content')
    <div class="video-wrapper">
        <video id="secureVideo"
               controls
               controlsList="nodownload noremoteplayback"
               disablePictureInPicture
               oncontextmenu="return false;">
            <source src="{{ route('video.stream', $video->id) }}" type="video/mp4">
            Your browser does not support video playback.
        </video>
    </div>
@endsection

@section('customjs')
{{--    <script src="{{ asset('front/public/js/security.js') }}"></script>--}}

    <script>

    </script>
@endsection
