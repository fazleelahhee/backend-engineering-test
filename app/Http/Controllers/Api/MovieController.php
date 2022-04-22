<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieRequest;
use App\Http\Resources\MovieCollection;
use App\Models\Movie;
use App\Services\Movies\Contracts\MovieContract;

/**
 * MovieController
 */
class MovieController extends Controller
{
    /**
     * List movies from database, if movie not exisit in the database
     * it will connect to the OMDB Api retrieve movie info.
     *
     * @param  MovieContract $client
     * @param  MovieRequest $request
     * @return MovieCollection
     */
    public function index(MovieContract $client, MovieRequest $request): MovieCollection
    {
        $data = $request->all();

        if (0 === count($data)) {
            return new MovieCollection(Movie::all());
        }

        $movie = new Movie();
        $movies = $movie->search($data);

        if (0 === count($movies) && isset($data['title'])) {
            $apiRespinse = $client->movie($data);

            if ("True" === $apiRespinse['response']) {
                $movie->fill((array) $apiRespinse)->save();
                $movies = $movie->search($data);
            }
        }

        return new MovieCollection($movies);
    }
}
