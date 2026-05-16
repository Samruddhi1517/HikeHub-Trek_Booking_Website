<?php
session_start();
require 'db.php';

$booking_id = intval($_GET['booking_id'] ?? 0);

$stmt = $conn->prepare("
SELECT b.id,b.amount_paid,b.name,b.email,t.title
FROM bookings b
JOIN treks t ON t.id = b.trek_id
WHERE b.id = ?
");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if(!$data){
    die("Invalid Booking ID");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Secure Payment | Trek Booking</title>
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

.payment-box{
width:100%;
max-width:480px;
background:#fff;
padding:32px;
border-radius:22px;
box-shadow:0 20px 50px rgba(0,0,0,.15);
animation:fade .6s ease;
}

@keyframes fade{
from{opacity:0;transform:translateY(30px);}
to{opacity:1;transform:translateY(0);}
}

.logo{
text-align:center;
font-size:30px;
font-weight:700;
color:#0b74de;
margin-bottom:8px;
}

.sub{
text-align:center;
color:#666;
font-size:15px;
margin-bottom:25px;
}

.trip-card{
background:#f5f9ff;
padding:18px;
border-radius:16px;
border:1px solid #dbeafe;
margin-bottom:20px;
}

.trip-card h3{
font-size:18px;
margin-bottom:10px;
}

.row{
display:flex;
justify-content:space-between;
margin:8px 0;
font-size:15px;
}

.amount{
font-size:30px;
font-weight:700;
color:#0b74de;
text-align:center;
margin:20px 0;
}

.methods{
display:grid;
grid-template-columns:1fr 1fr;
gap:12px;
margin-bottom:10px;
}

.pay-option{
padding:14px;
border:2px solid #e5e7eb;
border-radius:14px;
text-align:center;
cursor:pointer;
font-weight:600;
transition:.3s;
}

.pay-option:hover{
background:#f0f7ff;
border-color:#0b74de;
}

.pay-option.active{
background:#eaf4ff;
border-color:#0b74de;
}

.selected{
text-align:center;
margin-bottom:18px;
font-weight:700;
color:#0b74de;
}

.pay-btn{
width:100%;
padding:15px;
border:none;
border-radius:14px;
background:#0b74de;
color:#fff;
font-size:18px;
font-weight:700;
cursor:pointer;
transition:.3s;
}

.pay-btn:hover{
background:#095bb0;
transform:translateY(-2px);
}

.secure{
text-align:center;
margin-top:14px;
font-size:13px;
color:#777;
}

.loader{
display:none;
text-align:center;
margin-top:20px;
}

.spinner{
width:42px;
height:42px;
border:4px solid #ddd;
border-top:4px solid #0b74de;
border-radius:50%;
margin:auto;
animation:spin 1s linear infinite;
}

@keyframes spin{
100%{transform:rotate(360deg);}
}

.success{
display:none;
text-align:center;
margin-top:20px;
}

.tick{
font-size:65px;
color:#16a34a;
margin-bottom:8px;
}
</style>
</head>

<body>

<div class="payment-box">

<div class="logo">🏔️ HikeHub</div>
<div class="sub">Complete Your Booking Payment</div>

<div class="trip-card">
<h3><?= htmlspecialchars($data['title']) ?></h3>

<div class="row">
<span>Name</span>
<span><?= htmlspecialchars($data['name']) ?></span>
</div>

<div class="row">
<span>Email</span>
<span><?= htmlspecialchars($data['email']) ?></span>
</div>

<div class="row">
<span>Booking ID</span>
<span>#<?= $booking_id ?></span>
</div>
</div>

<div class="amount">
₹<?= number_format($data['amount_paid'],2) ?>
</div>

<div class="methods">
<div class="pay-option active" onclick="selectPay(this)">💳 Card</div>
<div class="pay-option" onclick="selectPay(this)">📱 UPI</div>
<div class="pay-option" onclick="selectPay(this)">🏦 NetBanking</div>
<div class="pay-option" onclick="selectPay(this)">💵 Wallet</div>
</div>

<div class="selected" id="selectedMethod">Selected: 💳 Card</div>

<button class="pay-btn" onclick="payNow()">Pay Securely</button>

<div class="secure">🔒 100% Secure Encrypted Payment</div>

<div class="loader" id="loader">
<div class="spinner"></div>
<p style="margin-top:10px;">Processing Payment...</p>
</div>

<div class="success" id="success">
<div class="tick">✔</div>
<h3 style="color:#16a34a;">Payment Successful</h3>
<p>Redirecting...</p>
</div>

</div>

<script>
let method = "Card";

function selectPay(el){

document.querySelectorAll('.pay-option').forEach(btn=>{
btn.classList.remove('active');
});

el.classList.add('active');

method = el.innerText.trim();

document.getElementById("selectedMethod").innerText =
"Selected: " + method;
}

function payNow(){

document.getElementById("loader").style.display="block";

setTimeout(function(){

document.getElementById("loader").style.display="none";
document.getElementById("success").style.display="block";

setTimeout(function(){

window.location =
"payment_success.php?booking_id=<?=$booking_id?>&payment_id=" +
encodeURIComponent(method + "_" + Math.floor(Math.random()*999999));

},2000);

},2500);

}
</script>

</body>
</html>