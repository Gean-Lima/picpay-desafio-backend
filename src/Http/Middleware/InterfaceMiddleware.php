<?php

namespace Neo\PicpayDesafioBackend\Http\Middleware;

use Neo\PicpayDesafioBackend\Http\Response;

interface InterfaceMiddleware
{
    public function handle(): ?Response;
}
