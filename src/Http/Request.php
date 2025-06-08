<?php

namespace Neo\PicpayDesafioBackend\Http;

use stdClass;

class Request
{
    public function get(): stdClass
    {
        return (object) $_GET;
    }

    public function post(): stdClass
    {
        return (object) $_POST;
    }

    public function json(): stdClass
    {
        $json = file_get_contents('php://input');
        return json_decode($json, true) ?? new stdClass();
    }
}
