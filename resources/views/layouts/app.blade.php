<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="shortcut icon" href="{{ asset('asset/default-image/beach-cafe.png') }}" type="image/png">

    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poller+One&display=swap" rel="stylesheet">

    <title>Beach Cafe</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body >
    @php
    $user=Auth::user();
        if ($user->role == 'customer') {
            $color = 'main-background-customer';
        } elseif ($user->role == 'staff') {
            $color = 'main-background-staff';  
        }
    @endphp

    <div>
        @include('layouts.navigation')
        <div style="margin-bottom: 80px;">
            <div class="d-flex justify-content-between align-items-center {{ $color }}">
                <div class="h1 fw-bold ms-5" style="font-family: 'Poller One', sans-serif;">
                    BEACH CAFE 
                    <div style="font-weight:100; font-size:16px; font-family: 'Poppins';">
                        Where great food meets the ocean breeze
                    </div>
                </div>
                
                <img class="main-img me-5" src="{{ asset('asset/default-image/beach-cafe.png') }}" alt="beach-cafe.png">
            </div>
            <div class="mt-4 ms-4 me-4">
                @yield('content')
            </div>
        </div>
    
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    </div>
</body>
</html>
