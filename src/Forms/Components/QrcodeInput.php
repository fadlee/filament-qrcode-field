<?php

namespace Fadlee\FilamentQrcodeField\Forms\Components;

use Filament\Forms\Components\TextInput;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;

class QrcodeInput Extends TextInput
{
    protected string $view = 'qrcode-field::qrcode-input';

    protected function setUp(): void
    {
        parent::setUp();

        // Set default properties for the BarcodeInput
        $this->label('QR Code Input')
            ->placeholder('Scan QR code...');
    }
}
