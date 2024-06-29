@extends('layouts.app')

@push('title')
    Upload CV
@endpush

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col text-center">
                <h2 class="fs-24 fw-500 lh-34 text-black">Upload CV</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col text-center">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadCvModal">
                    Upload CV
                </button>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="uploadCvModal" tabindex="-1" aria-labelledby="uploadCvModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadCvModalLabel">Upload CV</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('alumni.cvs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="pdf" class="form-label">CV (PDF only)</label>
                            <input type="file" class="form-control" id="pdf" name="pdf" accept="application/pdf" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload CV</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
@endpush
