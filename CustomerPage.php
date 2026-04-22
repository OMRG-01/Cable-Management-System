<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header('Location: 1.customer.php');
    exit;
}
include("connection.php");
$username = htmlspecialchars($_SESSION['user_name']);

// Fetch customer info
$stmt = mysqli_prepare($conn, "SELECT sename, selname, sname FROM form1 WHERE hname = ?");
mysqli_stmt_bind_param($stmt, "s", $_SESSION['user_name']);
mysqli_stmt_execute($stmt);
$res  = mysqli_stmt_get_result($stmt);
$cust = $res ? mysqli_fetch_assoc($res) : null;

$plan  = $cust ? htmlspecialchars($cust['sename'])  : 'N/A';
$area  = $cust ? htmlspecialchars($cust['selname']) : 'N/A';
$stbid = $cust ? htmlspecialchars($cust['sname'])   : 'N/A';

// Pending payments
$pending_count = 0;
$pstmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM form8 f JOIN form1 c ON f.user_id=c.id WHERE c.hname=? AND f.payment_status='Pending'");
if ($pstmt) {
    mysqli_stmt_bind_param($pstmt, "s", $_SESSION['user_name']);
    mysqli_stmt_execute($pstmt);
    mysqli_stmt_bind_result($pstmt, $pending_count);
    mysqli_stmt_fetch($pstmt);
}

