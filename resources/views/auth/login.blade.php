<!-- Trong tệp Blade (ví dụ: resources/views/auth/login.blade.php) -->
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        /* CSS mà bạn đã định nghĩa */
        .login-btn {
            display: block; /* Để thẻ <a> chiếm toàn bộ chiều rộng */
            text-align: center;
            color: white;
            padding: 12px 30px;
            margin: 10px 0; /* Thêm margin dọc nếu cần */
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            width: 100%; /* Chiếm toàn bộ chiều ngang của div cha */
        }

        .google-btn {
            background-color: #db4437;
            background-image: url('https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg');
            background-position: 10px center;
            background-repeat: no-repeat;
        }

        .facebook-btn {
            background-color: #3b5998;
            background-image: url('https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg');
            background-position: 10px center;
            background-repeat: no-repeat;
        }
    </style>
</head>

<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
            <div class="block mt-4">
                <!-- Google Login -->
                <a href="{{ url('auth/google') }}" class="login-btn google-btn">
                    <i class="fab fa-google mr-2"></i> Login with Google
                </a>
            </div>
            <div class="block mt-4">
                <!-- Facebook Login -->
                <a href="{{ url('auth/facebook') }}" class="login-btn facebook-btn">
                    <i class="fab fa-facebook-f mr-2"></i> Login with Facebook
                </a>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
