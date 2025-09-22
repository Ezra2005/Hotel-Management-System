<<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            background: linear-gradient(135deg, #1e88e5, #0d47a1);
            color: white;
            padding: 20px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 24px;
            font-weight: bold;
        }
        
        nav ul {
            display: flex;
            list-style: none;
        }
        
        nav ul li {
            margin-left: 20px;
        }
        
        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            transition: background 0.3s;
        }
        
        nav ul li a:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .main-content {
            padding: 40px 0;
        }
        
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin-bottom: 25px;
        }
        
        .card-header {
            font-size: 22px;
            margin-bottom: 20px;
            color: #1e88e5;
            border-bottom: 2px solid #e3f2fd;
            padding-bottom: 10px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: #1e88e5;
            color: white;
        }
        
        .btn-primary:hover {
            background: #1565c0;
        }
        
        .btn-danger {
            background: #e53935;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c62828;
        }
        
        .btn-success {
            background: #43a047;
            color: white;
        }
        
        .btn-success:hover {
            background: #388e3c;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        table, th, td {
            border: 1px solid #ddd;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
        }
        
        th {
            background-color: #e3f2fd;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .alert-error {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ef9a9a;
        }
        
        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .stat-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #1e88e5;
            margin: 10px 0;
        }
        
        .stat-title {
            font-size: 16px;
            color: #666;
        }
        
        footer {
            text-align: center;
            padding: 20px 0;
            margin-top: 40px;
            color: #666;
            border-top: 1px solid #ddd;
        }
        
        .login-container {
            max-width: 400px;
            margin: 40px auto;
        }
        
        .guest-dashboard, .admin-dashboard {
            display: none;
        }
        
        .room-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .room-type {
            font-weight: bold;
            color: #1e88e5;
        }
        
        .room-price {
            font-size: 20px;
            margin: 10px 0;
        }
        
        .room-features {
            margin: 10px 0;
            color: #666;
        }
        
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <header>
        <div class="container header-content">
            <div class="logo">LGU Hotel</div>
            <nav>
                <ul>
                    <li><a href="#" id="nav-home">Home</a></li>
                    <li><a href="#" id="nav-bookings">My Bookings</a></li>
                    <li><a href="#" id="nav-rooms">Rooms</a></li>
                    <li><a href="#" id="nav-admin" class="hidden">Admin</a></li>
                    <li><a href="#" id="nav-login">Login</a></li>
                    <li><a href="#" id="nav-logout" class="hidden">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container main-content">
        <!-- Login/Register Section -->
        <div id="login-section">
            <div class="login-container">
                <div class="card">
                    <h2 class="card-header">Login to Your Account</h2>
                    <div id="login-message"></div>
                    <form id="login-form">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                    <p style="margin-top: 20px;">
                        Don't have an account? <a href="#" id="show-register">Register here</a>
                    </p>
                </div>

                <div class="card hidden" id="register-card">
                    <h2 class="card-header">Create New Account</h2>
                    <div id="register-message"></div>
                    <form id="register-form">
                        <div class="form-group">
                            <label for="reg-username">Username</label>
                            <input type="text" id="reg-username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="reg-password">Password</label>
                            <input type="password" id="reg-password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="reg-name">Full Name</label>
                            <input type="text" id="reg-name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="reg-email">Email</label>
                            <input type="email" id="reg-email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="reg-phone">Phone</label>
                            <input type="tel" id="reg-phone" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                    <p style="margin-top: 20px;">
                        Already have an account? <a href="#" id="show-login">Login here</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Guest Dashboard -->
        <div id="guest-dashboard" class="guest-dashboard">
            <h2 class="card-header">Guest Dashboard</h2>
            <div class="dashboard-grid">
                <div class="stat-card">
                    <div class="stat-title">Current Bookings</div>
                    <div class="stat-number">2</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Pending Requests</div>
                    <div class="stat-number">1</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Total Spent</div>
                    <div class="stat-number">$450</div>
                </div>
            </div>

            <div class="card">
                <h3 class="card-header">My Bookings</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Room Type</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>BK001</td>
                            <td>Deluxe Room</td>
                            <td>2023-06-15</td>
                            <td>2023-06-20</td>
                            <td>Confirmed</td>
                            <td>
                                <button class="btn btn-primary">View</button>
                                <button class="btn btn-danger">Cancel</button>
                            </td>
                        </tr>
                        <tr>
                            <td>BK002</td>
                            <td>Standard Room</td>
                            <td>2023-07-01</td>
                            <td>2023-07-05</td>
                            <td>Pending</td>
                            <td>
                                <button class="btn btn-primary">View</button>
                                <button class="btn btn-danger">Cancel</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card">
                <h3 class="card-header">Available Rooms</h3>
                <div class="room-card">
                    <div class="room-type">Standard Room</div>
                    <div class="room-price">$99 per night</div>
                    <div class="room-features">Free WiFi, TV, Air Conditioning</div>
                    <button class="btn btn-primary">Book Now</button>
                </div>
                <div class="room-card">
                    <div class="room-type">Deluxe Room</div>
                    <div class="room-price">$149 per night</div>
                    <div class="room-features">Free WiFi, TV, Air Conditioning, Mini Bar</div>
                    <button class="btn btn-primary">Book Now</button>
                </div>
                <div class="room-card">
                    <div class="room-type">Suite</div>
                    <div class="room-price">$249 per night</div>
                    <div class="room-features">Free WiFi, TV, Air Conditioning, Mini Bar, Jacuzzi</div>
                    <button class="btn btn-primary">Book Now</button>
                </div>
            </div>
        </div>

        <!-- Admin Dashboard -->
        <div id="admin-dashboard" class="admin-dashboard">
            <h2 class="card-header">Admin Dashboard</h2>
            <div class="dashboard-grid">
                <div class="stat-card">
                    <div class="stat-title">Total Rooms</div>
                    <div class="stat-number">25</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Occupied Now</div>
                    <div class="stat-number">18</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Today's Check-ins</div>
                    <div class="stat-number">5</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Revenue (Month)</div>
                    <div class="stat-number">$12,540</div>
                </div>
            </div>

            <div class="card">
                <h3 class="card-header">Room Management</h3>
                <button class="btn btn-success" style="margin-bottom: 15px;">Add New Room</button>
                <table>
                    <thead>
                        <tr>
                            <th>Room ID</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>101</td>
                            <td>Standard</td>
                            <td>$99</td>
                            <td>Available</td>
                            <td>
                                <button class="btn btn-primary">Edit</button>
                                <button class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>102</td>
                            <td>Deluxe</td>
                            <td>$149</td>
                            <td>Occupied</td>
                            <td>
                                <button class="btn btn-primary">Edit</button>
                                <button class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>201</td>
                            <td>Suite</td>
                            <td>$249</td>
                            <td>Maintenance</td>
                            <td>
                                <button class="btn btn-primary">Edit</button>
                                <button class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card">
                <h3 class="card-header">All Bookings</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Guest</th>
                            <th>Room</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>BK001</td>
                            <td>John Doe</td>
                            <td>Deluxe Room</td>
                            <td>2023-06-15</td>
                            <td>2023-06-20</td>
                            <td>Confirmed</td>
                            <td>
                                <button class="btn btn-primary">View</button>
                                <button class="btn btn-danger">Cancel</button>
                            </td>
                        </tr>
                        <tr>
                            <td>BK002</td>
                            <td>Jane Smith</td>
                            <td>Standard Room</td>
                            <td>2023-07-01</td>
                            <td>2023-07-05</td>
                            <td>Pending</td>
                            <td>
                                <button class="btn btn-primary">View</button>
                                <button class="btn btn-danger">Cancel</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Access Denied Message -->
        <div id="access-denied" class="card hidden">
            <h2 class="card-header">Access Denied</h2>
            <div class="alert alert-error">
                You don't have permission to access this feature. Please contact administrator if you believe this is an error.
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2023 Grand Hotel Booking System. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // DOM Elements
        const loginSection = document.getElementById('login-section');
        const guestDashboard = document.getElementById('guest-dashboard');
        const adminDashboard = document.getElementById('admin-dashboard');
        const accessDenied = document.getElementById('access-denied');
        const navAdmin = document.getElementById('nav-admin');
        const navLogin = document.getElementById('nav-login');
        const navLogout = document.getElementById('nav-logout');
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');
        const loginCard = document.querySelector('.card:not(#register-card)');
        const registerCard = document.getElementById('register-card');
        const showRegister = document.getElementById('show-register');
        const showLogin = document.getElementById('show-login');
        const loginMessage = document.getElementById('login-message');
        const registerMessage = document.getElementById('register-message');

        // Show Register Form
        showRegister.addEventListener('click', function(e) {
            e.preventDefault();
            loginCard.classList.add('hidden');
            registerCard.classList.remove('hidden');
        });

        // Show Login Form
        showLogin.addEventListener('click', function(e) {
            e.preventDefault();
            registerCard.classList.add('hidden');
            loginCard.classList.remove('hidden');
        });

        // Login Form Submission
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            
            // Simple validation
            if (!username || !password) {
                showMessage(loginMessage, 'Please enter both username and password', 'error');
                return;
            }
            
            // Simulate authentication - in real app, this would be a PHP API call
            if (username === 'admin' && password === 'admin123') {
                // Admin login
                login('admin');
                showMessage(loginMessage, 'Login successful! Redirecting...', 'success');
            } else if (username === 'guest' && password === 'guest123') {
                // Guest login
                login('guest');
                showMessage(loginMessage, 'Login successful! Redirecting...', 'success');
            } else {
                showMessage(loginMessage, 'Invalid username or password', 'error');
            }
        });

        // Register Form Submission
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const username = document.getElementById('reg-username').value;
            const password = document.getElementById('reg-password').value;
            const name = document.getElementById('reg-name').value;
            const email = document.getElementById('reg-email').value;
            const phone = document.getElementById('reg-phone').value;
            
            // Simple validation
            if (!username || !password || !name || !email || !phone) {
                showMessage(registerMessage, 'Please fill all fields', 'error');
                return;
            }
            
            // Simulate registration - in real app, this would be a PHP API call
            showMessage(registerMessage, 'Registration successful! You can now login.', 'success');
            
            // Switch to login form after a delay
            setTimeout(() => {
                registerCard.classList.add('hidden');
                loginCard.classList.remove('hidden');
            }, 2000);
        });

        // Logout functionality
        navLogout.addEventListener('click', function(e) {
            e.preventDefault();
            logout();
        });

        // Navigation to admin section
        navAdmin.addEventListener('click', function(e) {
            e.preventDefault();
            const userRole = getUserRole();
            
            if (userRole === 'admin') {
                showAdminDashboard();
            } else {
                showAccessDenied();
            }
        });

        // Show message function
        function showMessage(element, message, type) {
            element.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
        }

        // Login function
        function login(role) {
            // Set user data in localStorage (in real app, this would be session-based)
            localStorage.setItem('userRole', role);
            localStorage.setItem('isLoggedIn', 'true');
            
            // Update UI based on role
            if (role === 'admin') {
                showAdminDashboard();
            } else {
                showGuestDashboard();
            }
            
            // Update navigation
            navLogin.classList.add('hidden');
            navLogout.classList.remove('hidden');
            
            if (role === 'admin') {
                navAdmin.classList.remove('hidden');
            }
        }

        // Logout function
        function logout() {
            // Clear user data
            localStorage.removeItem('userRole');
            localStorage.removeItem('isLoggedIn');
            
            // Show login section
            loginSection.style.display = 'block';
            guestDashboard.style.display = 'none';
            adminDashboard.style.display = 'none';
            accessDenied.classList.add('hidden');
            
            // Update navigation
            navLogin.classList.remove('hidden');
            navLogout.classList.add('hidden');
            navAdmin.classList.add('hidden');
        }

        // Get user role from storage
        function getUserRole() {
            return localStorage.getItem('userRole');
        }

        // Check if user is logged in
        function isLoggedIn() {
            return localStorage.getItem('isLoggedIn') === 'true';
        }

        // Show guest dashboard
        function showGuestDashboard() {
            loginSection.style.display = 'none';
            guestDashboard.style.display = 'block';
            adminDashboard.style.display = 'none';
            accessDenied.classList.add('hidden');
        }

        // Show admin dashboard
        function showAdminDashboard() {
            loginSection.style.display = 'none';
            guestDashboard.style.display = 'none';
            adminDashboard.style.display = 'block';
            accessDenied.classList.add('hidden');
        }

        // Show access denied message
        function showAccessDenied() {
            loginSection.style.display = 'none';
            guestDashboard.style.display = 'none';
            adminDashboard.style.display = 'none';
            accessDenied.classList.remove('hidden');
        }

        // Check authentication status on page load
        document.addEventListener('DOMContentLoaded', function() {
            if (isLoggedIn()) {
                const role = getUserRole();
                if (role === 'admin') {
                    showAdminDashboard();
                } else {
                    showGuestDashboard();
                }
                
                navLogin.classList.add('hidden');
                navLogout.classList.remove('hidden');
                
                if (role === 'admin') {
                    navAdmin.classList.remove('hidden');
                }
            } else {
                loginSection.style.display = 'block';
                guestDashboard.style.display = 'none';
                adminDashboard.style.display = 'none';
            }
        });
    </script>
</body>
</html>