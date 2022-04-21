<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        "title", "year", "rated", "genre", "director", "writer", "actors", "plot"
    ];

    public function search($params)
    {
        //first looking into database if movie exists in the database
        if (!empty($params['titile'])) {
            $this->where('title', 'LIKE',  "%{$params['titile']}$");
        }

        if (!empty($params['year'])) {
            $this->where('year',  $params['year']);
        }

        if (!empty($data['actor'])) {
            $this->where('actors', 'LIKE',  "%{$params['actor']}$");
        }

        return $this->get();
    }
}
