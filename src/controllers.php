<?php

namespace Aivo;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

use Facebook\Facebook;

class ProfileController
{
    protected $container;

    public function __construct(Container $c)
    {
        $this->container = $c;
    }

    public function getFacebookUserById($request, $response, $args)
    {
        $facebookId = $args['facebookId'];
        $facebook = $this->getFacebookEntity();
        $user = $facebook->get('/me?fields=id,name')->getGraphUser();
        return json_encode(['name' => 'Jorge Nuñez']);
    }

    /*** Service ***/

    public function getFacebookEntity()
    {
        $facebookSettings = $this->container->get('settings')['facebook'];
        $id = $facebookSettings['id'];
        $secret = $facebookSettings['secret'];

        $facebook =  new Facebook([
            'app_id'                => $id,
            'app_secret'            => $secret,
            'default_graph_version' => 'v2.9',
        ]);

        return $facebook;
    }
}
