<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieRequest;
use App\Http\Resources\MovieResourceCollection;
use App\Models\Movie;
use App\Services\Movies\Contracts\MovieContract;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MovieContract $client, MovieRequest $request)
    {
        $data = $request->all();

        if(0 === count($data)) {
            return new MovieResourceCollection(Movie::all());
        }

        $movie = new Movie();
        $movies = $movie->search($data);
        
        if(0 === count($movies) && isset($data['title'])) {
            $apiRespinse = $client->movie($data);
  
            if("True" === $apiRespinse['response']) {
                $movie->fill($apiRespinse)->save();
                $movies = $movie->search($data);
            }
            
        }

       return $movies;
    }
}
