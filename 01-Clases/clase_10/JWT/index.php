<?php
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;
    use \Firebase\JWT\JWT; //Agrego esta línea

    require 'vendor/autoload.php';

    $config['displayErrorDetails'] = true;
    $config['addContentLengthHeader'] = false;

    $app = new \Slim\App(["settings" => $config]);
    
    $app->group('/auth', function()
    {


        //Codifico el JWT:
        $this->post("/login", function($request, $response, $args) {

            //Tomo el usuario
            $body = $request->getParsedBody();
            $user = $body["user"];
            $pass = $body["pass"];
            $ahora = time(); //en unix

            //creo una key secreta:
            $key = "example_key";

            //Creo el payload como un array:
            $payload = array(
                
                "iat" => $ahora, //cuando se creo
                "usuario" => $user,
                "pass" => $pass
                
            );

            //codifico el token:
            $jwt = JWT::encode($payload, $key);

            $newResponse = $response->withJson($jwt, 200);

            return $newResponse;
            
        });


        //Decodifico el JWT:
        $this->get("[/]", function($request, $response, $args){

            $key = "example_key";

            //Uso un try catch
            try
            {
                //recupero el token
                $jwt = $request->getParam("token");

                //Lo decodifico
                $decoded = JWT::decode($jwt, $key, array("HS256"));

                $newResponse = $response->withJson($decoded, 200);
            }
            catch(Exception $e)
            {
                $newResponse = $e->getMessage();
            }

            return $newResponse;


        });
        
        
        
    });

    

    //siempre!!:
    $app->run();


?>