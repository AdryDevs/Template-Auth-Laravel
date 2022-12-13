<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
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

            $validated = $request->validate([
                'title' => 'required',
                'author' => 'required'
            ]);
            
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

    public function getAllBooks(){

        Log::info("Getting books");

        try {
            $userId = auth()->user()->id;

            /* $books = Book::query()
            ->where('user_id', $userId)
            ->get()
            ->toArray(); */

            $books = User::find($userId)->books; //This is the same as the query above

            $books = User::with('books:id,title,user_id'); //This is the same as the query above

            return response ()->json([
                'success' => true,
                'message' => 'get all books found',
                'data' => $books
            ], 200);

        } catch (\Throwable $th) {
            Log::error("Error getting books");

            return response ()->json([
                'success' => false,
                'message' => 'Error getting books'
            ]);
        }
    }
}
