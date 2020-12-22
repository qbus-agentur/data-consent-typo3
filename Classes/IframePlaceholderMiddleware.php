<?php

declare(strict_types=1);

namespace Qbus\DataConsent;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class IframePlaceholderMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $prima = isset($queryParams['prima']) ? $queryParams['prima'] : null;
        // @todo would love to use if ($request->getUri()->getPath() === '/prima/placeholder')
        // but the route is not available automatically
        if ($prima === 'placeholder') {
            return (new IframePlaceholderEidController)->processRequest($request);
        }

        return $handler->handle($request);
    }
}
