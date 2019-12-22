Up the containers by running

`docker-compose up -d --build`

Then install the composer bundles used by the application:

`docker exec -it -w /var/www basicmvc_php_1 composer install`

Bundles used:

    "symfony/http-foundation": "^5.0",
    "symfony/http-kernel": "^5.0",
    "symfony/routing": "^5.0",
    "guzzlehttp/guzzle": "^6.5",
    "twig/twig": "^3.0"
    

localhost:8080 will open a simple page with two buttons. Clicking on the buttons will send a ajax request. 
The response will then be shown in a notification bar. 

