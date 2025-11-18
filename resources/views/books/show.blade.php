@extends('layouts.app')
@section('title', $book->title)

@section('content')
<div class="container mx-auto px-4 sm:px-8 py-8">
    <div class="w-full max-w-2xl mx-auto">
        <div class="p-8 bg-white rounded-lg shadow-lg">

            <div class="flex items-start space-x-6">
                @if ($book->image)
                    <img src="{{ asset('storage/' . $book->image) }}" alt="Cover of {{ $book->title }}" class="h-48 w-auto rounded-md shadow-lg">
                @else
                    <div class="flex items-center justify-center h-48 w-32 bg-gray-200 rounded-md shadow-lg text-gray-500">No Image</div>
                @endif
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $book->title }}</h1>
                    <p class="text-lg text-gray-600">by {{ $book->author }}</p>
                </div>
            </div>

            <div class="mt-6 border-t border-gray-200">
                <dl class="divide-y divide-gray-200">
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500">Publisher</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $book->publisher }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500">Year Published</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $book->year_published }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500">ISBN</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $book->isbn }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500">Genre</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $book->genre }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500">Total Copies</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $book->quantity }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500">Available Copies</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $book->available_copies }}</dd>
                    </div>
                </dl>
            </div>

            <div class="mt-6 flex items-center justify-start gap-x-6">
                <a href="{{ route('books.index') }}" class="rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">&larr; Back to List</a>
                @auth
                    {{-- Borrow Button --}}
                    @if ($book->available_copies > 0)
                        <form action="{{ route('loans.borrow', $book->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                                Borrow Book
                            </button>
                        </form>
                    @else
                        <button type="button" class="rounded-md bg-gray-400 px-3 py-2 text-sm font-semibold text-white shadow-sm cursor-not-allowed" disabled>
                            Unavailable
                        </button>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection