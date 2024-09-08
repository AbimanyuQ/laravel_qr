<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="app">
        <h1>Users List</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id" @click="openModal(user)">
                    <td>@{{ user.id }}</td>
                    <td>@{{ user.name }}</td>
                    <td>@{{ user.email }}</td>
                    <td><button @click.stop="openModal(user)">View QR Code</button></td>
                </tr>
            </tbody>
        </table>

        <!-- Modal -->
        <div v-if="selectedUser" class="modal">
            <div class="modal-content">
                <span class="close" @click="closeModal">&times;</span>
                <h2>User QR Code</h2>
                <div id="qrcode" style="width: 200px; height: 200px;"></div>
            </div>
        </div>
    </div>

    <script>
        new Vue({
            el: '#app',
            data() {
                return {
                    users: [],
                    selectedUser: null,
                };
            },
            mounted() {
                this.fetchUsers();
            },
            methods: {
                async fetchUsers() {
                    try {
                        const response = await axios.get('/public/userslistview');
                        this.users = response.data;
                    } catch (error) {
                        console.error('Error fetching users:', error);
                    }
                },
                openModal(user) {
                    this.selectedUser = user;
                    this.$nextTick(() => {
                        // this.generateQRCode("http://qrcodeq.infinityfreeapp.com/public/checkin/"+user.name); // Pass the hashed password to generate QR code
                        
                            const checkinUrl = "http://qrcodeq.infinityfreeapp.com/public/checkin/"+user.id;
                        this.generateQRCode(checkinUrl);
                        document.querySelector('.modal').style.display = 'block';
                    });
                },
                closeModal() {
                    document.querySelector('.modal').style.display = 'none';
                    this.selectedUser = null;
                },
                generateQRCode(text) {
                    const qrcodeElement = document.getElementById('qrcode');
                    if (qrcodeElement) {
                        qrcodeElement.innerHTML = ''; // Clear previous QR code
                        new QRCode(qrcodeElement, {
                            text: text,
                            width: 200,
                            height: 200
                        });
                    }
                }
            }
        });
    </script>
</body>
</html>
