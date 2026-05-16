<?php
require 'db.php';

$trek_id = intval($_GET['trek_id'] ?? 0);

$stmt = $conn->prepare("
SELECT id,title,price
FROM treks
WHERE id=?
");
$stmt->bind_param("i",$trek_id);
$stmt->execute();

$trip = $stmt->get_result()->fetch_assoc();

if(!$trip){
header("Location:list.php");
exit;
}

include 'header.php';
?>

<style>

.booking-page{
max-width:760px;
margin:35px auto;
padding:0 15px;
}

.booking-card{
background:#ffffff;
border-radius:24px;
padding:32px;
box-shadow:0 15px 40px rgba(0,0,0,.08);
border:1px solid #eef2f7;
animation:fade .6s ease;
}

@keyframes fade{
from{opacity:0;transform:translateY(25px);}
to{opacity:1;transform:translateY(0);}
}

.title{
font-size:34px;
font-weight:800;
color:#111827;
margin-bottom:8px;
}

.sub{
color:#6b7280;
font-size:15px;
margin-bottom:28px;
line-height:1.6;
}

.trip-banner{
background:linear-gradient(135deg,#0b74de,#00b4ff);
color:#fff;
padding:20px;
border-radius:18px;
margin-bottom:24px;
}

.trip-banner h3{
font-size:24px;
margin:0 0 8px;
}

.trip-banner p{
margin:0;
opacity:.95;
font-size:15px;
}

.form-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:16px;
}

.form-group{
display:flex;
flex-direction:column;
margin-bottom:16px;
}

.form-group.full{
grid-column:1 / -1;
}

.form-group label{
font-size:14px;
font-weight:700;
margin-bottom:7px;
color:#111827;
}

.form-group input{
padding:13px 14px;
border:1px solid #dbe3ea;
border-radius:12px;
font-size:15px;
outline:none;
transition:.3s;
}

.form-group input:focus{
border-color:#0b74de;
box-shadow:0 0 0 3px rgba(11,116,222,.12);
}

.summary{
background:#f8fafc;
border:1px solid #e5e7eb;
border-radius:18px;
padding:18px;
margin-top:10px;
}

.row{
display:flex;
justify-content:space-between;
margin:10px 0;
font-size:16px;
color:#374151;
}

.total{
border-top:1px solid #e5e7eb;
padding-top:12px;
margin-top:12px;
font-size:20px;
font-weight:800;
color:#0b74de;
}

.secure{
margin-top:14px;
font-size:13px;
color:#6b7280;
text-align:center;
}

.book-btn{
width:100%;
margin-top:22px;
padding:15px;
border:none;
border-radius:14px;
background:#0b74de;
color:#fff;
font-size:18px;
font-weight:800;
cursor:pointer;
transition:.3s;
}

.book-btn:hover{
background:#095bb0;
transform:translateY(-2px);
}

.note{
margin-top:16px;
font-size:13px;
color:#6b7280;
text-align:center;
}

@media(max-width:700px){

.booking-card{
padding:22px;
}

.title{
font-size:28px;
}

.form-grid{
grid-template-columns:1fr;
}

}

</style>

<div class="booking-page">

<div class="booking-card">

<div class="title">🏕️ Book Your Trek</div>

<div class="sub">
Fill your details below and confirm your seat for the adventure.
</div>

<div class="trip-banner">
<h3><?= htmlspecialchars($trip['title']) ?></h3>
<p>Instant confirmation • Safe payment • Trusted booking</p>
</div>

<form method="post" action="book_action.php">

<input type="hidden" name="trek_id" value="<?= $trip['id'] ?>">

<div class="form-grid">

<div class="form-group">
<label>Full Name</label>
<input type="text" name="name" required placeholder="Enter full name">
</div>

<div class="form-group">
<label>Email Address</label>
<input type="email" name="email" required placeholder="example@gmail.com">
</div>

<div class="form-group">
<label>Phone Number</label>
<input type="text" name="phone" required placeholder="9876543210" maxlength="10">
</div>

<div class="form-group">
<label>Travel Date</label>
<input 
type="date"
name="travel_date"
required
min="<?= date('Y-m-d') ?>"
>
</div>

<div class="form-group full">
<label>Number of Seats</label>
<input 
type="number"
name="seats"
id="seats"
min="1"
max="20"
value="1"
required
>
</div>

</div>

<div class="summary">

<div class="row">
<span>Price Per Person</span>
<strong>₹<?= number_format($trip['price'],2) ?></strong>
</div>

<div class="row">
<span>Total Seats</span>
<strong id="seat_count">1</strong>
</div>

<div class="row total">
<span>Total Price</span>
<strong id="total_price">
₹<?= number_format($trip['price'],2) ?>
</strong>
</div>

</div>

<div class="secure">🔒 Secure Booking & Protected Payment</div>

<button type="submit" class="book-btn">
Confirm Booking
</button>

<div class="note">
You will be redirected to payment page after confirmation.
</div>

</form>

</div>

</div>

<script>

let price = <?= $trip['price'] ?>;

document.getElementById("seats").addEventListener("input", function(){

let seats = parseInt(this.value);

if(isNaN(seats) || seats < 1){
seats = 1;
this.value = 1;
}

document.getElementById("seat_count").innerText = seats;

let total = seats * price;

document.getElementById("total_price").innerText =
"₹" + total.toLocaleString();

});

</script>

<?php include 'footer.php'; ?>