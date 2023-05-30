<?php 

namespace Souravmsh\CompressedHtml;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use Souravmsh\CompressedHtml\Http\Middleware\CompressedHtmlMiddleware;


class PackageServiceProvider extends ServiceProvider
{
    public function boot(Kernel $kernel)
    {
        $kernel->pushMiddleware(CompressedHtmlMiddleware::class);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/compressed-html.php', 'compressed-html');
    } 
}