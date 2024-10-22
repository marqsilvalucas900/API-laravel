<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Postagem</title>
</head>
<body>
    <h1>Enviar um Post</h1>
    {{-- <p>{{$success}}</p> --}}
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('form.store') }}" method="POST">
        @csrf
        <div>
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}">
        </div>
        <div>
            <label for="content">Conteúdo:</label>
            <textarea id="content" name="content">{{ old('content') }}</textarea>
        </div>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
