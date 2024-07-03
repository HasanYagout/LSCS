<div class="container mt-5">
    <h1 class="mb-4">Recommendations</h1>
    <div class="row">

        @if (json_decode($recommendations) && count(json_decode($recommendations)) > 0)
            @foreach (json_decode($recommendations) as $file)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header bg-primary-color text-f5b40a">
                            <h5 class="card-title">Recommendation {{ $loop->iteration }}</h5>

                        </div>
                        <div class="card-body">
                            <embed src="{{ route('alumni.recommendation.view', ['file' => $file]) }}" type="application/pdf" width="100%" height="300px" />

                        </div>
                        <div class="card-footer bg-primary-color">
                            <div class="d-flex justify-content-between">
                                <a  href="{{ route('alumni.recommendation.download', ['file' => $file]) }}" class="btn h-100 bg-secondary-color text-white">Download</a>
                                <a href="{{ route('alumni.recommendation.view', ['file' => $file]) }}" target="_blank" class="btn h-100 bg-secondary-color text-white">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <p>No recommendations available.</p>
            </div>
        @endif
    </div>
</div>
