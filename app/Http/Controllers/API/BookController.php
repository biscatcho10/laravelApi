<?php

namespace App\Http\Controllers\API;

use App\Book;
use App\Http\Controllers\Controller;
use App\Traits\generalTrailt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{

    use generalTrailt;


    public function index()
    {
        $books = Book::all();
        return $this->sendResponse($books->toArray() , 'Books Read Successfully');
    }

    public function store(Request $request){

        $inputs = $request->all();
        $rules = [
            'name' => 'required',
            'details' => 'required',
        ];
        $validator = Validator::make($inputs, $rules);

        if($validator->fails()){
            return $this->sendError('Error Validation', $validator->errors());
        }

        $book = Book::create($inputs);
        return $this->sendResponse($book->toArray() , 'Book Created Successfully Successfully');
    }

    public function show($id){
        $book = Book::find($id);
        if(! $book){
            return $this->sendError('Book Not Found !');
        }
        return $this->sendResponse($book->toArray() , 'Book Read Successfully');
    }

    public function Update(Request $request, $id){
        $rules = [
            'name' => 'required',
            'details' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return $this->sendError('Error Validation', $validator->errors());
        }


        $book = Book::find($id);
        if(! $book){
            return $this->sendError('Book Not Found !');
        }

        $book->update([
            'name'=> $request->name,
            'details'=> $request->name,
        ]);

        return $this->sendResponse($book->toArray() , 'Book Updated Successfully Successfully');
    }

    public function destroy($id){
        $book = Book::find($id);
        if(! $book){
            return $this->sendError('Book Not Found !');
        }
        $book->delete();
        return $this->sendResponse($book->toArray() , 'Book Deleted Successfully Successfully');
    }
}
