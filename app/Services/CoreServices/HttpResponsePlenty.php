<?php

namespace  App\Services\CoreServices;

use Patagona\Pricemonitor\Core\Interfaces\HttpResponse as HttpResponseInterface;


class HttpResponsePlenty implements HttpResponseInterface
{
    /** @var int */
    protected $status;

    /** @var array */
    protected $headers;

    /** @var string */
    protected $body;

    public function __construct($status, array $headers = [], $body = '')
    {
        $this->status = $status;
        $this->headers = $headers;
        $this->body = $body;
    }

    /**
     * Gets response HTTP status code
     *
     * @return int HTTP response status code. For example 200 for "200 OK", 404 for "404 Not found"...
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Gets response headers
     *
     * @return array Response headers list where key is header name and value is header value. Example:
     *      [ "content-type" => "application/json; charset=utf-8", "connection" => "keep-alive" ]
     */
    public function getHeaders()
    {
        $headers = [];

        // Represent the headers as a string
        foreach ($this->headers as $name => $values) {
            $headers[$name] = implode(", ", $values);
        }

        return $headers;
    }

    /**
     * Gets response body string
     *
     * @return string Response payload without any decoding, if payload is in json format for example string representation
     * of that json should be returned.
     */
    public function getBody()
    {
        return $this->body;
    }
}

?>