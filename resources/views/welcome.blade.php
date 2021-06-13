<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script>
        var siteUrl = '{!! url("/") !!}';
    </script>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/app.css')}}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css">
</head>

<body>
    <div id="app">
        <todolist-component></todolist-component>
        {{-- <example-component></example-component> --}}
    </div>
    <script src="{{ url('/js/app.js')}}"></script>
</body>

</html>