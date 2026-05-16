<?php
require 'db.php';

$booking_id = intval($_GET['booking_id'] ?? 0);
$payment_id = $_GET['payment_id'] ?? '';

if($booking_id <= 0){
die("Invalid Booking ID");
}

/* FIXED UPDATE QUERY */
$stmt = $conn->prepare("
UPDATE bookings
SET status='paid',
txn_id=?
WHERE id=?
");

$stmt->bind_param("si",$payment_id,$booking_id);
$stmt->execute();
?>

<!DOCTYPE html>
<html>
<head>
<title>Payment Successful</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Segoe UI,sans-serif;
}

body{
background:linear-gradient(135deg,#0b74de,#00b4ff);
min-height:100vh;
display:flex;
justify-content:center;
align-items:center;
padding:20px;
}

.success-box{
width:100%;
max-width:500px;
background:#fff;
padding:35px;
border-radius:22px;
text-align:center;
box-shadow:0 20px 45px rgba(0,0,0,.15);
animation:fade .6s ease;
}

@keyframes fade{
from{opacity:0;transform:translateY(30px);}
to{opacity:1;transform:translateY(0);}
}

.tick{
font-size:75px;
color:#16a34a;
margin-bottom:12px;
}

h1{
font-size:30px;
color:#16a34a;
margin-bottom:10px;
}

p{
font-size:16px;
color:#444;
margin:10px 0;
}

.info{
background:#f5f9ff;
padding:16px;
border-radius:14px;
margin-top:20px;
text-align:left;
}

.info p{
margin:8px 0;
font-size:15px;
}

.btns{
margin-top:25px;
display:grid;
gap:12px;
}

.btn{
display:block;
padding:14px;
border-radius:12px;
text-decoration:none;
font-weight:700;
font-size:16px;
}

.primary{
background:#0b74de;
color:#fff;
}

.secondary{
background:#eef2ff;
color:#111;
}

.btn:hover{
opacity:.92;
}
</style>
</head>

<body>

<div class="success-box">

<div class="tick">✔</div>

<h1>Payment Successful</h1>

<p>Your booking has been confirmed successfully.</p>

<div class="info">
<p><strong>Booking ID:</strong> #<?= $booking_id ?></p>
<p><strong>Payment ID:</strong> <?= htmlspecialchars($payment_id) ?></p>
<p><strong>Status:</strong> Paid</p>
</div>

<div class="btns">

<a href="invoice.php?booking_id=<?= $booking_id ?>" class="btn primary">
Download Invoice
</a>

<a href="dashboard.php" class="btn secondary">
Go to Dashboard
</a>

<a href="list.php" class="btn secondary">
Back to Treks
</a>

</div>

</div>

</body>
</html>