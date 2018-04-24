<?php
use Poirot\Ioc\instance;
use Module\ProfileClient\Services\ServiceClientOfProfile;

return [
    'services' => [
        ServiceClientOfProfile::NAME => new instance(
            ServiceClientOfProfile::class
        ),
    ],
];
