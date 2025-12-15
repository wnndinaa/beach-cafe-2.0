<nav class="navbar navbar-expand-lg {{ Auth::user()->role === 'customer' ? 'navbar-light' : 'navbar-dark' }} fixed-top" style="display: flex; justify-content: space-between; align-items: center; padding: 5px 35px 5px; background-color: {{ Auth::user()->role === 'customer' ? '#89CFF0' : '#4FBC76' }};">
    <!-- Left side: Brand with Image -->
    <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('dashboard') }}" style="font-size: 28px; margin: 5px 0; color: {{ Auth::user()->role === 'customer' ? 'black' : 'white' }};">
        <img src="{{ asset('asset/default-image/beach-cafe.png') }}" alt="Beach Cafe" style="height: 65px; width: 65px; filter: {{ Auth::user()->role === 'customer' ? 'brightness(0)' : 'brightness(0) invert(1)' }};">

        Beach Cafe
    </a>

    <!-- Center: Navigation Links -->
    <div class="d-flex gap-4 flex-grow-1 justify-content-center mx-5">
        <a href="{{ route('dashboard') }}" class="{{ Auth::user()->role === 'customer' ? 'text-dark' : 'text-white' }} text-decoration-none" style="font-size: 20px; font-weight: bold;">Home</a>
        <a href="{{ route('view_all_feedback', ['id' => Auth::id()]) }}" class="{{ Auth::user()->role === 'customer' ? 'text-dark' : 'text-white' }} text-decoration-none" style="font-size: 20px; font-weight: bold;">Feedback</a>

        @if(Auth::user()->role === 'staff')
        <a href="{{ route('staff-menu') }}" class="text-white text-decoration-none" style="font-size: 20px; font-weight: bold;">Menu</a>
        <a href="{{ route('staff.ordersIndex') }}" class="text-white text-decoration-none" style="font-size: 20px; font-weight: bold;">Order</a>
        <a href="{{ route('inventory.index') }}" class="text-white text-decoration-none" style="font-size: 20px; font-weight: bold;">Inventory</a>
        <!-- <a href="{{ route('profile.index')}}" class="text-white text-decoration-none" style="font-size: 20px;">Profiles</a> -->
        @endif

        @if(Auth::user()->role === 'customer')
        <a href="{{ route('menu') }}" class="text-dark text-decoration-none" style="font-size: 20px;">Menu</a>
        <a href="{{ route('order.cart') }}" class="text-dark text-decoration-none position-relative" style="font-size: 20px; font-weight: bold;">
            Cart<span class="badge bg-primary rounded-circle" style="position: absolute; top: -8px; right: -8px; font-size: 10px;">{{ $cartItemCount ?? 0 }}</span>
        </a>
        <a href="{{ route('order.history') }}" class="text-dark text-decoration-none" style="font-size: 20px; font-weight: bold;">History</a>
        @endif
    </div>

    <!-- Right side: Module Name and User Profile Dropdown -->
    <div class="d-flex align-items-center gap-4">
        <span style="font-size: 18px; font-weight: 600; text-transform: capitalize; color: {{ Auth::user()->role === 'customer' ? 'black' : 'white' }};">{{ Auth::user()->role }}</span>
        <div class="dropdown">
            <button class="btn btn-link {{ Auth::user()->role === 'customer' ? 'text-dark' : 'text-white' }} text-decoration-none d-flex align-items-center gap-2" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0;">
                <span style="font-size: 16px;">Hi {{ Auth::user()->name }}</span>
                <span class="badge rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: bold; background-color: rgba(255, 255, 255, 0.3); color: white;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li>
                    <a class="dropdown-item" href="{{ route('profile.index') }}" style="font-size: 14px;">
                        Profile
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <a href="{{ route('logout') }}" class="dropdown-item" style="font-size: 14px;"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            Log Out
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>