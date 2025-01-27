<?php

namespace Fadlee\FilamentQrCodeField\Forms\Components;

use Filament\Forms\Components\TextInput;

class QrCodeInput Extends TextInput
{
    // use default filament text input view
    protected string $view = 'filament-forms::components.text-input';

    protected function setUp(): void
    {
        parent::setUp();

        // Set default properties for the BarcodeInput
        $this->label('QR Code Input')
            ->extraInputAttributes(['data-qrcode-field' => '1'])
            ->placeholder('Scan QR code...');
    }
}
