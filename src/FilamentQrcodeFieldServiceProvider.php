<?php

namespace Fadlee\FilamentQrcodeField;

use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Package;

class FilamentQrcodeFieldServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-qrcode-field';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasViews();
    }

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'qrcode-field');

        // The js will be published by artisan filament:assets
        // to public/js/qrcode-field/qrcode-field.js
        FilamentAsset::register([
            Js::make('qrcode-scanner', __DIR__ . '/../resources/js/qrcode-scanner.js')
                ->loadedOnRequest(), // will be loaded from modal view
        ], 'qrcode-field');

        // Inject QR code scanner modal into the end of page
        FilamentView::registerRenderHook(
            PanelsRenderHook::PAGE_END,
            fn () => view('qrcode-field::qrcode-input-modal')
        );
    }
}
