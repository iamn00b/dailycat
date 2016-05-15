<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
        ],

        'verify_token' => "EAAD5QZBRfqv0BADZBqAhpBn3ZBJCcppPlOf97WvZAV3d3ASIVZALRseSmmv6zESA5VEe0p9U1pAb82tv9DL3oamJjgMJEFmShZCP81uApsA7hXgx4vcQ1baQ3W9NRQCZAF5GFBaHqyTS8QQHf6VoHFmPc0dMTBDK0f8qN9l2WF58wZDZD",

        'token' => "EAAD5QZBRfqv0BAClVCE676Re9YIwiVWeQq3sVAqZBbanOkeFYxRp6OLSniOLO53kzT6f16lri41VDBOxZAmpvYRlamTDOZCTPuEHzvlD8vFQwv9dr3yMsRnUhYTVbn9D77xGANhWqolRT1M0owNFXVH6ZBht3AqWoxFvfXuDHDAZDZD"
    ],
];
