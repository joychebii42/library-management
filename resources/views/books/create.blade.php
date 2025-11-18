@extends('layouts.app')
@section('title', 'Add New Book')

@section('content')
<div class="container mx-auto px-4 sm:px-8 py-8">
    <div class="w-full max-w-2xl mx-auto">
        <div class="p-8 bg-white rounded-lg shadow-lg">

            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800">Add a New Book</h2>
                <a href="{{ route('books.index') }}" class="px-4 py-2 text-sm font-medium text-indigo-600 border border-indigo-600 rounded-md hover:bg-indigo-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    &larr; Back to List
                </a>
            </div>

            <form class="mt-4" method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input id="title" type="text" name="title" value="{{ old('title') }}" required class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border rounded-md focus:border-indigo-400 focus:ring-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40">
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="author" class="block text-sm font-medium text-gray-700">Author</label>
                        <input id="author" type="text" name="author" value="{{ old('author') }}" required class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border rounded-md focus:border-indigo-400 focus:ring-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40">
                        @error('author') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="publisher" class="block text-sm font-medium text-gray-700">Publisher</label>
                        <input id="publisher" type="text" name="publisher" value="{{ old('publisher') }}" required class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border rounded-md focus:border-indigo-400 focus:ring-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40">
                        @error('publisher') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="year_published" class="block text-sm font-medium text-gray-700">Year Published</label>
                        <input id="year_published" type="number" name="year_published" value="{{ old('year_published') }}" required class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border rounded-md focus:border-indigo-400 focus:ring-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40">
                        @error('year_published') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="isbn" class="block text-sm font-medium text-gray-700">ISBN</label>
                        <input id="isbn" type="text" name="isbn" value="{{ old('isbn') }}" required class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border rounded-md focus:border-indigo-400 focus:ring-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40">
                        @error('isbn') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="genre" class="block text-sm font-medium text-gray-700">Genre</label>
                        <input id="genre" type="text" name="genre" value="{{ old('genre') }}" required class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border rounded-md focus:border-indigo-400 focus:ring-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40">
                        @error('genre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                        <input id="quantity" type="number" name="quantity" value="{{ old('quantity') }}" required class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border rounded-md focus:border-indigo-400 focus:ring-indigo-300 focus:outline-none focus:ring focus:ring-opacity-40">
                        @error('quantity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="image" class="block text-sm font-medium text-gray-700">Book Cover Image</label>
                        <input id="image" type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 mt-2">
                        @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full px-4 py-2 tracking-wide text-white transition-colors duration-200 transform bg-indigo-700 rounded-md hover:bg-indigo-600 focus:outline-none focus:bg-indigo-600">
                        Add Book
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection