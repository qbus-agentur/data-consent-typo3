<?php
namespace Qbus\DataConsent;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;


/**
 * IframePlaceholderEidController
 *
 * @author Benjamin Franzke <bfr@qbus.de>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class IframePlaceholderEidController
{
    /**
     * Retrieves the image and redirect to the url
     *
     * @param  ServerRequestInterface $request  the current request object
     * @param  ResponseInterface      $response the available response
     * @return ResponseInterface      the modified response
     */
    public function processRequest(ServerRequestInterface $request, ResponseInterface $response = null)
    {
        $queryParams = $request->getQueryParams();
        $url = isset($queryParams['original_url']) ? $queryParams['original_url'] : null;
        $lang = isset($queryParams['lang']) ? $queryParams['lang'] : null;
        $templateProviderPackage = isset($queryParams['pkg']) ? $queryParams['pkg'] : 'data_consent';
        $transatlantic = isset($queryParams['transatlantic']) ? (bool)$queryParams['transatlantic'] : null;

        $escapedUrl = htmlspecialchars($url);
        $parsed  = parse_url($url);
        $escapedHost = htmlspecialchars($parsed['host']);
        $type = 'functional';

        $title = 'Content';
        if ($escapedHost === 'www.youtube.com' || $escapedHost === 'player.vimeo.com') {
            $title = 'Video';
        }

        $params = [
            'url' => $url,
            'host' => $parsed['host'],
            'type' => $type,
            'title' => $title,
            'transatlantic' => $transatlantic,
            'lang' => $lang
        ];

        $view = GeneralUtility::makeInstance(StandaloneView::class);

        $view->setPartialRootPaths([
            GeneralUtility::getFileAbsFileName('EXT:data_consent/Resources/Private/Partials/'),
            GeneralUtility::getFileAbsFileName('EXT:' . $templateProviderPackage . '/Resources/Private/Partials/')
        ]);
        $view->setTemplateRootPaths([
            GeneralUtility::getFileAbsFileName('EXT:data_consent/Resources/Private/Templates/'),
            GeneralUtility::getFileAbsFileName('EXT:' . $templateProviderPackage . '/Resources/Private/Templates/')
        ]);
        $view->setTemplate('DataConsent/IframePlaceholder');

        $view->assignMultiple($params);
        $result = $view->render();

        if ($response === null) {
            $response = new \TYPO3\CMS\Core\Http\Response();
        }
        $response->getBody()->write($result);
        return $response->withHeader('X-Robots-Tag', 'noindex');
    }
}
