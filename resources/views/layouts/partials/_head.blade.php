<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ticket system</title>
    <link class="rounded" rel="icon" type="image/png" href="../css/favicon-16.png">

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/dashboard/">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.2.1/css/all.css') }}">
    <link href="{{ asset('css/create.css') }}" rel="stylesheet">
    <script src="{{ asset('js/chart.umd.js') }}" integrity="sha-384-epmLzfWUmCYTZvs5x1bnwkmzWmlp1q07ng27woKxa+v3M4Am4k//PSNbB0pgm0FC" crossorigin="anonymous"></script>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/color-modes.js') }}"></script>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    
    @include('components.head.tinymce-config')
    <x-head.tinymce-config />
</head>
