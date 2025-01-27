// Load ZXing library
let ZXing;
const loadZXingLibrary = async () => {
    if (!ZXing) {
        await import('https://unpkg.com/@zxing/library@0.21.3');
        ZXing = window.ZXing;
    }
    return ZXing;
};

let codeReader = null;
const initCodeReader = async () => {
    if (!codeReader) {
        await loadZXingLibrary();
        codeReader = new ZXing.BrowserMultiFormatReader();
    }
    return codeReader;
};

let isScanning = false;
let barcodeInputId = null;

function openScannerModal(inputId) {
  barcodeInputId = inputId;
  // Open the Filament modal
  window.dispatchEvent(new CustomEvent('open-modal', { detail: { id: 'qrcode-scanner-modal' } }));
}

function closeScannerModal() {
  // Close the Filament modal
  window.dispatchEvent(new CustomEvent('close-modal', { detail: { id: 'qrcode-scanner-modal' } }));
  stopScanning(); // Make sure to stop the camera when the modal closes
  barcodeInputId = null;
}

async function startScanner(selectedDeviceId) {
  const reader = await initCodeReader();
  reader.decodeFromVideoDevice(selectedDeviceId, 'scanner', (result, err) => {
    const scanArea = document.querySelector('.scan-area');
    if (result) {
      const barcodeInput = document.getElementById(barcodeInputId);
      if (barcodeInput) {
        // Set the value using Alpine to trigger Livewire's reactivity
        barcodeInput._x_model.set(result.text);
      }
      scanArea.style.borderColor = 'green';
      stopScanning(); // Optionally stop scanning after successful read
      closeScannerModal(); // Close the modal after successful scan
    } else if (err && !(err instanceof ZXing.NotFoundException)) {
      console.error(err);
    } else {
      scanArea.style.borderColor = 'red';
    }
  });
}

function stopScanning() {
  isScanning = false;
  const video = document.getElementById('scanner');
  if (video.srcObject) {
    video.srcObject.getTracks().forEach(track => track.stop());
  }
  video.style.display = 'none';
}

function startCamera() {
  initCodeReader().then((reader) => {
    reader.getVideoInputDevices().then((videoInputDevices) => {
      const rearCamera = videoInputDevices.find(device => device.label.toLowerCase().includes('back') || device.label.toLowerCase().includes('rear'));
      const selectedDeviceId = rearCamera ? rearCamera.deviceId : videoInputDevices[0].deviceId;

      navigator.mediaDevices.getUserMedia({ video: { deviceId: { exact: selectedDeviceId } } })
        .then(function (stream) {
          const video = document.getElementById('scanner');
          video.srcObject = stream;
          video.style.display = 'block'; // Ensure the video element is visible
          startScanner(selectedDeviceId);
        })
        .catch(function (err) {
          console.error("Error accessing the camera: ", err);
          alert("Camera access is required to scan barcodes.");
        });
    }).catch((err) => {
      console.error(err);
    });
  });
}

// Listen for modal opening and start camera
window.addEventListener('open-modal', event => {
  if (event.detail.id === 'qrcode-scanner-modal') {
    startCamera();
  }
});

// Listen for modal closing and stop camera
window.addEventListener('close-modal', event => {
  if (event.detail.id === 'qrcode-scanner-modal') {
    stopScanning();
  }
});

// Preload the ZXing library when the page loads
document.addEventListener('DOMContentLoaded', () => {
  // Preload the library but don't initialize the reader yet
  loadZXingLibrary().catch(err => {
    console.warn('Failed to preload ZXing library:', err);
  });
});
