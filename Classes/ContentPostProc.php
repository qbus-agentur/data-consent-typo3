<?php
namespace Qbus\DataConsent;

use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * ContentPostProc
 *
 * @author Benjamin Franzke <bfr@qbus.de>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ContentPostProc
{
    public function postProcess(array $params)
    {
        $pObj = $params['pObj'];

        $handler = '/?eID=iframe_placeholder&';

        if (class_exists(\TYPO3\CMS\Core\Information\Typo3Version::class)) {
            if ((new \TYPO3\CMS\Core\Information\Typo3Version)->getMajorVersion() >= 10) {
                $handler = '/?prima=placeholder&';
            }
        }

        if (class_exists(SiteLanguage::class) && isset($GLOBALS['TYPO3_REQUEST']) && $GLOBALS['TYPO3_REQUEST']->getAttribute('language') instanceof SiteLanguage) {
            $language = $GLOBALS['TYPO3_REQUEST']->getAttribute('language');
            $lang = $language->getTwoLetterIsoCode();
        } elseif (class_exists(LanguageService::class)) {
            $lang = GeneralUtility::makeInstance(LanguageService::class)->lang;
            if ($lang === 'default') {
                $lang = 'en';
            }
        } else {
            $lang = $pObj->sys_language_isocode ?: ($pObj->lang ?: 'en');
        }

        $pkgArg = '';
        if (isset($pObj->config['config']['tx_data_consent.']['templateProviderPackage'])) {
            $pkgArg = '&pkg=' . rawurlencode($pObj->config['config']['tx_data_consent.']['templateProviderPackage']);
        }

        $pObj->content = preg_replace_callback(
            '/(<iframe[^>]*) src="([^"]*)"/i',
            function ($matches) use ($lang, $handler, $pkgArg) {
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
                    '%s src="/?eID=iframe_placeholder&original_url=%s&lang=%s%s" data-src="%s"',
                    $matches[1],
                    $handler,
                    $transatlantic,
                    rawurlencode($matches[2]),
                    rawurlencode($lang),
                    $pkgArg,
                    $matches[2]
                );
            },
            $pObj->content
        );
    }
}
