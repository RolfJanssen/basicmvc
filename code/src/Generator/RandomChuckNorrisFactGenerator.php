<?php

namespace App\Generator;

use App\Model\Exception\ContentNotFoundException;
use GuzzleHttp\Client;
use HttpResponseException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class RandomChuckNorrisFactGenerator implements RandomGeneratorInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return string
     * @throws ContentNotFoundException
     * @throws HttpResponseException
     */
    public function generate(): string
    {
        $client = new Client();
        $response = $client->request('GET', 'https://api.chucknorris.io/jokes/random');

        if ($response->getStatusCode() === 200) {
            return $this->retrieveContent($response);
        } else {
            throw new HttpResponseException(
                sprintf('Response with status code %d returned', $response->getStatusCode())
            );
        }
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
        } else {
            $message = 'No content could be retrieved from the chuck norris api';
            $this->logger->critical($message);

            throw new ContentNotFoundException($message);
        }
    }
}
