<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request) //show all categories in the database and display the data, also filter
    {
        $categories = Category::all();
        $query = Book::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('author', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $books = Book::where('is_deleted', false)->get();
        //$books = Book::latest()->get(); //add your model to fetch data

        $books = $query->get();
        $categories = Category::active()->get();
        return view('dashboard', compact('books', 'categories')); //add a view in app/resources/views
    }

    public function trashed()
    {
        $books = Book::with('category')->where('is_deleted', true)->get();// Show only deleted books
        return view('trashed_books', compact('books'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'isbn' => 'nullable|string|unique:books',
            'publication_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'category_id' => 'nullable|exists:categories,id',
            'publisher' => 'nullable|string|max:255',
            'page_count' => 'nullable|integer|min:1',
            'language' => 'nullable|string|max:50',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            
            $validated['image'] = $imageName;
        }
        Book::create($validated);

        return redirect()->back()->with('success', 'Book created successfully!');
    }

    public function edit(Book $book)
    {
        return response()->json([
            'id' => $book->id,
            'title' => $book->title,
            'author' => $book->author,
            'isbn' => $book->isbn,
            'publication_year' => $book->publication_year,
            'category_id' => $book->category_id,
            'publisher' => $book->publisher,
            'page_count' => $book->page_count,
            'language' => $book->language,
            'image' => $book->image,
        ]);
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $book->image = $imageName;
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|unique:books,isbn,' . $book->id,
            'publication_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'category_id' => 'nullable|exists:categories,id',
            'publisher' => 'nullable|string|max:255',
            'page_count' => 'nullable|integer|min:1',
            'language' => 'nullable|string|max:50',
        ]);

        $book->title = $request->title;
        $book->save();
        $book->update($validated);

        return redirect()->back()->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book): RedirectResponse
    {
        // $book->delete(); hard delete
        $book->update(['is_deleted' => true]); //soft delete
        return redirect()->back()->with('success', 'Book deleted successfully!');
    }

    public function restore($id)
    {
        $book = Book::findOrFail($id);
        $book->update(['is_deleted' => false]);
        
        return redirect()->route('books.trashed')
            ->with('success', 'Book restored successfully.');
    }

    public function forceDelete($id)
    {
        $book = Book::findOrFail($id);
        if ($book->image) {
            $imagePath = public_path('images/' . $book->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $book->delete(); // This will permanently delete
        
        return redirect()->route('books.trashed')
            ->with('success', 'Book & Cover Image permanently deleted.');
    }

    public function exportPDF(Request $request)
    {
        $query = Book::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $books = $query->get();
        
        // Custom filename based on category
        $catName = $request->category ?: 'All';
        $filename = "Library_Report_{$catName}_" . now()->format('Ymd') . ".pdf";

        $pdf = \Pdf::loadView('exports.books_pdf', compact('books'));
        return $pdf->download($filename);
    }
}