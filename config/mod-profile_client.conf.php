<?php
use Module\ProfileClient\Module;
use Module\ProfileClient\Services\ServiceClientOfProfile;

return [
    Module::CONF => [
        ServiceClientOfProfile::CONF => [
            'server_url' => 'http://0.0.0.0',
        ],
    ],
];
