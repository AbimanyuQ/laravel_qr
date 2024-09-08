<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check-In</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Vue.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <!-- Axios CDN -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div id="checkin-app" class="bg-white p-8 rounded-lg shadow-md w-96">
        <h1 class="text-2xl font-bold mb-4">Check-In Page</h1>
        <button @click="checkIn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            Check In
        </button>
        <!-- Success Message -->
        <div v-if="showSuccess" class="mt-4 p-4 bg-blue-100 text-blue-700 rounded-lg flex items-center">
            <!-- Success Icon -->
            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.656 8.656l-6 6c-.195.195-.451.293-.707.293s-.512-.098-.707-.293l-3-3c-.195-.195-.293-.451-.293-.707s.098-.512.293-.707l.707-.707c.195-.195.451-.293.707-.293.256 0 .512.098.707.293l2.293 2.293 5.293-5.293c.195-.195.451-.293.707-.293s.512.098.707.293l.707.707c.195.195.293.451.293.707s-.098.512-.293.707z"/>
            </svg>
            <span>Check-in successful!</span>
        </div>
    </div>

    <script>
        new Vue({
            el: '#checkin-app',
            data() {
                return {
                    userId: null, // Initially set to null
                    showSuccess: false, // Control visibility of the success message
                };
            },
            mounted() {
                this.getUserIdFromUrl(); // Call the method when the component is mounted
            },
            methods: {
                // Method to extract the user_id from the URL
                getUserIdFromUrl() {
                    const url = window.location.href; // Get the full URL
                    const match = url.match(/\/checkin\/(\d+)/); // Regex to match '/checkin/{user_id}'
                    if (match && match[1]) {
                        this.userId = match[1]; // Set the userId to the matched value
                    } else {
                        alert('User ID not found in the URL');
                    }
                },
                // Method to handle the check-in process
                async checkIn() {
                    if (!this.userId) {
                        alert('Invalid User ID.');
                        return;
                    }

                    try {
                        // Make an API call to check in the user
                        const response = await axios.post('/public/checkinout', {
                            user_id: this.userId,
                            action: 'checkin'
                        });
                        this.showSuccess = true; // Show success message
                    } catch (error) {
                        console.error('Error during check-in:', error);
                        alert('Failed to check in.');
                    }
                }
            }
        });
    </script>
</body>
</html>
