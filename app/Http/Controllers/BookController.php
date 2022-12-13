<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Termwind\Components\Dd;

class BookController extends Controller
{
    public function createBook(Request $request){
        try {
            $userId = auth()->user()->id;
            $title = $request->input('title');
            $author = $request->input('author');

            $validated = $request->validate([
                'title' => 'required',
                'author' => 'required'
            ]);

            return response ()->json([
                'success' => true,
                'message' => 'Book created'
            ]);
            Log::error("Error creating book");
        } catch (\Throwable $th) {
            return response ()->json([
                'success' => false,
                'message' => 'Error creating book'
            ]);
        }
    }

    public function updateBook(Request $request, $id){
        try {
            $userId = auth()->user()->id;
            $title = $request->input('title');
            $author = $request->input('author');
            
            $book = Book::query()
            ->where('user_id', $userId)
            ->where('id', $id)
            ->first();

            if(!$book){
                return response ()->json([
                    'success' => false,
                    'message' => 'Book not found'
                ], 404);
            }

        } catch (\Throwable $th) {
            Log::error("Error updating book");
            return response ()->json([
                'success' => false,
                'message' => 'Error updating book'
            ]);
        }
    }
}
