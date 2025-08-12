<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <h3>{{ $post->title }}</h3>
                        <hr>
                        <p>{!! $post->content !!}</p>
                        <small>Dipublikasikan pada: {{ $post->created_at->format('d F Y') }}</small>
                        <hr>
                        <a href="{{ route('posts.index') }}" class="btn btn-md btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>