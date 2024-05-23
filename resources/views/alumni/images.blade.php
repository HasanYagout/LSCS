@extends('alumni.layouts.app')

@section('content')
    <div class="container">
        <div class="row mt-3">
            @foreach(json_decode($images) as $image)
                <div class="col-4">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <img src="{{ asset('public/storage/graduation_images/' . $image) }}" onclick="openImage('{{ asset('public/storage/graduation_images/' . $image) }}')" alt="">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal for enlarged image -->
    <div class="modal fade" id="enlargedModal" tabindex="-1" role="dialog" aria-labelledby="enlargedModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="enlargedModalLabel">Enlarged Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="enlargedImage" src="" alt="" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <a id="singleDownloadLink" href="" download="image.jpg" class="btn btn-primary">Download</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Download all button -->
    <div class="container mt-3">
        <div class="text-center">
            <button id="downloadAllButton" class="btn btn-primary" onclick="downloadAllImages()">Download All</button>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function openImage(imageUrl) {
            // Set the image source in the modal
            document.getElementById('enlargedImage').src = imageUrl;

            // Set the single download link URL in the modal
            document.getElementById('singleDownloadLink').href = imageUrl;

            // Open the modal
            $('#enlargedModal').modal('show');
        }

        // Function to download all images
        // Function to download all images
        function downloadAllImages() {
            var images = document.querySelectorAll('.card-body img');
            for (var i = 0; i < images.length; i++) {
                var imageUrl = images[i].src;
                var downloadLink = document.createElement('a');
                downloadLink.href = imageUrl;
                downloadLink.download = 'image' + (i + 1) + '.jpg';
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
            }
        }
    </script>
@endpush
