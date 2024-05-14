@extends('admin.layouts.app')
@section('content')
    <div id="pdf-viewer"></div>

@endsection
@push('script')

    <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
    <script>
        // Get the PDF file URL from the query string (e.g., ?file=example.pdf)
        var queryString = window.location.search;
        var urlParams = new URLSearchParams(queryString);
        var file = urlParams.get('file');

        // Load and display the PDF file
        var loadingTask = pdfjsLib.getDocument(file);
        loadingTask.promise.then(function (pdf) {
            pdf.getPage(1).then(function (page) {
                var scale = 1.5;
                var viewport = page.getViewport({ scale: scale });

                var canvas = document.createElement('canvas');
                var context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                var renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };

                page.render(renderContext).promise.then(function () {
                    document.getElementById('pdf-viewer').appendChild(canvas);
                });
            });
        });
    </script>
@endpush
