<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom CSS */
        .form-container {
            max-width: 500px; /* Adjust this value to your preference */
        }

        .custom-input {
    font-size: 0.875rem; /* .sm\:text-sm equivalent */
    line-height: 2.25rem; /* Your desired line height */
}

    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
    <div id="app" class="form-container bg-white p-6 rounded-lg shadow-lg w-full sm:w-3/4 md:w-1/2 lg:w-1/3 xl:w-1/4">
        <h1 class="text-2xl font-semibold mb-6 text-center">Register</h1>
        <form @submit.prevent="registerUser">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
<input v-model="name" type="text" id="name" required class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 custom-input" />
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                <input v-model="email" type="email" id="email" required class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm custom-input" />
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
                <input v-model="password" type="password" id="password" required class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm custom-input" />
            </div>
            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password:</label>
                <input v-model="password_confirmation" type="password" id="password_confirmation" required class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm custom-input" />
            </div>
            <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">Register</button>
        </form>
    </div>

    <script>
        new Vue({
            el: '#app',
            data() {
                return {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    qrCodeData: null,
                };
            },
            methods: {
                async registerUser() {
                    try {
                        const response = await axios.post('/public/register', {
                            name: this.name,
                            email: this.email,
                            password: this.password,
                            password_confirmation: this.password_confirmation,
                        });

                        if (response.status === 200) {
                            // alert('Registration successful!');
                             window.location.href = '/public/userslist';
                        } else {
                            alert('Registration failed.');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('An error occurred during registration.');
                    }
                }
            },
        });
    </script>
</body>
</html>
