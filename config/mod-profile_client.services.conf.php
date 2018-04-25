<?php
use Poirot\Ioc\instance;
use Module\ProfileClient\Services\ServiceTokenForClient;
use Poirot\ApiClient\Interfaces\Token\iTokenProvider;
use Module\ProfileClient\Services\ServiceClientOfProfile;

return [
    'implementations' => [
        ServiceTokenForClient::NAME => iTokenProvider::class,
    ],
    'services' => [
        ## Profile Client
        #
        ServiceClientOfProfile::NAME => new instance(
            ServiceClientOfProfile::class
        ),

        ## Token Provider For Client
        #
        ServiceTokenForClient::NAME => ServiceTokenForClient::class,
    ],
];
