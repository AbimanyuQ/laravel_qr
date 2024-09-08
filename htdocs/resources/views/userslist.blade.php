<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.2/dist/tailwind.min.css" rel="stylesheet">


    <!--link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"-->
  <!--link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"-->
  <!--link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"-->
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
            font-family: arial,sans-serif;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        td{
            text-align: center;
        }
        th{
            text-align:center;
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
<body class="font-sans bg-gray-100 p-4 md:p-8">
  <div id="app" class="max-w-10xl mx-auto">
  <div class="mb-6 flex flex-row justify-between">
        <button
        @click="create_user"
      
        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 disabled:bg-gray-300 mb-4 md:mb-0"
      >
        Create new user
      </button>


            <button
        @click="logout"
        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 disabled:bg-gray-300 mb-4 md:mb-0"
      >
        logout
      </button>
  
  </div>
    <h1 class="text-2xl font-semibold mb-6">Users List</h1>
    
    <!-- Search and Filter Section -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
      <input
        type="text"
        v-model="searchQuery"
        placeholder="Search users..."
        class="border border-gray-300 p-2 rounded-lg mb-4 md:mb-0 w-full md:w-1/2"
      />
      <select v-model="selectedFilter" class="border border-gray-300 p-2 rounded-lg w-full md:w-1/4">
        <option value="">All Statuses</option>
        <option value="checkin">Check-in</option>
        <option value="checkout">Check-out</option>
      </select>
    </div>

    <!-- Users Grid (for mobile view) -->
    <div class="grid grid-cols-1 gap-6 md:hidden">
      <div v-for="user in paginatedUsers" :key="user.id" class="bg-white border border-gray-300 rounded-lg shadow-md p-4 cursor-pointer hover:bg-gray-100" @click="openModal(user)">
        <div class="text-center mb-4">
          <h3 class="text-lg font-semibold">@{{ user.name }}</h3>
          <p class="text-gray-600">@{{ user.email }}</p>
        </div>
        <div class="text-center">
          <p class="text-gray-800">ID: @{{ user.id }}</p>
          <p class="text-gray-800">Action: @{{ user.action }}</p>
          <button @click.stop="openModal(user)" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mt-4">
            <span class="hidden md:inline">View QR Code</span>
            <span class="md:hidden">View</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Users Table (for larger screens) -->
    <div class="hidden md:block">
      <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
        <thead class="bg-gray-200 text-gray-600">
          <tr>
            <th class="py-3 px-4 text-left">ID</th>
            <th class="py-3 px-4 text-left">Name</th>
            <th class="py-3 px-4 text-left">Email</th>
            <th class="py-3 px-4 text-left">Action</th>
            <th class="py-3 px-4 text-left">Status</th>
          </tr>
        </thead>
        <tbody class="text-gray-800">
          <tr v-for="user in paginatedUsers" :key="user.id" @click="openModal(user)" class="cursor-pointer hover:bg-gray-100">
            <td class="py-3 px-4 text-center">@{{ user.id }}</td>
            <td class="py-3 px-4">@{{ user.name }}</td>
            <td class="py-3 px-4">@{{ user.email }}</td>
            <td class="py-3 px-4">
              <!--button @click.stop="openModal(user)" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                View QR Code
              </button-->

    <button 
              @click.stop="openModal(user)" 
              :class="{
                'bg-green-500': canViewQRCode(user),
                'bg-gray-500': !canViewQRCode(user),
                'cursor-not-allowed': !canViewQRCode(user)
              }" 
              :disabled="!canViewQRCode(user)"
              class="text-white px-4 py-2 rounded hover:bg-green-600"
            >
              View QR Code
            </button>

            </td>
            <td class="py-3 px-4 text-center">@{{ user.action }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination Controls -->
    <div class="mt-6 flex flex-row md:flex-row items-center justify-between">
      <button
        @click="prevPage"
        :disabled="currentPage === 1"
        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 disabled:bg-gray-300 mb-4 md:mb-0"
      >
        Previous
      </button>
      <span class="text-sm text-gray-700 mb-4 md:mb-0">
        Page @{{ currentPage }} of @{{ totalPages }}
      </span>
      <button
        @click="nextPage"
        :disabled="currentPage === totalPages"
        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 disabled:bg-gray-300"
      >
        Next
      </button>
    </div>

    <!-- Modal -->
    <div v-if="selectedUser" id="modal" class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-50">
      <div class="bg-white p-6 rounded-lg shadow-lg relative max-w-lg w-full">
        <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl" @click="closeModal">&times;</button>
        <h2 class="text-xl font-semibold mb-4">User QR Code</h2>
        <div class="flex flex-col items-center gap-6">
          <div id="qrcode" class="w-52 h-52"></div>
          <div v-if="confirmationMessage" class="text-green-600">@{{ confirmationMessage }}</div>
        </div>
      </div>
    </div>
  </div>

</body>

    <script>
 new Vue({
    el: '#app',
    data() {
        return {
        users: [],
        searchQuery: '',
        selectedUser: null,
         selectedFilter: '',
        currentPage: 1,
        perPage: 10,
        totalPages: 1,
        confirmationMessage: '',
        polling: null // To store the polling interval ID
        };
    },

     computed: {
    filteredUsers() {
      return this.users.filter(user => {
        return (
          user.name.toLowerCase().includes(this.searchQuery.toLowerCase()) &&
          (this.selectedFilter === '' || user.action === this.selectedFilter)
        );
      });
    },
    paginatedUsers() {
      const start = (this.currentPage - 1) * this.perPage;
      const end = start + this.perPage;
      this.totalPages = Math.ceil(this.filteredUsers.length / this.perPage);
      return this.filteredUsers.slice(start, end);
    }
  },
    mounted() {
        this.fetchUsers();
    },
        watch: {
        selectedUser(newUser, oldUser) {
            if (newUser && newUser.id !== (oldUser && oldUser.id)) {
                // When selectedUser changes, start polling for the new user
                if (this.pollingInterval) {
                    clearInterval(this.pollingInterval);
                     this.users
                }
                this.startPolling(newUser.id);
            }
        }
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
  canViewQRCode(user) {
        if (user.action === 'checkout') {
            const lastCheckout = new Date(user.timestamp);
            console.log(lastCheckout);
            const now = new Date();
            const hoursDifference = (now - lastCheckout) / (1000 * 60 * 60); // Convert milliseconds to hours
            
            // Log the values for debugging
            console.log(`Last checkout: ${lastCheckout}`);
            console.log(`Current time: ${now}`);
            console.log(`Hours difference: ${hoursDifference}`);
            
            return hoursDifference > 8; // Enable if more than 8 hours have passed
        }
        return true; // Enable if not checked out
    },
        openModal(user) {
            this.selectedUser = user;
             this.confirmationMessage = ''; 
            this.$nextTick(async () => {
                // Determine the next action based on the last action
                const action = user.action === 'checkin' ? 'checkout' : 'checkin';
                const url = `http://qrcodeq.infinityfreeapp.com/public/${action}/${user.id}`;
                this.generateQRCode(url);
                document.querySelector('.modal').style.display = 'block';
                this.confirmationMessage = '';
                await this.checkUserStatus(user.id);
                this.startPolling(user.id);
            });
        },

        create_user(){

             window.location.href = '/public/register';
            

        },

        logout(){

             window.location.href = '/public/logout';

        },

             async startPolling(userId) {
            const interval = 3000; // Polling interval in milliseconds (e.g., 3 seconds)
            this.pollingInterval = setInterval(async () => {
                await this.checkUserStatus(userId);
            }, interval);
        },
        
        async checkUserStatus(userId) {
            try {
                const response = await axios.get(`/public/check-status/${userId}`);
                const { action } = response.data;
                
                if (action) {
                    this.confirmationMessage = `User is currently ${action}.`;
                }
            } catch (error) {
                console.error('Error checking user status:', error);
            }
        },
   async performAction() {
        if (!this.selectedUser) return;

        try {
            // Determine the next action based on the last action
            const action = this.selectedUser.action === 'checkin' ? 'checkout' : 'checkin';
            const response = await axios.post(`/public/checkinoutdata`, {
                user_id: this.selectedUser.id,
                action: action
            });

            // Update the confirmation message based on the response
            if (response.data.message.includes('successful')) {
                this.confirmationMessage = `User ${action} successful!`;
                // Optionally, fetch updated user data
                await this.fetchUsers();
            } else {
                this.confirmationMessage = response.data.message;
            }
        } catch (error) {
            console.error('Error performing action:', error);
            this.confirmationMessage = 'Failed to perform action.';
        }
    },

 beforeDestroy() {
        // Clear the polling interval when the component is destroyed
        if (this.pollingInterval) {
            clearInterval(this.pollingInterval);
        }
    },

    async pollForStatusUpdate(userId) {
        const interval = 3000; // Polling interval in milliseconds (e.g., 3 seconds)
        this.polling = setInterval(async () => {
            try {
                const response = await axios.get(`/public/check-status/${userId}`);
                const { action, message } = response.data;

                // Update confirmation message if the action has changed
                if (action) {
                    this.selectedUser.action = action;
                    if (message.includes('successful')) {
                        this.confirmationMessage = `User ${action} successful!`;
                        clearInterval(this.polling); // Stop polling after successful action
                    } else {
                        this.confirmationMessage = message;
                    }
                }
            } catch (error) {
                console.error('Error polling user status:', error);
                this.confirmationMessage = 'Failed to check user status.';
                clearInterval(this.polling); // Stop polling on error
            }
        }, interval);
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
        },
           prevPage() {
      if (this.currentPage > 1) {
        this.currentPage -= 1;
      }
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage += 1;
      }
    },
  closeModal() {

                   this.selectedUser = null; // Hide the modal
        this.confirmationMessage = ''; // Clear confirmation message
        this.fetchUsers();

        // const modal = document.querySelector('.modal');
        // if (modal) {
        //     modal.style.display = 'none';
        // }
    },
    }
});

    </script>
</body>
</html>
