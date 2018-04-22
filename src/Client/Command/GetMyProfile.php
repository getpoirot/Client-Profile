<?php
namespace Poirot\ProfileClient\Client\Command;

use Poirot\ApiClient\Interfaces\Request\iApiCommand;
use Poirot\ApiClient\Request\tCommandHelper;


class GetMyProfile
    implements iApiCommand
{
    use tCommandHelper;
    use tTokenAware;
}
