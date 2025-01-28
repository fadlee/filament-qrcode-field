# Filament QR Code Field

A custom form field component for Filament PHP that adds QR code scanning capabilities to your forms. This package provides a text input field with an integrated QR code scanner using the device's camera.

## Features

- Seamless integration with Filament forms
- Support for multiple QR code inputs on a single page
- Compatible with Filament action modals
- Real-time QR code scanning using device camera
- Automatic camera selection (prefers rear camera if available)
- Modal interface for scanning QR code
- Uses ZXing library for reliable QR code detection

## Requirements

- PHP 8.1 or higher
- Laravel 10.0 or higher
- Filament 3.x
- HTTPS enabled environment (required for camera access)

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

1. Import the QrCodeInput component in your Filament resource or form:

```php
use Fadlee\FilamentQrCodeField\Forms\Components\QrCodeInput;
```

2. Add the field to your form:

```php
public static function form(Form $form): Form
{
    return $form
        ->schema([
            QrCodeInput::make('qrcode')
                ->label('QR Code')
                ->placeholder('Click to scan QR code...'),
            // ... other fields
        ]);
}
```

3. Using multiple QR code inputs:

```php
public static function form(Form $form): Form
{
    return $form
        ->schema([
            QrCodeInput::make('product_code')
                ->label('Product QR Code')
                ->placeholder('Scan product code...'),
            QrCodeInput::make('location_code')
                ->label('Location QR Code')
                ->placeholder('Scan location code...'),
        ]);
}
```

4. Using in Filament action modals:

```php
use Filament\Actions\Action;

public static function getActions(): array
{
    return [
        Action::make('scanQR')
            ->form([
                QrCodeInput::make('qrcode')
                    ->label('Scan QR Code')
                    ->required(),
            ])
            ->action(function (array $data) {
                // Process the scanned QR code
                // $data['qrcode'] contains the scanned value
            }),
    ];
}
```

## How it Works

The package adds QR code scanning capability to a text input field. When the input field is clicked, it opens a modal with camera access to scan QR codes. Once a QR code is successfully scanned, the value is automatically populated into the input field.

## Security

- The package requires camera permissions from the user's browser
- Camera access is only activated when the scan modal is opened
- Camera is automatically stopped when the modal is closed

## Technical Implementation

The QR code scanner is seamlessly integrated into Filament through several key mechanisms:

1. **Modal Injection**: The package automatically injects the QR code scanner modal markup at the end of each Filament page using Filament's render hooks system.

2. **JavaScript Integration**: The package includes a custom JavaScript component that handles the camera access and QR code scanning.

3. **Event Handling**: The package uses event delegation to handle QR code scanning requests. When a QR code input field is clicked, the scanner modal is automatically opened and the camera is activated.

4. **Camera Access**: The package uses the browser's `getUserMedia` API to request camera access. Due to browser security policies, HTTPS is required for camera access to work. The camera is automatically selected as the rear camera if available, and the user is prompted to grant camera access.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Credits

This package was inspired by and contains code adapted from the [barcode-field](https://github.com/Design-The-Box/barcode-field) package by Design-The-Box. We appreciate their contribution to the Filament ecosystem.

## License

This package is open-sourced software licensed under the MIT license.
