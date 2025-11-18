@extends('layouts.app')
@section('title', 'Book Collection')

@section('content')
<div class="container mx-auto px-4 sm:px-8 py-8">
    <div class="w-full max-w-7xl mx-auto p-8 bg-white bg-opacity-95 rounded-lg shadow-lg">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-4 sm:mb-0">Book Collection</h1>
            <div class="flex items-center gap-4">
                <a href="{{ route('books.create') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Add New Book
                </a>
                <a href="{{ route('dashboard') }}" class="inline-block px-6 py-3 bg-gray-600 text-white font-semibold rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    &larr; Dashboard
                </a>
            </div>
        </div>

        {{-- Session Message --}}
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p class="font-bold">Success</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            {{-- Sidebar for Search and Filters --}}
            <aside class="lg:col-span-1">
                <div class="p-6 bg-gray-50 rounded-lg shadow">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Filter & Search</h3>
                    <form method="GET" action="{{ route('books.index') }}">
                        <div class="space-y-4">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700">General Search</label>
                                <input type="text" name="search" id="search" placeholder="Title, Author, ISBN..." value="{{ request('search') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="author" class="block text-sm font-medium text-gray-700">Author</label>
                                <input type="text" name="author" id="author" value="{{ request('author') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="isbn" class="block text-sm font-medium text-gray-700">ISBN</label>
                                <input type="text" name="isbn" id="isbn" value="{{ request('isbn') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="publisher" class="block text-sm font-medium text-gray-700">Publisher</label>
                                <input type="text" name="publisher" id="publisher" value="{{ request('publisher') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div class="flex items-center gap-4 pt-2">
                                <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Search
                                </button>
                                <a href="{{ route('books.index') }}" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </aside>

            {{-- Main Content: Book List --}}
            <div class="lg:col-span-3">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cover</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($books as $book)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($book->image)
                                            <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" class="h-16 w-12 object-cover rounded">
                                        @else
                                            <div class="h-16 w-12 flex items-center justify-center bg-gray-200 rounded text-xs text-gray-500">No Image</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $book->title }}</div>
                                        <div class="text-sm text-gray-500">{{ $book->isbn }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $book->author }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $book->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('books.show', $book->id) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                        <a href="{{ route('books.edit', $book->id) }}" class="ml-4 text-blue-600 hover:text-blue-900">Edit</a>
                                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline ml-4" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        No books found matching your criteria. <a href="{{ route('books.index') }}" class="text-indigo-600 hover:underline">Reset search</a>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $books->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection