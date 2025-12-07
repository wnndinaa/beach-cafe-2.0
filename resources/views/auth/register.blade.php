<x-guest-layout>
    <h1>
        REGISTER
    </h1>
    <table>
        <tr>
            <td>
                <form method="POST" action="{{ route('register.create') }}">
                    @csrf
            
                    <!-- Name -->
                    <div class="firstcolumn">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
            
                    <!-- Email Address -->
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
            
                    <!-- Password -->
                        <x-input-label for="password" :value="__('Password')" />
            
                        <x-text-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />
            
                        
                            <label for="role">Role</label>
                            <select name="role" id="role" required>
                                <option value="customer">Customer</option>
                                <option value="staff">Staff</option>
                            </select>
                    </div>
            
                    <div class="flex items-center justify-end mt-4">
                        
            
                        <x-primary-button class="ms-4">

                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </form>
            </td>
            <td>
                <img class="main-img me-5" src="{{ asset('asset/default-image/beach-cafe.png') }}" alt="beach-cafe.png" style="width: 150px">



                    <p>Already have an account?</p>
                <a class="green-button" href="{{ route('login') }}">
                    {{ __('Sign In') }}
                </a>
            </td>
        </tr>
    </table>
   
</x-guest-layout>
