<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Internship Task</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    <style>
        .center-content {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>


<body class="antialiased">
    <div class="center-content bg-gray-100">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if (Route::has('login'))
                @auth
                    {{-- <a href="{{ url('/home') }}"
                        class="  btn btn-primary text-sm text-gray-700 dark:text-gray-500 underline">Home</a> --}}
                    @if (Auth::user()->user_type == 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="  btn btn-primary text-sm text-gray-700 dark:text-gray-500 underline">Admin Dashboard</a>
                    @else
                        <a href="{{ route('user.dashboard') }}"
                            class="  btn btn-primary text-sm text-gray-700 dark:text-gray-500 underline">User Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="  btn btn-primary text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class=" btn btn-primary ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                    @endif
                @endauth
            @endif

            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                <!-- ... (other content) ... -->
            </div>
        </div>
    </div>
</body>

</html>
