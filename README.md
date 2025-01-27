# Filament QR Code Field

A custom form field component for Filament PHP that adds QR code scanning capabilities to your forms. This package provides a text input field with an integrated QR code scanner using the device's camera.

## Features

- Seamless integration with Filament forms
- Real-time QR code scanning using device camera
- Automatic camera selection (prefers rear camera if available)
- Modal interface for scanning QR code
- Uses ZXing library for reliable QR code detection

## Requirements

- PHP 8.1 or higher
- Laravel 10.0 or higher
- Filament 3.x

## Installation

You can install the package via composer:

```bash
composer require fadlee/filament-qrcode-field
```

After installation, you need to publish the package assets:

```bash
php artisan filament:assets
```

The package will automatically register its service provider.

## Usage

1. Import the QrcodeInput component in your Filament resource or form:

```php
use Fadlee\FilamentQrcodeField\Forms\Components\QrcodeInput;
```

2. Add the field to your form:

```php
public static function form(Form $form): Form
{
    return $form
        ->schema([
            QrcodeInput::make('qrcode')
                ->label('QR Code')
                ->placeholder('Click to scan QR code...'),
            // ... other fields
        ]);
}
```

## How it Works

The package adds QR code scanning capability to a text input field. When the input field is clicked, it opens a modal with camera access to scan QR codes. Once a QR code is successfully scanned, the value is automatically populated into the input field.

## Security

- The package requires camera permissions from the user's browser
- Camera access is only activated when the scan modal is opened
- Camera is automatically stopped when the modal is closed

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This package is open-sourced software licensed under the MIT license.
