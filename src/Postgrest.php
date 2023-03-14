<?php

use Supabase\Util\PostgrestError;
use Supabase\Util\Request;

class Postgrest
{
    private $method;
    public $url;
    public $headers;
    private $body;
    private $schema;
    private $shouldThrowOnError;
    private $signal;
    private $allowEmpty;
    private $reference_id;
    private $api_key;

    public function __construct($reference_id, $api_key, $opts)
    {
        $this->method = (isset($opts['method']) && in_array($opts['method'], ['GET', 'HEAD', 'POST', 'PATCH', 'PUT', 'DELETE'])) ? $opts['method'] : null;
        $this->url = isset($opts['url']) ? $opts['url'] : "https://{$reference_id}.supabase.co/rest/v1";
        $this->headers = isset($opts['headers']) ? $opts['headers'] : [];
        $this->schema = isset($opts['schema']) ? $opts['schema'] : '';
        $this->shouldThrowOnError = isset($opts['shouldThrowOnError']) && $opts['shouldThrowOnError'];
        $this->signal = isset($opts['signal']) && $opts['signal'];
        $this->allowEmpty = isset($opts['allowEmpty']) && $opts['allowEmpty'];
        $this->body = isset($opts['body']) ? $opts['body'] : [];
    }

    public function execute()
    {
        if ($this->schema) {
            if ($this->method == 'GET' || $this->method == 'HEAD') {
                $this->headers = array_merge($this->headers, ['Accept-Profile' => $this->schema]);
            } else {
                $this->headers = array_merge($this->headers, ['Content-Profile' => $this->schema]);
                //$this->headers[] = 'Content-Profile: '.$this->schema;
            }
        }

        if ($this->method != 'GET' || $this->method != 'HEAD') {
            $this->headers = array_merge($this->headers, ['content-type' =>'application/json']);
        }

        try {
            //print_r($this->headers);
            //print_r($this->url->__toString());
            $response = Request::request($this->method, $this->url->__toString(), $this->headers, json_encode($this->body));
            $error = null;
            $count = 0;
            $status = $response->getStatusCode();
            $statusText = $response->getReasonPhrase();
            $body = json_decode($response->getBody(), true);
            $data = [];
            //print_r($body);

            if ($this->method != 'HEAD') {
                if ($body != '') {
                    if (isset($this->headers['Accept'])) {
                        if ($this->headers['Accept'] == 'text/csv') {
                            $data = $body;
                        } elseif ($this->headers['Accept'] && strpost($this->headers['Accept'], 'application/vnd.pgrst.plan+text') !== false) {
                            $data = $body;
                        }
                    } else {
                        $data = $body;
                    }
                }
            }

            $countHeader = isset($this->headers['Prefer']) ? preg_match('/count=(exact|planned|estimated)/', $this->headers['Prefer'], $matches) : null;
            $contentRange = $response->getHeader('content-range')[0];
            if ($countHeader && $contentRange) {
                $ranges = explode('/', $contentRange);
                print_r($ranges);
                if (count($ranges) > 1) {
                    $count = $ranges[1];
                }
            }

            $postgrestResponse = new PostgrestResponse($data, $error, $count, $status, $statusText);

            return $postgrestResponse;

            return $response;
        } catch (\Exception $e) {
            if (PostgrestError::isPostgrestError($e)) {
                return new PostgrestResponse(null, [
                    'message' => $e->getMessage(),
                    'details' => isset($e->details) ? $e->details : '',
                    'hint'    => isset($e->hint) ? $e->hint : '',
                    'code'    => is_null($e) ? $e->getCode() : null,
                ], null, is_null($e) ? $e->response->getStatusCode() : null);
            }

            throw $e;
        }

        if (false) {
            try {
                $error = json_decode($body);
            } catch (Exception $e) {
                $error = ['message' => $body];
            }

            if ($error && $this->allowEmpty && strpos($error->details, 'Results contain 0 rows')) {
                $error = null;
                $status = 200;
                $statusText = 'OK';
            }
        }

        $postgrestResponse = new PostgrestResponse($error, $data, $count, $status, $statusText);

        return $postgrestResponse;
    }
}

class PostgrestResponse
{
    public function __construct($data = '', $error, $count = 0, $status = 0, $statusText = '')
    {
        $this->data = $data;
        $this->error = $error;
        $this->count = $count;
        $this->status = $status;
        $this->statusText = $statusText;
    }
}
