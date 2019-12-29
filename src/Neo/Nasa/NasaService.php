<?php


namespace App\Neo\Nasa;


use GuzzleHttp\Client;

class NasaService
{
    private $apiUrl = 'https://api.nasa.gov/neo/rest/v1/';

    private $apiKey = '0PwUQG3UbV278anbQuKzGOFpUKWuU2aQC8vFsXcE';

    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getFeed(string $since = '-3days'): array
    {
        $date = new \DateTime($since);

        $url = sprintf(
            '%s/feed?api_key=%s&detailed=true&start_date=%s',
            $this->apiUrl,
            $this->apiKey,
            $date->format('Y-m-d')
        );
        $response = $this->client->get($url);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getFeedByUrl(string $url): array
    {
        $response = $this->client->get($url);

        return json_decode($response->getBody()->getContents(), true);
    }
}