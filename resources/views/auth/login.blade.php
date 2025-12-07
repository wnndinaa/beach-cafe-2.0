<x-guest-layout>
    
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <h1>LOGIN</h1>
        <table>
            <tr>
                <td>
                    <div class="firstcolumn">
                        <label>Email</label>
                    <input type="text" name="email" placeholder="Email">
    
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Password">
                    <button type="submit">Login</button>
                    </div>
                    
                
        <!-- Remember Me -->
        <div style="float: left; font-size: 15px; padding-left: 10px">
            <label for="remember_me" >
                <input id="remember_me" type="checkbox"  name="remember">
                <span style="color: #37d48b">Remember me</span>
            </label>
        </div>

        <div style="float: right; font-size: 15px; padding-right: 15px;">
            @if (Route::has('password.request'))
                <a style="text-decoration: none; color: #1e1e1e" href="{{ route('password.request') }}">
                    {{ __('Forgot password') }}
                </a>
            @endif

        </div>
                </td>
                <td>
                    <img class="main-img me-5" src="{{ asset('asset/default-image/beach-cafe.png') }}" alt="beach-cafe.png" style="width: 150px">



                    <p>Don't have an account?</p>
                    <a class="green-button" href="{{ route('register') }}">Sign Up</a>
                </td>
            </tr>
         </table>


    </form>
</x-guest-layout>
