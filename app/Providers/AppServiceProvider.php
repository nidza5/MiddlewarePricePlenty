<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Services\CoreServices\PriceMonitorHttpClient;
use App\Services\CoreServices\ConfigService;
use App\Services\CoreServices\FilterStorage;
use App\Services\CoreServices\QueueStorage;
use App\Services\CoreServices\ProductService;
use App\Services\CoreServices\MapperService;
use App\Services\CoreServices\TransactionStorage;
use Patagona\Pricemonitor\Core\Infrastructure\ServiceRegister;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        config([
            'config/constants.php',
        ]);

        ServiceRegister::registerHttpClient(new PriceMonitorHttpClient());
        ServiceRegister::registerConfigService(new ConfigService());        
        ServiceRegister::registerFilterStorage(new FilterStorage());
        ServiceRegister::registerQueueStorage(new QueueStorage());        
        ServiceRegister::registerProductService(new ProductService());
        ServiceRegister::registerMapperService(new MapperService());
        ServiceRegister::registerTransactionHistoryStorage(new TransactionStorage);
    }
}
