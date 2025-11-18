@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="container mx-auto px-4 sm:px-8 py-8">
        <div class="w-full max-w-5xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
            </div>

            <div class="p-6 mb-8 bg-gray-50 rounded-md border border-gray-200">
                <p class="text-lg text-gray-800">Welcome back, <span class="font-semibold">{{ Auth::user()->name }}</span>!</p>
                <p class="mt-2 text-gray-600">You are logged in and can now manage the library's collection.</p>
            </div>

            {{-- Quick Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <x-stat-card title="Total Books" :value="$totalBooks ?? 'N/A'" />
                <x-stat-card title="Books Available" :value="$availableBooks ?? 'N/A'" />
                <x-stat-card title="Books Borrowed" :value="$borrowedBooks ?? 'N/A'" />
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Quick Actions</h2>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('books.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 16c1.255 0 2.443-.29 3.5-.804V4.804zM14.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 0114.5 16c1.255 0 2.443-.29 3.5-.804v-10A7.968 7.968 0 0014.5 4z" /></svg>
                        Borrow a New Book
                    </a>
                    <a href="{{ route('books.create') }}" class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                        Add New Book
                    </a>
                </div>
            </div>

            {{-- My Borrowed Books --}}
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">My Borrowed Books</h2>
                <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book Title</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Return</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($userLoans as $loan)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $loan->book->title }}</div>
                                            <div class="text-sm text-gray-500">{{ $loan->book->isbn }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $loan->book->author }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm {{ $loan->due_date->isPast() ? 'text-red-600 font-bold' : 'text-gray-500' }}">
                                            {{ $loan->due_date->format('F j, Y') }}
                                            @if ($loan->due_date->isPast())
                                                <span class="block text-xs">(Overdue)</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            {{-- Return Button Form --}}
                                            <form action="{{ route('loans.return', $loan->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to return this book?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Return</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            You have not borrowed any books yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection