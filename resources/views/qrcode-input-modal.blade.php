<script src="{{ \Filament\Support\Facades\FilamentAsset::getScriptSrc('qrcode-scanner', 'qrcode-field') }}"></script>

<script>
document.body.addEventListener('click', function(event) {
    if (event.target.hasAttribute('data-qrcode-field')) {
        openScannerModal(event.target.id);
    }
});
</script>

<!-- Filament Modal for QR Code Scanner -->
<x-filament::modal id="qrcode-scanner-modal">
    <x-slot name="header">
        <h2 class="text-lg font-semibold">
            Scan QR Code
        </h2>
    </x-slot>

    <div class="p-4">
        <div id="scanner-container">
            <video id="scanner" autoplay class="rounded-lg shadow" style="display: none;"></video>
            <div class="overlay">
                <div class="scan-area"></div>
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <x-filament::button onclick="closeScannerModal()" color="danger">
            Close
        </x-filament::button>
    </x-slot>
</x-filament::modal>
