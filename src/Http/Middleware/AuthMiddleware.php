<?php

namespace Neo\PicpayDesafioBackend\Http\Middleware;

use Neo\PicpayDesafioBackend\Http\Response;

class AuthMiddleware implements InterfaceMiddleware
{
    public function handle(): ?Response
    {
        return null;
    }
}
