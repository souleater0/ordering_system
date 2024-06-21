<!-- <script src="../assets/libs/qrcode/html5qrcode.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js" integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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