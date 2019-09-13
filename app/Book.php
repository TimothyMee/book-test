<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Book extends Model
{
    //

    protected $fillable = [
        'title', 'volume', 'author', 'year', 'genre', 'deleted_at', 'deleted_by'
    ];

    public function createNew($data)
    {
        $data['author'] = auth()->id();
        return $this->create($data);
    }

    public function getall()
    {
        return $this->where('deleted_at', null)->with('author')->get();
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'author');
    }
    public function getBook($author)
    {
        return $this->where("author", $author)->get();
    }

    public function getBookWithGenre($genre)
    {
       return  $this->where("genre", $genre)->get();
    }

    public function deleteBook($id)
    {
        return $this->where("id", $id)
                ->update(["deleted_at" => date('Y-m-d'), "deleted_by" => auth()->id()]);
    }
}
