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
        #webcam-container {
            text-align: center;
            margin: 20px;
        }
        #reader {
            width: 300px;
            height: 300px;
            border: 1px solid black;
            display: inline-block;
        }
        #open-camera {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
        }
    </style>
     <div id="webcam-container">
        <h2>Scan Table QR</h2>
        <div id="reader"></div>
        <br>
        <button id="open-camera">Open Camera</button>
    </div>

    <!-- Include the HTML5 QR Code library -->
    <script src="../assets/libs/qrcode/html5qrcode.min.js"></script>
    <script>
        const openCameraButton = document.getElementById('open-camera');
        const reader = new Html5Qrcode("reader");

        openCameraButton.addEventListener('click', () => {
            console.log('Open Camera button clicked');
            Html5Qrcode.getCameras().then(cameras => {
                if (cameras && cameras.length) {
                    console.log('Cameras found: ', cameras);

                    // Attempt to find the rear camera
                    const rearCamera = cameras.find(camera => 
                        camera.label.toLowerCase().includes('back') ||
                        camera.label.toLowerCase().includes('rear')
                    );

                    const cameraId = rearCamera ? rearCamera.id : cameras[0].id;

                    reader.start(
                        cameraId,
                        {
                            fps: 10, // Optional, frames per second for QR code scanning
                            qrbox: { width: 300, height: 300 }, // Size of the scanning box
                            aspectRatio: 1.0 // Ensures the box is square
                        },
                        qrCodeMessage => {
                            // console.log(`QR Code detected: ${qrCodeMessage}`);
                            // alert(`QR Code detected: ${qrCodeMessage}`);
                            // Store the QR code result (table number) in local storage
                            localStorage.setItem('tableNumber', qrCodeMessage);
                            window.location.href = "index.php?route=personal-form";
                        },
                        errorMessage => {
                            console.error(`QR Code scanning error: ${errorMessage}`);
                        }
                    ).catch(err => {
                        console.error(`Error starting the QR code scanner: ${err}`);
                    });
                } else {
                    console.error('No cameras found');
                    alert('No cameras found');
                }
            }).catch(err => {
                console.error(`Error getting camera list: ${err}`);
                alert(`Error getting camera list: ${err}`);
            });
        });
    </script>