@php ob_start() @endphp

@include('filament-forms::components.text-input')

@php
$html = ob_get_clean();
// Modify default Filament input field html code, injecting identifier
$html = str_replace('<input', '<input data-qrcode-field', $html);
echo $html;
@endphp
