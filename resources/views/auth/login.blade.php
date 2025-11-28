<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-image: url("{{ asset('images/background.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body class="antialiased bg-gray-100">
    <div class="relative flex items-top justify-center min-h-screen sm:items-center py-4 sm:pt-0">
        <div class="w-full max-w-sm p-6 bg-white bg-opacity-90 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-center text-gray-800">Login</h2>

            @if(session('error'))
                <p class="mt-2 text-sm text-center text-red-600">{{ session('error') }}</p>
            @endif

            @if ($errors->any())
                 <div class="mt-2 text-sm text-red-600">
                <div class="mt-2 text-sm text-red-600 space-y-1">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form class="mt-4" method="POST" action="{{ route('login') }}">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border rounded-md focus:border-indigo-400 focus:ring-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40">
                </div>

                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" type="password" name="password" required
                           class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border rounded-md focus:border-indigo-400 focus:ring-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40">
                </div>

                <div class="mt-6">
                    <button type="submit"
                            class="w-full px-4 py-2 tracking-wide text-white transition-colors duration-200 transform bg-indigo-700 rounded-md hover:bg-indigo-600 focus:outline-none focus:bg-indigo-600">
                        Login
                    </button>
                </div>
            </form>

            <p class="mt-4 text-sm text-center text-gray-700">
                Don’t have an account? <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:underline">Register</a>
            </p>
        </div>
    </div>
</body>
</html>
