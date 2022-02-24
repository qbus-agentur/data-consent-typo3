<?php

namespace Qbus\DataConsent;

return [
    'frontend' => [
        'qbus/data-consent/iframe-placeholder' => [
            'target' => Middleware\IframePlaceholder::class,
            'before' => [
                'typo3/cms-frontend/page-resolver',
            ],
            'after' => [
                'typo3/cms-frontend/site',
                'typo3/cms-frontend/maintenance-mode',
            ],
        ],
        'qbus/data-consent/consent-post-proc' => [
            'target' => Middleware\ContentPostProc::class,
            'before' => [
                'typo3/cms-core/response-propagation',
            ],
            'after' => [
                'typo3/cms-frontend/content-length-headers',
                'typo3/cms-frontend/tsfe',
            ],
        ],
    ],
];
