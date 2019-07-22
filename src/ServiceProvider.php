<?php

namespace HerCat\BaiduTranslator;

/**
 * Class ServiceProvider.
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton(function ($app) {
            return new BaiduTranslator(
                config('translator.app_id'),
                config('translator.key')
            );
        });

        $this->app->alias(BaiduTranslator::class, 'baiduTranslator');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [BaiduTranslator::class, 'baiduTranslator'];
    }
}
