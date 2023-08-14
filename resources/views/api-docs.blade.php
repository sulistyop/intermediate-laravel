<!DOCTYPE html>
<html>
<head>
    <title>API Documentation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>API Documentation</h1>
    <p>
        Berikut adalah dokumentasi API yang kami sediakan. Untuk menjalankan nya bisa menggunakan aplikasi
        <strong>Postman, Insomnia,</strong> atau aplikasi sejenis.

    </p>
    @foreach ($endpoints as $endpoint)
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">
                    {{ $endpoint['name'] }}
                </h4>
                <span class="badge @if($endpoint['method'] == 'POST')bg-success  @elseif($endpoint['method'] == 'GET') bg-primary @endif">
                    {{ $endpoint['method']  }}
                </span>
                <pre class="my-3 border" style="width: 350px">{{ $endpoint['url'] }}</pre>
                @if($endpoint['method'] == 'GET')
                    <div class="mb-2">
                        Endpoint ini baru bisa digunakan setelah login dahulu,
                        Ketika login sukses akan mendapatkan Token.
                        <br>
                        Jika ingin menggunakan Insomnia bisa menggunakan format seperti
                        Bearer {TokenAnda}
                        <br>
                    </div>
                    @if(isset($endpoint['desc']))
                        {!! $endpoint['desc']  !!}
                    @endif
                @endif

                <button class="btn btn-primary" onclick="copyToClipboard('{{ $endpoint['url'] }}')">Copy URL</button>
            </div>
        </div>
    @endforeach


</div>

<script>
    function copyToClipboard(text) {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        alert('URL copied to clipboard: ' + text);
    }
</script>
</body>
</html>
