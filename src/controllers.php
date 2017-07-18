<?php

namespace Aivo;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

use Facebook\Facebook;

/**
 * Base Controller
 */
abstract class BaseController
{
    /**
     * Slim Container.
     *
     * @var Slim\Container
     */
    protected $container;

    /**
     * Constructor.
     *
     * @param Container $c
     */
    public function __construct(Container $c)
    {
        $this->container = $c;
    }
}

/**
 * Web Controller
 */
class WebController extends BaseController
{
    public function indexAction($request, $response, $args)
    {
        return $response->withJson(
            ['description' => 'This is a test for Aivo Company']
        );
    }
}

/**
 * Profile Controller
 */
class ProfileController extends BaseController
{


    /**
     * Action to get a user from facebook.
     *
     * @param  Slim\Http\Request  $request
     * @param  Slim\Http\Response $response
     * @param  array $args
     *
     * @return Json
     */
    public function getFacebookUserByIdAction($request, $response, $args)
    {
        $facebook = $this->getFacebookObject();

        $id = $args['facebookId'];
        $token = $facebook->getApp()->getAccessToken();
        $user = $facebook->get($id, $token)->getGraphUser();

        // If we need to process facebook response to reduce the information,
        // I will create a resource to reduce it, but the statement said
        // that all information is need it.

        return $response->withJson($user->asArray());
    }

    /*** Service ***/

    /**
     * Creates a facebook object.
     *
     * Note: I tried to put this code as a service, but to complete the tasks
     * I just left it here. I just need to research a little more.
     *
     * @return Facebook\Facebook
     */
    public function getFacebookObject()
    {
        $facebookSettings = $this->container->get('settings')['facebook'];
        $id = $facebookSettings['app_id'];
        $secret = $facebookSettings['app_secret'];

        $facebook =  new Facebook([
            'app_id'                => $id,
            'app_secret'            => $secret,
            'default_graph_version' => 'v2.9',
        ]);

        return $facebook;
    }
}
