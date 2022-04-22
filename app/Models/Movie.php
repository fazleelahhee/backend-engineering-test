<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Movie
 */
class Movie extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "title", "year", "rated", "genre", "director", "writer", "actors", "plot"
    ];

    /**
     * Filter movies by title, year and actor
     *
     * @param  array $params
     * @return Collection
     */
    public function search(array $params): Collection
    {
        $queryBuilder = Movie::query();

        //first looking into database if movie exists in the database
        if (!empty($params['titile'])) {
            $queryBuilder->where('title', 'LIKE', "%{$params['titile']}%");
        }

        if (!empty($params['year'])) {
            $queryBuilder->where('year', $params['year']);
        }

        if (!empty($params['actor'])) {
            $queryBuilder->where('actors', 'LIKE', "%{$params['actor']}%");
        }

        return $queryBuilder->get();
    }
}
