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
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card:hover {
            transform: scale(1.03);
        }

        .image-container img {
            height: 150px;
            width: 100%;
            object-fit: cover;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .card-body {
            flex: 1;
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

        .status-text {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .profit-text {
            font-size: 0.9rem;
            color: #28a745; /* Green color for profit */
            font-weight: bold;
        }

        .add-menu-card {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .add-menu-card img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-bottom: 15px;
        }

        .container {
            margin-top: 20px;
        }

        /* Custom style to disable link */
        .disabled-link {
            pointer-events: none;
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>

@section('content')
        
    @if(auth()->user()->role === 'staff')
    <!-- Time Range Filter for Staff -->
    <div style="width:70%"> 
    <form method="GET" action="{{ route('dashboard') }}">
        <div>
            <div class="form-group"  style="display: flex;">
                <label for="time_range" style="width:25%">Choose Range Date:</label>
                    <select name="time_range" id="time_range" class="form-control" style="width:30%;margin-right:10px">
                        <option value="weekly" {{ $timeRange == 'weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="monthly" {{ $timeRange == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="yearly" {{ $timeRange == 'yearly' ? 'selected' : '' }}>Yearly</option>
                    </select>
            
            <button type="submit" class="btn btn-primary" style="width:10%">Filter</button>
            </div>
        </div>
                    
    </form>
    </div>
            <div class="category-title mb-5">💰 Most Profit</div>
            <div class="row">
                @foreach($mostProfit as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card text-center">
                            <div class="image-container">
                                <img src="{{ asset('asset/default-image/' . $item->image_path) }}" alt="{{ $item->name }}" class="card-img-top img-fluid">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->name }}</h5>
                                <p class="profit-text">Profit: RM{{ number_format($item->total_quantity * $item->price, 2) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="category-title mb-5">📉 Least Profit</div>
            <div class="row">
                @foreach($leastProfit as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card text-center">
                            <div class="image-container">
                                <img src="{{ asset('asset/default-image/' . $item->image_path) }}" alt="{{ $item->name }}" class="card-img-top img-fluid">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->name }}</h5>
                                <p class="profit-text">Profit: RM{{ number_format($item->total_quantity * $item->price, 2) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        @endif

        <!-- Hot Selling -->
        <div class="category-title mb-5">🔥 Hot Selling</div>
        <div class="row">
            @foreach($hotSelling as $item)
                <div class="col-md-4 mb-4">
                    <div class="card text-center">
                        <div class="image-container">
                            @if(auth()->user()->role === 'staff')
                                <img src="{{ asset('asset/default-image/' . $item->image_path) }}" alt="{{ $item->name }}" class="card-img-top img-fluid">
                            @else
                                <a href="{{ $item->status === 'Unavailable' ? '#' : route('customize.order', ['menu' => $item->id]) }}" style="text-decoration: none;" class="{{ $item->status === 'Unavailable' ? 'disabled-link' : '' }}">
                                    <img src="{{ asset('asset/default-image/' . $item->image_path) }}" alt="{{ $item->name }}" class="card-img-top img-fluid">
                                </a>
                            @endif
                        </div>    
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <p class="card-text">Quantity Sold: {{ $item->total_quantity }}</p>
                            <p class="status-text">Status: {{ $item->status }}</p>
                            <!-- Display profit if user is staff -->
                            @if(auth()->user()->role === 'staff')
                                <p class="profit-text">Profit: RM{{ number_format($item->total_quantity * $item->price, 2) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Hot Items This Week -->
        <div class="category-title mb-5">📅 Hot Items This Week</div>
        <div class="row">
            @foreach($hotThisWeek as $item)
                <div class="col-md-4 mb-4">
                    <div class="card text-center">
                        <div class="image-container">
                        
                            @if(auth()->user()->role === 'staff')
                                <img src="{{ asset('asset/default-image/' . $item->image_path) }}" alt="{{ $item->name }}" class="card-img-top img-fluid">
                           @else
                           <a href="{{ $item->status === 'Unavailable' ? '#' : route('customize.order', ['menu' => $item->id]) }}" style="text-decoration: none;" class="{{ $item->status === 'Unavailable' ? 'disabled-link' : '' }}">
                                <img src="{{ asset('asset/default-image/' . $item->image_path) }}" alt="{{ $item->name }}" class="card-img-top img-fluid">
                            </a>
                            @endif

                            
                        </div>    
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <p class="card-text">Quantity Sold: {{ $item->total_quantity }}</p>
                            <p class="status-text">Status: {{ $item->status }}</p>
                            <!-- Display profit if user is staff -->
                            @if(auth()->user()->role === 'staff')
                                <p class="profit-text">Profit: RM{{ number_format($item->total_quantity * $item->price, 2) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- New Menu -->
        <div class="category-title mb-5">🆕 New Menu</div>
        <div class="row">
            @foreach($newMenus as $menu)
                <div class="col-md-4 mb-4">
                    <div class="card text-center">
                        <div class="image-container">
                            @if(auth()->user()->role === 'staff')
                                <img src="{{ asset('asset/default-image/' . $menu->image_path) }}" alt="{{ $menu->name }}" class="card-img-top img-fluid">
                                @else
                                <a href="{{ $menu->status === 'Unavailable' ? '#' : route('customize.order', ['menu' => $menu->id]) }}" style="text-decoration: none;" class="{{ $menu->status === 'Unavailable' ? 'disabled-link' : '' }}">
                                    <img src="{{ asset('asset/default-image/' . $menu->image_path) }}" alt="{{ $menu->name }}" class="card-img-top img-fluid">
                                </a>
                            @endif
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $menu->name }}</h5>
                            <p class="card-text">Date Added: {{ $menu->created_at }}</p>
                            <p class="status-text">Status: {{ $menu->status }}</p>
                            <!-- Disable link for staff users -->
                            @if(auth()->user()->role === 'staff')
                            <p class="profit-text">Profit: RM{{ number_format($item->total_quantity * $item->price, 2) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection