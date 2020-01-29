<?php

namespace Fradoos\Application;

use Slim\App;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\RequestBody;
use Slim\Http\Response;
use Slim\Http\Uri;

class WebTestClient
{
    public $app;
    public $request;
    public $response;
    private $cookies = [];

    public function __construct(App $slim)
    {
        $this->app = $slim;
    }

    public function __call($method, $arguments)
    {
        throw new \BadMethodCallException(strtoupper($method) . ' is not supported');
    }

    public function get($path, $data = [], $optionalHeaders = [])
    {
        return $this->request('get', $path, $data, $optionalHeaders);
    }

    private function request($method, $path, $data = [], $optionalHeaders = [])
    {
        //Make method uppercase
        $method = strtoupper($method);
        $options = [
            'REQUEST_METHOD' => $method,
            'REQUEST_URI' => $path,
            'SERVER_NAME' => 'fradoos.local',
            'HTTP_HOST' => 'fradoos.local'
        ];

        if ($method === 'GET') {
            $options['QUERY_STRING'] = http_build_query($data);
        } else {
            $params = json_encode($data);
        }

        // Prepare a mock environment
        $env = Environment::mock(array_merge($options, $optionalHeaders));
        $uri = Uri::createFromEnvironment($env);
        $headers = Headers::createFromEnvironment($env);
        $cookies = $this->cookies;
        $serverParams = $env->all();
        $body = new RequestBody();

        // Attach JSON request
        if (isset($params)) {
            $headers->set('Content-Type', 'application/json;charset=utf8');
            $body->write($params);
        }

        $this->request = new Request($method, $uri, $headers, $cookies, $serverParams, $body);

        $response = new Response();

        try {
            // Invoke request
            $app = $this->app;
            $this->response = $app->process($this->request, $response);
            // Return the application output.
            return (string)$this->response->getBody();
        } catch (\Exception $e) {
            return (string)json_encode(["erreur" => $e->getMessage()]);
        }

    }

    public function post($path, $data = [], $optionalHeaders = [])
    {
        return $this->request('post', $path, $data, $optionalHeaders);
    }

    public function patch($path, $data = [], $optionalHeaders = [])
    {
        return $this->request('patch', $path, $data, $optionalHeaders);
    }

    public function put($path, $data = [], $optionalHeaders = [])
    {
        return $this->request('put', $path, $data, $optionalHeaders);
    }

    public function delete($path, $data = [], $optionalHeaders = [])
    {
        return $this->request('delete', $path, $data, $optionalHeaders);
    }

    public function head($path, $data = [], $optionalHeaders = [])
    {
        return $this->request('head', $path, $data, $optionalHeaders);
    }

    public function options($path, $data = [], $optionalHeaders = [])
    {
        return $this->request('options', $path, $data, $optionalHeaders);
    }

    public function setCookie($name, $value)
    {
        $this->cookies[$name] = $value;
    }
}