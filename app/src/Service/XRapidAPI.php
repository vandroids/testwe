<?php
declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class XRapidAPI
{
    /**
     * @todo refactor rate limit logic
     */
    public const RATE_LIMIT_PER_RUN = 500;
    public const RATE_LIMIT_PER_SECOND = 10;

    protected const HEADER_KEY = 'X-RapidAPI-Key';
    protected const HEADER_HOST = 'X-RapidAPI-Host';

    protected string $url;
    protected string $key;
    protected string $host;

    protected HttpClientInterface $client;

    public function __construct(
        HttpClientInterface $client,
        string $rapidApiUrl,
        string $rapidApiKey,
        string $rapidApiHost
    )
    {
        $this->client = $client;
        $this->url = $rapidApiUrl;
        $this->key = $rapidApiKey;
        $this->host = $rapidApiHost;
    }

    public function getMovieImage(string $title): ?string
    {
        $response = $this->client->request(
            Request::METHOD_GET,
            $this->url,
            [
                'query' => [
                    'q' => $title,
                ],
                'headers' => [
                    self::HEADER_KEY => $this->key,
                    self::HEADER_HOST => $this->host,
                ],
            ]
        );

        $status = $response->getStatusCode();

        if (Response::HTTP_OK !== $status) {
            return null;
        }

        $content = json_decode($response->getContent(), true);

        return $content['results'][0]['image']['url'] ?? null;
    }
}