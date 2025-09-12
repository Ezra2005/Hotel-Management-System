<?php
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

$database = new Database();
$db = $database->getConnection();
$auth = new Auth($db);

if (isset($_GET['logout']) && $_GET['logout'] == true) {
    $auth->logout();
}

if (!$auth->isLoggedIn()) {
    header("Location: login.php");
    exit;
}

include_once 'includes/header.php';

// Dashboard statistics
$stats = getDashboardStatistics($db);
?>

<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Bookings</h5>
                <p class="card-text display-4"><?php echo $stats['total_bookings']; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Active Guests</h5>
                <p class="card-text display-4"><?php echo $stats['active_guests']; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Revenue</h5>
                <p class="card-text display-4">$<?php echo number_format($stats['revenue'], 2); ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Low Inventory</h5>
                <p class="card-text display-4"><?php echo $stats['low_inventory']; ?></p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Recent Bookings</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Guest Name</th>
                            <th>Check-in</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $recentBookings = getRecentBookings($db);
                        foreach ($recentBookings as $booking) {
                            echo "<tr>
                                <td>{$booking['id']}</td>
                                <td>{$booking['guest_name']}</td>
                                <td>{$booking['check_in']}</td>
                                <td><span class='badge bg-{$booking['status_color']}'>{$booking['status']}</span></td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Upcoming Check-outs</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Room</th>
                            <th>Guest Name</th>
                            <th>Check-out</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $upcomingCheckouts = getUpcomingCheckouts($db);
                        foreach ($upcomingCheckouts as $checkout) {
                            echo "<tr>
                                <td>{$checkout['room_number']}</td>
                                <td>{$checkout['guest_name']}</td>
                                <td>{$checkout['check_out']}</td>
                                <td><a href='modules/booking/checkout.php?id={$checkout['id']}' class='btn btn-sm btn-primary'>Process</a></td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>