@extends('layouts.app')

@push('title')
    {{$title}}
@endpush

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h3 class="text-center">Recommendation Request Form</h3>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('alumni.recommendation.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="instructor">Instructor:</label>
                        <select class="form-control @error('instructor') is-invalid @enderror" id="instructor" name="instructor">
                            <option disabled selected value="">Select an Instructor</option>
                            @foreach($admins as $admin)
                                <option value="{{ $admin->id }}">{{ $admin->admin->first_name . ' ' . $admin->admin->last_name }}</option>
                            @endforeach
                        </select>
                        @error('instructor')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="details">Details:</label>
                        <textarea class="form-control @error('details') is-invalid @enderror" id="details" name="details" rows="5">{{ old('details') }}</textarea>
                        @error('details')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#instructor').select2({
                placeholder: 'Select an Instructor',
                allowClear: true
            });
        });
    </script>
@endpush
