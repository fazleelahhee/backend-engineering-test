<?php

namespace App\Services\Movies;

use App\Services\Movies\Contracts\MovieContract;
use Exception;
use Illuminate\Support\Facades\Http;

class OmdbClient implements MovieContract
{
    /**
     * API URI
     *
     * @var string
     */
    protected string $uri;

    /**
     * API Key
     *
     * @var string
     */
    protected string $key;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    private array $queryParams = [
        "plot" => "full",
        "type" => "movie",
    ];


    /**
     * __construct
     *
     * @param  mixed $uri
     * @param  mixed $key
     * @return void
     */
    public function __construct(string $uri, string $key)
    {
        $this->uri = $uri;
        $this->key = $key;
    }

    /**
     * movie
     *
     * @param  mixed $params
     * @return array
     */
    public function movie(array $params = []): array
    {
        $response = Http::get("{$this->uri}?" . $this->getQueryParams($params));

        if (! $response->successful()) {
            return $response->toException();
        }

        return $this->responseFormatter($response->json());
    }

    /**
     * getQueryParams
     *
     * @param  array $params
     * @return string
     */
    protected function getQueryParams(array $params = []): string
    {
        $this->queryParams['apikey'] = $this->key;

        if (!empty($params['title'])) {
            $this->queryParams['t'] = $params['title'];
        }

        if (!empty($params['year'])) {
            $this->queryParams['y'] = $params['year'];
        }

        return http_build_query($this->queryParams);
    }

    /**
     * responseFormatter
     *
     * @param  array $data
     * @return array
     */
    protected function responseFormatter(array $data): array
    {
        $output = [];
        foreach ($data as $key => $value) {
            $output[strtolower($key)] = $value;
        }
        return $output;
    }
}
