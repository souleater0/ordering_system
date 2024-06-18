<!-- Add the elements for the QR code scanner
<div id="reader" style="width: 500px;"></div>
<script src="../assets/libs/qrcode/html5qrcode.min.js"></script>
<script>
    $(document).ready(function() {
        // Function to handle the QR code scanning result
        function onScanSuccess(decodedText, decodedResult) {
            console.log(`Code scanned = ${decodedText}`, decodedResult);

            // Assuming the QR code contains only the table number
            const tableNumber = decodedText;

            // Store the table number in local storage
            localStorage.setItem('tableNumber', tableNumber);

            // Optionally, redirect or perform other actions
            alert(`Table number ${tableNumber} set in local storage`);

            // Stop the scanning once a code is scanned
            html5QrcodeScanner.clear();
        }

        function onScanError(errorMessage) {
            // Handle scan error if needed
            console.error(`Error scanning: ${errorMessage}`);
        }

        // Initialize the QR code scanner
        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: 250
            }
        );

        // Start scanning
        html5QrcodeScanner.render(onScanSuccess, onScanError);
    });
</script> -->

<!-- <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script> -->
<script src="../assets/libs/qrcode/html5qrcode.min.js"></script>
<style>
    #reader {
        width: 100%;
        max-width: 600px;
        margin: auto;
    }
</style>
<h1>QR Code Scanner</h1>
<div id="reader"></div>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        console.log(`Code scanned = ${decodedText}`, decodedResult);

        const tableNumber = decodedText;

        localStorage.setItem('tableNumber', tableNumber);

        alert(`Table number ${tableNumber} set in local storage`);

        html5QrcodeScanner.clear(); // Stop scanning after successful scan
    }

    function onScanError(errorMessage) {
        console.warn(`QR error = ${errorMessage}`);
    }

    const html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", {
            fps: 10,
            qrbox: 250
        }, /* verbose= */ false);
    html5QrcodeScanner.render(onScanSuccess, onScanError);
</script>