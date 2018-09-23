<?php
namespace Module\ProfileClient
{
    use Poirot\Application\ModuleManager\Interfaces\iModuleManager;
    use Poirot\Std\Interfaces\Struct\iDataEntity;
    use Poirot\Application\Interfaces\Sapi;
    use Poirot\Ioc\Container;
    use Poirot\Loader\Autoloader\LoaderAutoloadAggregate;
    use Poirot\Loader\Autoloader\LoaderAutoloadNamespace;


    class Module implements Sapi\iSapiModule
        , Sapi\Module\Feature\iFeatureModuleAutoload
        , Sapi\Module\Feature\iFeatureModuleInitModuleManager
        , Sapi\Module\Feature\iFeatureModuleMergeConfig
        , Sapi\Module\Feature\iFeatureModuleNestServices
    {
        const CONF = 'module.client.profile';


        /**
         * @inheritdoc
         */
        function initAutoload(LoaderAutoloadAggregate $baseAutoloader)
        {
            $nameSpaceLoader = \Poirot\Loader\Autoloader\LoaderAutoloadNamespace::class;
            /** @var LoaderAutoloadNamespace $nameSpaceLoader */
            $nameSpaceLoader = $baseAutoloader->loader($nameSpaceLoader);
            $nameSpaceLoader->addResource(__NAMESPACE__, __DIR__);


            require_once __DIR__.'/_functions.php';
        }

        /**
         * @inheritdoc
         */
        function initModuleManager(iModuleManager $moduleManager)
        {
            if (! $moduleManager->hasLoaded('OAuth2Client') )
                $moduleManager->loadModule('OAuth2Client');
        }

        /**
         * @inheritdoc
         */
        function initConfig(iDataEntity $config)
        {
            return \Poirot\Config\load(__DIR__ . '/../config/mod-profile_client');
        }

        /**
         * @inheritdoc
         */
        function getServices(Container $moduleContainer = null)
        {
            $conf = \Poirot\Config\load(__DIR__ . '/../config/mod-profile_client.services', true);
            return $conf;
        }
    }
}

namespace Module\ProfileClient
{
    use Poirot\ProfileClient\ClientFolio;
    use Poirot\ProfileClient\ClientProfile;


    /**
     * @method static ClientProfile ClientProfile()
     * @method static ClientFolio   ClientFolio()
     */
    class Services extends \IOC
    { }
}
