<?php

namespace App\Generator;

use App\Generator\Exception\ContentNotFoundException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use HttpResponseException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class RandomChuckNorrisFactGenerator implements RandomGeneratorInterface
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var ClientInterface
     */
    private ClientInterface $client;

    public function __construct(LoggerInterface $logger, ClientInterface $client)
    {
        $this->logger = $logger;
        $this->client = $client;
    }

    /**
     * @return string
     * @throws ContentNotFoundException
     * @throws HttpResponseException
     * @throws GuzzleException
     */
    public function generate(): string
    {
        $response = $this->client->request('GET', 'https://api.chucknorris.io/jokes/random');

        if ($response->getStatusCode() === 200) {
            return $this->retrieveContent($response);
        }

        throw new HttpResponseException(
            sprintf('Response with status code %d returned', $response->getStatusCode())
        );
    }

    /**
     * @param ResponseInterface $response
     * @return string
     * @throws ContentNotFoundException
     */
    private function retrieveContent(ResponseInterface $response): string
    {
        $contents = $response->getBody()->getContents();
        $contentsAsArray = \GuzzleHttp\json_decode($contents, true);
        if (isset($contentsAsArray['value'])) {
            return $contentsAsArray['value'];
        }

        $message = 'No content could be retrieved from the chuck norris api';
        $this->logger->critical($message);

        throw new ContentNotFoundException($message);
    }
}
