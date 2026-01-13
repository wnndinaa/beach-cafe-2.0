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

<body style="display: flex; flex-direction: column; min-height: 100vh;">
    @php
    $user=Auth::user();
    if ($user->role == 'customer') {
    $color = 'main-background-customer';
    } elseif ($user->role == 'staff') {
    $color = 'main-background-staff';
    }
    @endphp

    <div style="flex: 1;">
        @include('layouts.navigation')

        <div style="margin-bottom: 150px;">
            <!-- <div class="d-flex justify-content-between align-items-center {{ $color }}"
                style="padding: 6px 0; height: 140px;">

                <div class="fw-bold ms-5" style="font-family: 'Poller One', sans-serif; font-size: 28px;">
                    BEACH CAFE
                    <div style="font-weight:100; font-size:12.5px; font-family: 'Poppins'; margin-top: 2px;">
                        Where great food meets the ocean breeze
                    </div>
                </div>

                <img class="main-img me-5"
                    src="{{ asset('asset/default-image/beach-cafe.png') }}"
                    alt="beach-cafe.png"
                    style="
                height: calc(100% - 12px);
                margin: 6px 0;
                object-fit: contain;
             "> -->
        </div>

        <div class="mt-2 ms-4 me-4">
            @yield('content')
        </div>
    </div>
    </div>

    <footer style="margin-top: auto; background-color: #212529; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 10px;">
        <a href="#about" style="color: #fff; text-decoration: none;">About Us</a>
        <p style="color: #fff; text-align: center; max-width: 600px; font-size:10px; margin: 5px 0 0 0;">
            Where we serve delicious food and refreshing drinks by the sea. Our cozy café offers the perfect spot to relax, enjoy great company, and savor our specially crafted menu, made with the freshest ingredients.
        </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</body>

</html>