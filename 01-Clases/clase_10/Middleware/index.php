<?php
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;
    use \Firebase\JWT\JWT; //Agrego esta línea

    require 'vendor/autoload.php';
    require_once './middleware.php';

    $config['displayErrorDetails'] = true;
    $config['addContentLengthHeader'] = false;

    $app = new \Slim\App(["settings" => $config]);
    
    $app->group('/auth', function()
    {

        //Codifico el JWT:
        $this->post("/login", function($request, $response, $args) {

            return $response->withStatus(200)->write(" hola ");
            
        });
    
    });

    //Agrego middleware
    $app->add(\Middleware::class . "::ValidarClave");

    //siempre!!:
    $app->run();


?>