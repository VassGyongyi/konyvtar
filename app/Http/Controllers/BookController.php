<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(){
        $books = response()->json(Book::all());
        return $books;
    }

    public function show($id){
        $book = response()->json(Book::find($id));
        return $book;
    }

    public function store(Request $request){
        $Book = new Book();
        $Book->author = $request->author;
        $Book->title = $request->title;
        $Book->save();
    }

    public function update(Request $request, $id){
        $Book = Book::find($id);
        $Book->author = $request->author;
        $Book->title = $request->title;
        $Book->save();
    }
    public function destroy($id)
    {
        //find helyett a paraméter
        Book::find($id)->delete();
    }
}
