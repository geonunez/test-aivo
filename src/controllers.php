<?php

namespace Aivo;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * I APPLY A DJANGO PHILOSOPHY TO MAKE THE TEST SIMPLE.
 * IF THE PROJECT WAS BIG, EACH CONTROLLER WOULD HAD ITS OWN FILE.
 */

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
 * Base Api Controller
 */
abstract class BaseApiController extends BaseController
{
    /**
     * Creates an api error result.
     *
     * @param  string $message
     * @param  int    $statusCode
     *
     * @return  array
     */
    protected function createErrorResult($message, $statusCode)
    {
        // Log the message
        $this->container->logger->addInfo($message);

        return [
            'description' => $message,
            'statusCode'  => $statusCode
        ];
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
class ProfileController extends BaseApiController
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
        $statusCode = 200;
        $facebook = $this->getFacebookObject();

        $id = $args['facebookId'];
        $token = $facebook->getApp()->getAccessToken();
        try {
            $facebookResponse = $facebook->get($id, $token);
            $user = $facebookResponse->getGraphUser();

            // If we need to process facebook response to reduce the information,
            // I will create a resource to reduce it, but the statement said
            // that all information is need it.
            $result = $user->asArray();

        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            $message = 'Graph returned an error: ' . $e->getMessage();
            $statusCode = 400;
            $result = $this->createErrorResult($message, $statusCode);
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            $message = 'Graph returned an error: ' . $e->getMessage();
            $statusCode = 500;
            $result = $this->createErrorResult($message, $statusCode);
        }

        return $response->withJson($result, $statusCode);
    }

    /*** Service ***/

    /**
     * Creates a facebook object.
     *
     * Note: I tried to put this code as a service, but to complete the tasks
     * I just left it here. I just need to research a little more to create
     * a services using Slim.
     *
     * @return Facebook\Facebook
     */
    public function getFacebookObject()
    {
        $facebookSettings = $this->container->get('settings')['facebook'];
        $id = $facebookSettings['app_id'];
        $secret = $facebookSettings['app_secret'];

        $facebook =  new \Facebook\Facebook([
            'app_id'                => $id,
            'app_secret'            => $secret,
            'default_graph_version' => 'v2.9',
        ]);

        return $facebook;
    }
}
