<?php

declare(strict_types=1);

namespace Qbus\DataConsent\Middleware;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Routing\SiteRouteResult;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * @author Benjamin Franzke <bfr@qbus.de>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
final class IframePlaceholder implements MiddlewareInterface
{
    private ResponseFactoryInterface $responseFactory;

    public function __construct(
        ResponseFactoryInterface $responseFactory
    ) {
        $this->responseFactory = $responseFactory;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $normalizedParams = $request->getAttribute('normalizedParams');
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($normalizedParams);
        //exit;

        $queryParams = $request->getQueryParams();
        $prima = isset($queryParams['prima']) ? $queryParams['prima'] : null;
        // @todo would love to use if ($request->getUri()->getPath() === '/prima/placeholder')
        // but the route is not available automatically
        /** @var SiteRouteResult $routing */
        $routing = $request->getAttribute('routing');
        if ($routing === null || $routing->getTail() !== 'iframe-placeholder') {
            return $handler->handle($request);
        }

        $url = isset($queryParams['original_url']) ? $queryParams['original_url'] : '';
        $lang = isset($queryParams['lang']) ? $queryParams['lang'] : null;
        $templateProviderPackage = isset($queryParams['pkg']) ? $queryParams['pkg'] : 'data_consent';
        $transatlantic = isset($queryParams['transatlantic']) ? (bool)$queryParams['transatlantic'] : null;

        $escapedUrl = htmlspecialchars($url);
        $parsed  = parse_url($url);
        $escapedHost = htmlspecialchars($parsed['host'] ?? '');
        $type = 'functional';

        $title = 'Content';
        if ($escapedHost === 'www.youtube.com' || $escapedHost === 'player.vimeo.com') {
            $title = 'Video';
        }

        $params = [
            'url' => $url,
            'host' => $parsed['host'] ?? '',
            'type' => $type,
            'title' => $title,
            'transatlantic' => $transatlantic,
            'lang' => $lang,
        ];

        $view = GeneralUtility::makeInstance(StandaloneView::class);

        $view->setPartialRootPaths([
            GeneralUtility::getFileAbsFileName('EXT:data_consent/Resources/Private/Partials/'),
            GeneralUtility::getFileAbsFileName('EXT:' . $templateProviderPackage . '/Resources/Private/Partials/'),
        ]);
        $view->setTemplateRootPaths([
            GeneralUtility::getFileAbsFileName('EXT:data_consent/Resources/Private/Templates/'),
            GeneralUtility::getFileAbsFileName('EXT:' . $templateProviderPackage . '/Resources/Private/Templates/'),
        ]);
        $view->setTemplate('DataConsent/IframePlaceholder');

        $view->assignMultiple($params);
        $result = $view->render();

        $response = $this->responseFactory
            ->createResponse(200)
            ->withHeader('Content-Type', 'text/html; charset=utf-8')
            ->withHeader('X-Robots-Tag', 'noindex');
        $response->getBody()->write($result);

        return $response;
    }
}
