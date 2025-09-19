<!DOCTYPE html>
<html>
<head>
    <title>Booking Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .error {
            color: red;
            font-size: 0.9em;
            display: none;
        }
        button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h2>Booking Form</h2>
    <?php
    session_start();
    // Generate CSRF token
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    ?>
    <form id="bookingForm" action="process.php" method="POST">
        <div class="form-group">
            <label for="guestName">Guest Name</label>
            <input type="text" id="guestName" name="guestName" required>
            <span id="guestNameError" class="error">Guest name is required.</span>
        </div>
        <div class="form-group">
            <label for="roomNumber">Room Number</label>
            <input type="number" id="roomNumber" name="roomNumber" min="1" required>
            <span id="roomNumberError" class="error">Please enter a valid room number (1 or higher).</span>
        </div>
        <div class="form-group">
            <label for="checkIn">Check-In Date</label>
            <input type="date" id="checkIn" name="checkIn" required>
            <span id="checkInError" class="error">Please select a valid check-in date.</span>
        </div>
        <div class="form-group">
            <label for="checkOut">Check-Out Date</label>
            <input type="date" id="checkOut" name="checkOut" required>
            <span id="checkOutError" class="error">Check-out must be after check-in.</span>
        </div>
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <button type="submit">Submit Booking</button>
    </form>

    <script>
        document.getElementById('bookingForm').addEventListener('input', function(e) {
            const guestName = document.getElementById('guestName');
            const roomNumber = document.getElementById('roomNumber');
            const checkIn = document.getElementById('checkIn');
            const checkOut = document.getElementById('checkOut');

            // Reset error messages
            document.querySelectorAll('.error').forEach(error => error.style.display = 'none');

            // Validate guest name
            if (guestName.value.trim() === '') {
                document.getElementById('guestNameError').style.display = 'block';
            }

            // Validate room number
            if (roomNumber.value < 1) {
                document.getElementById('roomNumberError').style.display = 'block';
            }

            // Validate check-in date
            const today = new Date().toISOString().split('T')[0];
            if (checkIn.value < today) {
                document.getElementById('checkInError').style.display = 'block';
                document.getElementById('checkInError').textContent = 'Check-in date cannot be in the past.';
            }

            // Validate check-out date
            if (checkIn.value && checkOut.value && checkOut.value <= checkIn.value) {
                document.getElementById('checkOutError').style.display = 'block';
            }
        });

        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            const guestName = document.getElementById('guestName').value.trim();
            const roomNumber = document.getElementById('roomNumber').value;
            const checkIn = document.getElementById('checkIn').value;
            const checkOut = document.getElementById('checkOut').value;
            const today = new Date().toISOString().split('T')[0];

            let hasError = false;

            // Final validation before submission
            if (guestName === '') {
                document.getElementById('guestNameError').style.display = 'block';
                hasError = true;
            }
            if (roomNumber < 1) {
                document.getElementById('roomNumberError').style.display = 'block';
                hasError = true;
            }
            if (checkIn < today) {
                document.getElementById('checkInError').style.display = 'block';
                document.getElementById('checkInError').textContent = 'Check-in date cannot be in the past.';
                hasError = true;
            }
            if (checkIn && checkOut && checkOut <= checkIn) {
                document.getElementById('checkOutError').style.display = 'block';
                hasError = true;
            }

            if (hasError) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>