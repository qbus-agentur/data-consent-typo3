<?php
namespace Qbus\DataConsent;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Localization\LanguageService;

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

        if (class_exists(LanguageService::class)) {
            // @todo: Test this in TYPO3 v9
            $lang = GeneralUtility::makeInstance(LanguageService::class)->lang;
            if ($lang === 'default') {
                $lang = 'en';
            }
        } else {
            $lang = $pObj->sys_language_isocode ?: ($pObj->lang ?: 'en');
        }

        // @todo: Pass 'pkg' attribute as parameter to be able to override template path

        $pObj->content = preg_replace_callback(
            '/(<iframe[^>]*) src="([^"]*)"/i',
            function ($matches) use ($lang) {
                return sprintf(
                    '%s src="/?eID=iframe_placeholder&original_url=%s&lang=%s" data-src="%s"',
                    $matches[1],
                    rawurlencode($matches[2]),
                    rawurlencode($lang),
                    $matches[2]
                );
            },
            $pObj->content
        );
    }
}