// Open complaints
$open_complaints = 0;
$cstmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM complaints WHERE username=? AND status='Open'");
if ($cstmt) {
    mysqli_stmt_bind_param($cstmt, "s", $_SESSION['user_name']);
    mysqli_stmt_execute($cstmt);
    mysqli_stmt_bind_result($cstmt, $open_complaints);
    mysqli_stmt_fetch($cstmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - DIGI NETWORK</title>
    <link rel="stylesheet" type="text/css" href="css/style7.css?v=3">
    <style>
        .welcome-banner {
            background: linear-gradient(135deg, rgba(139,92,246,0.28) 0%, rgba(45,27,105,0.40) 100%);
            border: 1px solid rgba(139,92,246,0.30);
            border-radius: 16px;
            padding: 22px 28px;
            margin-bottom: 26px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
            backdrop-filter: blur(12px);
        }
        .welcome-banner .welcome-text h2 {
            font-size: 1.4rem;
            color: white;
            font-weight: 700;
            margin-bottom: 4px;
            text-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }
        .welcome-banner .welcome-text p {
            color: rgba(255,255,255,0.60);
            font-size: 13px;
            margin: 0;
        }
        .welcome-banner .info-pills {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .pill {
            background: rgba(139,92,246,0.22);
            border: 1px solid rgba(139,92,246,0.40);
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 11.5px;
            color: #c4b5fd;
            font-weight: 600;
            letter-spacing: 0.3px;
            white-space: nowrap;
        }
        .pill span { color: white; }

        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 14px;
            margin-bottom: 26px;
        }
        .stat-chip {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(139,92,246,0.22);
            border-radius: 12px;
            padding: 16px 14px;
            text-align: center;
            backdrop-filter: blur(10px);
            transition: transform 0.25s, box-shadow 0.25s;
        }
        .stat-chip:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 22px rgba(139,92,246,0.25);
        }
        .stat-chip .stat-val {
            font-size: 1.6rem;
            font-weight: 700;
            color: #a78bfa;
            line-height: 1;
            margin-bottom: 5px;
        }
        .stat-chip .stat-lbl {
            font-size: 10px;
            color: rgba(255,255,255,0.55);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }
        .stat-chip.warn .stat-val   { color: #fbbf24; }
        .stat-chip.danger .stat-val { color: #f87171; }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
            gap: 20px;
        }
        .card {
            background: rgba(255,255,255,0.93);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.18), inset 0 1px 0 rgba(255,255,255,0.5);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(255,255,255,0.35);
        }
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 18px 44px rgba(139,92,246,0.30), inset 0 1px 0 rgba(255,255,255,0.5);
        }
        .card-icon {
            width: 100%;
            padding: 26px 20px 16px;
            text-align: center;
        }
        .card-icon .icon-circle {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto;
        }
        .card-icon .icon-circle.purple { background: linear-gradient(135deg, #7c3aed, #a78bfa); box-shadow: 0 6px 20px rgba(124,58,237,0.40); }
        .card-icon .icon-circle.blue   { background: linear-gradient(135deg, #2563eb, #60a5fa); box-shadow: 0 6px 20px rgba(37,99,235,0.40); }
        .card-icon .icon-circle.green  { background: linear-gradient(135deg, #059669, #34d399); box-shadow: 0 6px 20px rgba(5,150,105,0.40); }
        .card-icon .icon-circle.pink   { background: linear-gradient(135deg, #db2777, #f472b6); box-shadow: 0 6px 20px rgba(219,39,119,0.40); }

        .card .box {
            padding: 0 20px 24px;
            text-align: center;
        }
        .box h2 {
            font-size: 15px;
            font-weight: 700;
            color: #1e1b4b;
            margin-bottom: 6px;
        }
        .box .card-desc {
            font-size: 11.5px;
            color: #6b7280;
            margin-bottom: 16px;
            line-height: 1.4;
        }
        .box h3 a {
            color: #7c3aed;
            text-decoration: none;
            font-weight: 700;
            font-size: 12.5px;
            padding: 7px 22px;
            border-radius: 20px;
            border: 2px solid rgba(139,92,246,0.50);
            transition: all 0.25s ease;
            display: inline-block;
        }
        .box h3 a:hover {
            background: #7c3aed;
            color: white;
            border-color: #7c3aed;
            box-shadow: 0 4px 14px rgba(124,58,237,0.40);
        }
    </style>
</head>
<body>
    <div class="header">
        <nav class="navbar">
            <a href="logout.php">Logout</a>
        </nav>
    </div>

    <div class="sidebar">
        <div class="logo">
            <img src="user.png" alt="User" width="40">
            <h4><?php echo $username; ?></h4>
            <p>Customer</p>
        </div>
        <ul class="menu">
            <li><a href="CustomerPage.php" class="active">&#9632; Dashboard</a></li>
            <li><a href="customerdetails.php">&#128100; My Details</a></li>
            <li><a href="upcustomer.php">&#9998; Update Details</a></li>
            <li><a href="editplanC.php">&#128250; Subscription</a></li>
            <li><a href="pay.php">&#128179; Payment</a></li>
            <li><a href="complaints.php">&#128172; Raise Complaint</a></li>
            <li><a href="viewcomplaints.php">&#128203; My Complaints</a></li>
        </ul>
    </div>

    <div class="container">
        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <div class="welcome-text">
                <h2>Welcome back, <?php echo $username; ?>!</h2>
                <p>Manage your cable TV subscription and account details below.</p>
            </div>
            <div class="info-pills">
                <div class="pill">Plan: <span><?php echo $plan; ?></span></div>
                <div class="pill">Area: <span><?php echo $area; ?></span></div>
                <div class="pill">STB: <span><?php echo $stbid; ?></span></div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="quick-stats">
            <div class="stat-chip <?php echo $pending_count > 0 ? 'warn' : ''; ?>">
                <div class="stat-val"><?php echo $pending_count; ?></div>
                <div class="stat-lbl">Pending Payments</div>
            </div>
            <div class="stat-chip <?php echo $open_complaints > 0 ? 'danger' : ''; ?>">
                <div class="stat-val"><?php echo $open_complaints; ?></div>
                <div class="stat-lbl">Open Complaints</div>
            </div>
            <div class="stat-chip">
                <div class="stat-val">&#9679;</div>
                <div class="stat-lbl">Active Connection</div>
            </div>
        </div>

        <!-- Dashboard Cards -->
        <div class="cards">
            <div class="card">
                <div class="card-icon">
                    <div class="icon-circle purple">&#128100;</div>
                </div>
                <div class="box">
                    <h2>My Details</h2>
                    <p class="card-desc">View your profile, contact info &amp; subscription</p>
                    <h3><a href="customerdetails.php">View Profile</a></h3>
                </div>
            </div>
            <div class="card">
                <div class="card-icon">
                    <div class="icon-circle blue">&#128250;</div>
                </div>
                <div class="box">
                    <h2>Subscription</h2>
                    <p class="card-desc">Browse available channel packs &amp; plans</p>
                    <h3><a href="editplanC.php">View Plans</a></h3>
                </div>
            </div>
            <div class="card">
                <div class="card-icon">
                    <div class="icon-circle green">&#128179;</div>
                </div>
                <div class="box">
                    <h2>Payment</h2>
                    <p class="card-desc">Pay your monthly subscription bill online</p>
                    <h3><a href="pay.php">Pay Now</a></h3>
                </div>
            </div>
            <div class="card">
                <div class="card-icon">
                    <div class="icon-circle pink">&#128172;</div>
                </div>
                <div class="box">
                    <h2>Complaints</h2>
                    <p class="card-desc">Report issues or track existing complaints</p>
                    <h3><a href="complaints.php">Raise Complaint</a></h3>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
