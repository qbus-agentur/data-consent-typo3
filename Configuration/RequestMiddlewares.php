<?php
/**
 * An array consisting of implementations of middlewares for a middleware stack to be registered
 *
 *  'stackname' => [
 *      'middleware-identifier' => [
 *         'target' => classname or callable
 *         'before/after' => array of dependencies
 *      ]
 *   ]
 */
return [
    'frontend' => [
        'qbus/data-consent/iframe-placeholder' => [
            'target' => \Qbus\DataConsent\IframePlaceholderMiddleware::class,
            'after' => [
                'typo3/cms-frontend/tsfe',
                'typo3/cms-frontend/prepare-tsfe-rendering',
            ]
        ],
    ]
];
