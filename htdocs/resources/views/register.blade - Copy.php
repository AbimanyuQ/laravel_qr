<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vue.js QR Code Registration</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form div {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div id="app">
        <h1>Register</h1>
        <form @submit.prevent="registerUser">
            <div>
                <label for="name">Name:</label>
                <input v-model="name" type="text" required />
            </div>
            <div>
                <label for="email">Email:</label>
                <input v-model="email" type="email" required />
            </div>
            <div>
                <label for="password">Password:</label>
                <input v-model="password" type="password" required />
            </div>
            <div>
                <label for="password_confirmation">Confirm Password:</label>
                <input v-model="password_confirmation" type="password" required />
            </div>
            <button type="submit">Register</button>
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
