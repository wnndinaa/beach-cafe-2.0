<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" style="display: flex; justify-content: space-between; align-items: center; padding: 20px;">
    <!-- Left side: Navbar -->
    <a class="navbar-brand" href="{{ route('profile.edit') }}">Hello, {{ Auth::user()->name }}!</a>
    
    <!-- Right side: Links and Logout -->
    <div style="display: flex; align-items: center;">
        <!-- Common links for all users -->
        <a class="navbar-brand" href="{{ route('dashboard') }}" style="margin-right: 15px;">Home</a>
        <a class="navbar-brand" href="{{ route('view_all_feedback', ['id' => Auth::id()]) }}" style="margin-right: 15px;">Feedback</a>
        

        <!-- Links only visible to staff -->
        @if(Auth::user()->role === 'staff')
        
        <a class="navbar-brand" href="{{ route('staff-menu') }}" style="margin-right: 15px;">Menu</a>
        <a class="navbar-brand" href="{{ route('staff.ordersIndex') }}" style="margin-right: 15px;">Order</a>
        <a class="navbar-brand" href="{{ route('inventory.index') }}" style="margin-right: 15px;">Inventory</a>
        <a class="navbar-brand" href="{{ route('profile.index')}}" style="margin-right: 15px;">Profiles</a>
            @endif

            @if(Auth::user()->role === 'customer')
            
        <a class="navbar-brand" href="{{ route('menu') }}" style="margin-right: 15px;">Menu</a>
            <a class="navbar-brand" href="{{ route('order.cart') }}" style="margin-right: 15px;">
            Cart<span class="badge bg-primary rounded-circle">{{ $cartItemCount ?? 0 }}</span></a>
        <a class="navbar-brand" href="{{ route('order.history') }}" style="margin-right: 15px;">History</a>
            <a class="navbar-brand" href="{{ route('profile.index')}}" style="margin-right: 15px;">Profiles</a>
            @endif

            
            

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" style="margin: 0; display: inline;">
            @csrf
            <a href="{{ route('logout') }}" class="navbar-brand"
               style="margin-right: 0; text-decoration: none;"
               onclick="event.preventDefault(); this.closest('form').submit();">
                {{ __('Log Out') }}
            </a>
        </form>
    </div>
</nav>

<nav id="bottom-navbar" class="navbar navbar-expand-lg navbar-dark bg-dark fixed-bottom" style="transition: bottom 0.3s; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 10px;">
    <a class="navbar-brand" href="#about" style="color: #fff;">About Us</a>
    <p style="color: #fff; text-align: center; max-width: 600px; font-size:10px;">
        Where we serve delicious food and refreshing drinks by the sea. Our cozy café offers the perfect spot to relax, enjoy great company, and savor our specially crafted menu, made with the freshest ingredients.
    </p>
</nav>

<script>
    var prevScrollpos = window.pageYOffset;
    var navbar = document.getElementById("bottom-navbar"); // Select the navbar by ID

    window.onscroll = function() {
        var currentScrollPos = window.pageYOffset;

        if (prevScrollpos > currentScrollPos) {
            navbar.style.bottom = "0"; // Show the navbar
        } else {
            navbar.style.bottom = "-100px"; // Hide the navbar
        }

        prevScrollpos = currentScrollPos;
    }
</script>