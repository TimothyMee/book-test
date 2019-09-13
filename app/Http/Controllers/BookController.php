<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use Auth;

class BookController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('book.create');
    }

    protected function create(Request $request, Book $book)
    {
       try{
        $newBook = $book->createNew($request->all());
        return apiSuccess($newBook);
       }
       catch(\Exception $e)
       {
           return apiFailure($e->getMessage());
       }
    }

    protected function getAll(Book $book)
    {
        try{
            $books = $book->getall();
            return apiSuccess($books);
        }
            catch(\Exception $e){
             return apiFailure($e);
            }
    }

    protected function delete($id, Book $book)
    {
        try{
            $newBook = $book->deleteBook($id);
            return apiSuccess($newBook);
           }
           catch(\Exception $e)
           {
               return apiFailure($e->getMessage());
           }
    }
    //
}
