<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Library Management System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    {{-- Navigation --}}
    <nav class="bg-indigo-600 shadow-lg">
        <div class="container mx-auto px-4 sm:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-white">📚 Library Management</h1>
                </div>
                <div class="flex items-center space-x-6">
                    <a href="{{ route('dashboard') }}" class="text-white hover:text-gray-200">Dashboard</a>
                    <a href="{{ route('books.index') }}" class="text-white hover:text-gray-200">Books</a>
                    <a href="{{route('penalties.index')}}" class="text-white hover:text-gray-200">Penalties</a>
                    <div class="relative group">
                        <button class="text-white hover:text-gray-200">{{ Auth::user()->name }}</button>
                        <div class="hidden group-hover:block absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-10">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Profile</a>
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if ($message = Session::get('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative m-4" role="alert">
            <span class="block sm:inline">{{ $message }}</span>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative m-4" role="alert">
            <span class="block sm:inline">{{ $message }}</span>
        </div>
    @endif

    {{-- Main Content --}}
    <main class="py-8">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-800 text-white text-center py-6 mt-12">
        <p>&copy; 2025 Library Management System. All rights reserved.</p>
    </footer>
</body>
</html>