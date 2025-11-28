<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;


class BookController extends Controller
{
    public function index(Request $request)
    {//
        
        $query = Book::query();

       
        $query->whereRaw('quantity > (SELECT COUNT(*) FROM loans WHERE loans.book_id = books.id AND loans.returned_at IS NULL)');

        // General search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        // Specific field searches
        if ($request->filled('author')) {
            $query->where('author', 'like', '%' . $request->input('author') . '%');
        }
        if ($request->filled('isbn')) {
            $query->where('isbn', 'like', '%' . $request->input('isbn') . '%');
        }
        if ($request->filled('publisher')) {
            $query->where('publisher', 'like', '%' . $request->input('publisher') . '%');
        }

        $books = $query->latest()->paginate(10)->withQueryString();


        return view('books.index', compact('books'));

    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        return view('books.show', compact('book'));
    }

    public function create()
    {
        return view('books.create');
    }
    
    public function store(StoreBookRequest $request)
    {
        $validated = $request->validated();
    
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('book_images', 'public');
            $validated['image'] = $path;
        }

        Book::create($validated);
    
        return redirect()->route('books.index')->with('success', 'Book added successfully.');
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }
            $path = $request->file('image')->store('book_images', 'public');
            $validated['image'] = $path;
        }

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}
