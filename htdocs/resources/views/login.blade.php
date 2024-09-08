<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
   <style>
        .form-container {
            max-width: 500px; /* Adjust this value to your preference */
            padding: 2rem; /* Increased padding */
        }

        .custom-input {
            font-size: 1rem; /* Adjust font size */
            padding: 0.75rem; /* Adjust padding */
            line-height: 1.5rem; /* Adjust line-height */
        }

        .custom-button {
            padding: 0.75rem 1rem; /* Adjust button padding */
            font-size: 1rem; /* Adjust button font size */
        }

        .form-title {
            font-size: 1.5rem; /* Adjust form title font size */
            margin-bottom: 1rem; /* Adjust margin for the title */
        }

        .form-description {
            font-size: 1.25rem; /* Adjust description font size */
            margin-bottom: 1rem; /* Adjust margin for the description */
        }

                .form-description1 {
            font-size: 0.875rem; /* Adjust description font size */
            margin-bottom: 1rem; /* Adjust margin for the description */
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
    <div id="app" class="form-container bg-white p-6 rounded-lg shadow-lg w-full sm:w-3/4 md:w-1/2 lg:w-1/3 xl:w-1/4">
        <h1 class="text-2xl font-semibold mb-6 text-center form-title">Login</h1>
        <p class="form-description">Welcome Back! 👋</p>
        <p class="form-description1">Please login to your account and view your dashboard</p>
        <form @submit.prevent="registerUser">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Email</label>
                <input v-model="email" type="text" id="email" required 
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none custom-input" />
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input v-model="password" type="password" id="password" required 
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none custom-input" />
            </div>

            <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 custom-button">Login</button>
        </form>
    </div>

    <script>
        new Vue({
            el: '#app',
            data() {
                return {
                    email: '',
                    password: '',

                };
            },
            methods: {
                async registerUser() {
                    try {
                        const response = await axios.post('/public/login_data', {
                            email: this.email,
                            password: this.password,
                        });

                        if (response.status === 200) {
                            // alert('Login successful!');
                            //  window.location.href = '/public/userslist';
                                     alert(response.data.message); // Display the success message
            // Optionally redirect or perform other actions here
            window.location.href = '/public/userslist';
                            
                        } else {
                            alert('login failed.');
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
