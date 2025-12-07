<x-guest-layout>
 

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
<h1>
    FORGET PASSWORD
</h1>
    <table>
        <tr>
            <td>
                {{-- <form method="POST" action="{{ route('password.email') }}"> --}}
                    @csrf
            
                    <!-- Email Address -->
                    <div>
                        <x-input-label style="color: #1E1E1E;
	font-size: 18px;
	padding: 15px;" for="email" :value="__('Enter your email')" />
                        <x-text-input style="border: 2px solid #ccc;
	width: 95%;
	padding: 10px;
	margin: 0px 10px 10px 10px;
	border-radius: 5px;" id="email"  type="email" name="email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
            
                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button>
                            {{ __('Retrieve Password') }}
                        </x-primary-button>
                    </div>
                </form>
            </td>
            <td>
                <img class="main-img me-5" src="{{ asset('asset/default-image/beach-cafe.png') }}" alt="beach-cafe.png" style="width: 150px">



                    <p>Remember your account?</p>
                    <a class="green-button" href="{{ route('login') }}"">Sign In</a>
            </td>
        </tr>
    </table>
</x-guest-layout>
