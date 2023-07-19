<?php

declare(strict_types=1);

namespace Qbus\DataConsent\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * @author Benjamin Franzke <bfr@qbus.de>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
final class ContentPostProc implements MiddlewareInterface
{
    private StreamFactoryInterface $streamFactory;

    public function __construct(
        StreamFactoryInterface $streamFactory
    ) {
        $this->streamFactory = $streamFactory;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        $content = $response->getBody()->__toString();

        if (!str_contains($content, '<iframe')) {
            return $response;
        }

        $language = $request->getAttribute('language');
        $site = $request->getAttribute('site');

        $handlerUri = rtrim((string)$site->getBase(), '/') . '/iframe-placeholder';
        $tsfe = $request->getAttribute('frontend.controller', $GLOBALS['TSFE'] ?? null);

        $lang = $language->getTwoLetterIsoCode();

        $pkgArg = '';
        if ($tsfe && isset($tsfe->config['config']['tx_data_consent.']['templateProviderPackage'])) {
            $pkgArg = '&pkg=' . rawurlencode($tsfe->config['config']['tx_data_consent.']['templateProviderPackage']);
        }

        $newContent = $content;
        foreach (['"', '\''] as $quote) {
            $newContent = preg_replace_callback(
                '/(<iframe[^>]*) src=' . $quote . '([^' . $quote . ']*)' . $quote . '/i',
                function ($matches) use ($lang, $handlerUri, $pkgArg, $quote) {
                    $transatlantic = 0;
                    $host = parse_url($matches[2], PHP_URL_HOST);
                    if ($host !== false && in_array($host, [
                        'www.youtube.com',
                        'www.youtube-nocookie.com',
                        'player.vimeo.com',
                        'maps.google.com',
                    ])) {
                        $transatlantic = 1;
                    }

                    return sprintf(
                        '%s src="%s?transatlantic=%s&original_url=%s&lang=%s%s" data-src="%s"',
                        $matches[1],
                        $handlerUri,
                        $transatlantic,
                        rawurlencode($matches[2]),
                        rawurlencode($lang),
                        $pkgArg,
                        $matches[2]
                    );
                },
                $newContent
            );
        }

        return $response->withBody(
            $this->streamFactory->createStream($newContent)
        );
    }
}
