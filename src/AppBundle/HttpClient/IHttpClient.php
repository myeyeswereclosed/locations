<?php

namespace AppBundle\HttpClient;

use Psr\Http\Message\ResponseInterface;

interface IHttpClient
{
    // for now it's only GET
    public function get(string $url, array $headers = array()) : ResponseInterface;
}