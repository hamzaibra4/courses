@extends('layouts.front')

@section('customcss')
    <style>
        .pdf-wrapper {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        #pdf-viewer {
            width: 800px;
            max-width: 100%;
        }


    </style>
@endsection

@section('watermark')
    <div class="pdf-watermark">
        TECHNOMATH – INTERNAL ACADEMIC MATERIAL • {{ auth()->user()->email }}
    </div>
@endsection

@section('content')
    <div class="pdf-wrapper">
    <div id="pdf-viewer"></div>
    </div>

@endsection

@section('customjs')
    <script src="{{asset('front/public/js/security.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc =
            "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js";

        pdfjsLib.getDocument("{{ route('pdf.stream', $pdf->id) }}").promise
            .then(pdf => {
                for (let i = 1; i <= pdf.numPages; i++) {
                    pdf.getPage(i).then(page => {
                        const canvas = document.createElement('canvas');
                        const ctx = canvas.getContext('2d');
                        const viewport = page.getViewport({ scale: 1.5 });
                        canvas.width = viewport.width;
                        canvas.height = viewport.height;
                        page.render({ canvasContext: ctx, viewport });
                        document.getElementById('pdf-viewer').appendChild(canvas);
                    });
                }
            })
            .catch(err => {
                console.error(err);
                alert(err.message);
            });
    </script>
    <script>
        document.addEventListener('contextmenu', e => e.preventDefault());

        window.addEventListener('blur', () => {
            document.body.style.filter = 'blur(10px)';
        });
        window.addEventListener('focus', () => {
            document.body.style.filter = 'none';
        });
    </script>










@endsection
