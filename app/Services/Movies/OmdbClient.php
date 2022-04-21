<?php

namespace App\Services\Movies;

use App\Services\Movies\Contracts\MovieContract;
use Illuminate\Support\Facades\Http;

class OmdbClient implements MovieContract {
    protected string $uri;
    protected string $key;

    private array $queryParams = [
        "plot" => "full",
        "type" => "movie",
    ];
    
    public function __construct( string $uri, string $key)
    {
        $this->uri = $uri;
        $this->key = $key;
    }

    public function movie($params= [])
    {
        $response = Http::get("{$this->uri}?" . $this->getQueryParams($params));

        if (! $response->successful()) {
            return $response->toException();
        }
 
        return $this->responseFormatter($response->json());
    }

    protected function getQueryParams ($params = []): string {
        $this->queryParams['apikey'] = $this->key;
        
        if(!empty($params['title'])) {
            $this->queryParams['t'] = $params['title'];
        }

        if(!empty($params['year'])) {
            $this->queryParams['y'] = $params['year'];
        }

        return http_build_query($this->queryParams);
    }

    protected function responseFormatter($data) {
        $output = [];
        foreach($data as $key=>$value) {
            $output[strtolower($key)] = $value;
        }
        return $output;
    }


}