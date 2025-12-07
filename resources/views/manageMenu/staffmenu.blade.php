@extends('layouts.app')

<head>
    <style>
        .category-title {
            margin-top: 20px;
            font-weight: bold;
            font-size: 1.5rem;
            text-align: center;
            background-color: #f8f9fa;
            padding: 10px 0;
            border-top: 2px solid #ddd;
            border-bottom: 2px solid #ddd;
        }

        .card {
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            height: 200px;
            /* Ensure cards are of equal height */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-color: green;
        }

        .card:hover {
            transform: scale(1.03);
        }

        .image-container img {
            height: 150px;
            /* Fixed height for all images */
            width: 100%;
            /* Ensures it stretches horizontally */
            object-fit: cover;
            /* Crop image to fit */
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .card-body {
            flex: 1;
            /* Make card body take remaining space */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 1rem;
            margin-bottom: 5px;
        }
    </style>
</head>

@section('content')
    <div class="container mt-4">
        <h2 class="text-center mb-4">Our Menu</h2>

        <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="image-container">
                    <img src="{{ asset('asset/default-image/no-image.jpg') }}" class="card-img-top img-fluid" alt="Add Menu">

                    <h5 class="card-title">Name</h5>
                        <p class="card-text">Price</p>
                        <p class="card-text">Status</p>
                </div>
                <div class="card-body">
                    <a href="{{ route('add-menu') }}" class="btn btn-primary">Add Menu</a>
                </div>
            </div>
        </div>

        @if (session('success'))
            <script>
                alert("{{ session('success') }}");
            </script>
        @endif


        <!-- Drinks Section -->
        <div class="category-title mb-5">Drinks</div>
        <div class="row">
            @foreach ($menuItems as $item)
                @if ($item->category === 'Drink')
                    <div class="col-md-4 mb-4">
                        <div class="card text-center">
                            <div class="image-container">
                                <img src="{{ asset('asset/default-image/' . $item->image_path) }}" class="card-img-top img-fluid"
                                    alt="{{ $item->name }}">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->name }}</h5>
                                <p class="card-text">RM {{ number_format($item->price, 2) }}</p>
                                <p class="card-text">Status: {{ $item->status }}</p>
                                <div class="d-flex justify-content-center">
                            <a href="{{ route('menu.show', $item->id) }}" class="btn btn-primary mr-2" style="width:80px;height:38px;">View</a>
                            &nbsp;&nbsp;&nbsp;
                            <form action="{{ route('menu.destroy', $item->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this menu?')">Delete</button>
                            </form>
                        </div>
                            </div>
                        </div>
                    </div>
                @endif
                </a>
            @endforeach
        </div>

        <!-- Food Section -->
        <div class="category-title mb-5">Food</div><br>
        <div class="row">
            @foreach ($menuItems as $item)
            
                @if ($item->category === 'Food')
                    <div class="col-md-4 mb-4">
                        <div class="card text-center">
                            <div class="image-container">
                            <img src="{{ asset('asset/default-image/' . $item->image_path) }}" class="card-img-top img-fluid"
                            alt="{{ $item->name }}">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->name }}</h5>
                                <p class="card-text">RM {{ number_format($item->price, 2) }}</p>
                                <p class="card-text">Status: {{ $item->status }}</p>
                                <div class="d-flex justify-content-center">
                            <a href="{{ route('menu.show', $item->id) }}" class="btn btn-primary mr-2" style="width:80px;height:38px;">View</a>
                            &nbsp;&nbsp;&nbsp;
                            <form action="{{ route('menu.destroy', $item->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this menu?')">Delete</button>
                            </form>
                        </div>
                            </div>
                        </div>
                    </div>
                @endif
                </a>
            @endforeach
        </div>

        <!-- Side Dish Section -->
        <div class="category-title mb-5">Side Dish</div><br>
        <div class="row">
            @foreach ($menuItems as $item)
            
                @if ($item->category === 'Side Dish')
                    <div class="col-md-4 mb-4">
                        <div class="card text-center">
                            <div class="image-container">
                            <img src="{{ asset('asset/default-image/' . $item->image_path) }}" class="card-img-top img-fluid"
                            class="card-img-top img-fluid" alt="{{ $item->name }}">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->name }}</h5>
                                <p class="card-text">RM {{ number_format($item->price, 2) }}</p>
                                <p class="card-text">Status: {{ $item->status }}</p>
                            </div>
                            <div class="d-flex justify-content-center">
                            <a href="{{ route('menu.show', $item->id) }}" class="btn btn-primary mr-2" style="width:80px;height:38px;">View</a>
                            &nbsp;&nbsp;&nbsp;

                            <form action="{{ route('menu.destroy', $item->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this menu?')">Delete</button>
                            </form>
                        </div>


                        </div>
                    </div>
                @endif
                </a>
            @endforeach
        </div>
    </div>
@endsection