<!-- resources/views/checkout.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check-Out</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div id="checkout-app" class="bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Check-Out Page</h1>
        <button @click="checkOut" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
            Check Out
        </button>
    </div>

    <script>
        new Vue({
            el: '#checkout-app',
            data() {
                return {
                    userId: 1, // Replace this with the actual user ID as needed
                };
            },
                mounted() {
                this.getUserIdFromUrl(); // Call the method when the component is mounted
            },
            methods: {
                             getUserIdFromUrl() {
                    const url = window.location.href; // Get the full URL
                    const match = url.match(/\/checkout\/(\d+)/); // Regex to match '/checkin/{user_id}'
                    if (match && match[1]) {
                        this.userId = match[1]; // Set the userId to the matched value
                    } else {
                        alert('User ID not found in the URL');
                    }
                },
                async checkOut() {
               if (!this.userId) {
                        alert('Invalid User ID.');
                        return;
                    }

                    try {
                        // Make an API call to check in the user
                        const response = await axios.post('/public/checkinout', {
                            user_id: this.userId,
                            action: 'checkout'
                        });
                        alert('Check-in successful!');
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
