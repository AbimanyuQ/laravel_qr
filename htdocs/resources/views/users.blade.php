<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Attendance System</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.2.0/html5-qrcode.min.js"></script>
</head>
<body>
    <div id="app">
        <h2>QR Code Attendance System</h2>

        <!-- Input to enter User ID -->
        <input type="text" v-model="userId" placeholder="Enter User ID">
        <button @click="generateQRCode">Generate QR Code</button>

        <!-- QR Code Display -->
        <div id="qrcode"></div>

        <!-- Scanner Section -->
        <h3>Scan QR Code to Check In/Out</h3>
        <video id="preview" style="width: 300px; height: 300px;"></video>
    </div>

    <script>
        new Vue({
            el: '#app',
            data: {
                userId: '', // Binding input value
                qrCode: null,
            },
            methods: {
                // Function to generate QR Code
                generateQRCode() {
                    if (!this.userId) {
                        alert('Please enter a User ID');
                        return;
                    }

                    // Clear previous QR Code if it exists
                    document.getElementById('qrcode').innerHTML = '';

                    // Generate new QR code with the user ID
                    this.qrCode = new QRCode(document.getElementById('qrcode'), {
                        text: this.userId,
                        width: 128,
                        height: 128,
                    });
                },

                // Function to handle the QR code scanning
                onScanSuccess(decodedText) {
                    // Display the scanned user ID in console
                    console.log(`Scanned user ID: ${decodedText}`);

                    // Call backend API for check-in
                    fetch(`/check-in/${decodedText}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                    })
                        .then((response) => response.json())
                        .then((data) => alert(data.message))
                        .catch((error) => console.error('Error:', error));
                },
            },
            mounted() {
                // Initialize the QR code scanner when the component is mounted
                const html5QrcodeScanner = new Html5QrcodeScanner(
                    'preview',
                    { fps: 10, qrbox: 250 },
                    false
                );
                html5QrcodeScanner.render(this.onScanSuccess);
            },
        });
    </script>
</body>
</html>
