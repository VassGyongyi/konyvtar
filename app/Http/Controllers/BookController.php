<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Copy;
use App\Models\Lending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        if( Copy::where("book_id",$id)->exists())
        return response("Nem törölhetsz könyvet, amíg van példány!", 401);      
        //find helyett a paraméter
        Book::find($id)->delete();
    }
    public function titleCount($title){
        $copies = DB::table('books as b')	//egy tábla lehet csak
        //->select('mezo_neve')		//itt nem szükséges
          ->join('copies as c' ,'b.book_id','=','c.book_id') //kapcsolat leírása, akár több join is lehet
          ->where('title','=', $title) 	//esetleges szűrés
          ->count();				//esetleges aggregálás; ha select, akkor get() a vége
          return $copies;
        }

//Add meg a keménykötésű példányokat szerzővel és címmel! (ha megy, akkor a bármilyet tudj megadni paraméterrel; kemény: 1, puha: 0, hardcovered a mező)

        public function getHardcovered($hardcovered){
            $copies = DB::table('copies as c')	//egy tábla lehet csak
            ->select('author', 'title')		//itt nem szükséges
              ->join('books as b' ,'c.book_id','=','b.book_id') //kapcsolat leírása, akár több join is lehet
              ->where('hardcovered','=', $hardcovered) 	//esetleges szűrés
              ->get();				//esetleges aggregálás; ha select, akkor get() a vége
              return $copies;
            }
            //Bizonyos évben kiadott példányok névvel és címmel kiíratása.
            public function adottev($publication){
                $copies = DB::table('copies as c')	//egy tábla lehet csak
                ->select('author', 'title')		//itt nem szükséges
                  ->join('books as b' ,'c.book_id','=','b.book_id') //kapcsolat leírása, akár több join is lehet
                  ->where('publication','=', $publication) 	//esetleges szűrés
                  ->get();				//esetleges aggregálás; ha select, akkor get() a vége
                  return $copies;
                }

                //Könyvtárban lévő példányok száma:
                public function bentlevok(){
                    $copies= DB::table('copies')
                    ->where('status','=','0')
                    ->count();
                    return $copies;
                }

               // Határozd meg a könyvtár nyilvántartásában legalább 2 könyvvel rendelkező szerzőket!
                public function tobbkonyvesszerzo(){
                    $authors = DB::table('books')
                    ->selectRaw('author, count(*)')
                    
                    ->groupBy('author')
                    ->having('count(*)','>', 1)
                    // ->toRawSql();
                    ->get();
                    return $authors;

                }
                //Listázd ki a mai napon visszahozott könyveket!
                public function mavisszahozott(){
                    $list=DB::table('lendings as l')
                    ->select('author','title')
                    ->join('copies as c' ,'l.copy_id','=','c.copy_id')
                    ->join('books as b' ,'c.book_id','=','b.book_id')
                    ->whereDate('end','=',now())
                    
                     //->toRawSql();
                    ->get();
                    return $list;
                }

}
