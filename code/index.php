<?php

require 'vendor/autoload.php';

use App\Generator\Exception\GeneratorNotFoundException;
use App\Generator\RandomGeneratorFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader('./src/view');
$twig = new Environment($loader);

$request = Request::createFromGlobals();

// Our framework is now handling itself the request
$app = new App\Kernel();

$app->map('/', function () use ($twig) {
    return new Response($twig->render('home.html.twig', [
        'title' => 'Homepage',
        'instruction' => 'Press the buttons to generate some content'
    ]));});

$app->map('/generate/{type}', function ($type) {
    try {
        $randomString = RandomGeneratorFactory::build($type)->generate();
    } catch (GeneratorNotFoundException $generatorNotFoundException) {
        return new JsonResponse([
            'title' => 'Something went wrong',
            'error' => $generatorNotFoundException->getMessage()
        ]);
    } catch (Exception $exception) {
        //Return general message. User does not need to know what went wrong
        return new JsonResponse([
            'title' => 'Something went wrong',
        ], 500);
    }

    return new JsonResponse($randomString);
});

$response = $app->handle($request);

$response->send();
