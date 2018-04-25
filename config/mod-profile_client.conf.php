<?php
use Module\ProfileClient\Module;
use Module\ProfileClient\Services\ServiceClientOfProfile;

return [
    Module::CONF => [
        ServiceClientOfProfile::CONF => [
            'server_url'     => 'http://0.0.0.0',

            #'token_provider' => '/module/clientProfile/services/TokenProvider',
            'token_provider' => new \Poirot\Ioc\instance(
                \Module\ProfileClient\Services\ServiceTokenForClient::class
            )
        ],
    ],
];
