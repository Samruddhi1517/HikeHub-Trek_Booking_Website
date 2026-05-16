<?php
require_once 'db.php';
session_start();
include 'header.php';

$query = "
SELECT 
b.id,
b.seats AS people,
b.status,
b.txn_id,
b.created_at,
t.title,
t.location
FROM bookings b
JOIN treks t ON b.trek_id = t.id
WHERE b.user_id = ?
ORDER BY b.created_at DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$res = $stmt->get_result();
?>

<style>

.dashboard-title{
font-size:34px;
font-weight:800;
margin:25px 0;
color:#111827;
}

.booking-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
gap:22px;
margin-bottom:30px;
}

.booking-card{
background:#ffffff;
border-radius:22px;
padding:24px;
box-shadow:0 10px 30px rgba(0,0,0,0.08);
transition:.3s;
border:1px solid #eef2f7;
}

.booking-card:hover{
transform:translateY(-5px);
box-shadow:0 18px 35px rgba(0,0,0,0.12);
}

.booking-card h3{
font-size:24px;
margin-bottom:10px;
color:#111827;
}

.location{
color:#6b7280;
font-size:15px;
margin-bottom:18px;
}

.info{
margin:8px 0;
font-size:16px;
color:#374151;
}

.small{
margin-top:12px;
font-size:14px;
color:#6b7280;
}

.badge{
display:inline-block;
padding:8px 14px;
border-radius:50px;
font-size:14px;
font-weight:700;
margin-top:8px;
}

.pending{
background:#fff7cc;
color:#b45309;
}

.paid{
background:#dcfce7;
color:#15803d;
}

.cancelled{
background:#fee2e2;
color:#b91c1c;
}

.btn-group{
margin-top:18px;
}

.btn{
display:block;
text-align:center;
padding:12px;
border-radius:12px;
text-decoration:none;
font-weight:700;
font-size:15px;
transition:.3s;
}

.invoice-btn{
background:#0b74de;
color:#fff;
}

.btn:hover{
opacity:.9;
transform:translateY(-2px);
}

.empty-box{
background:#fff;
padding:40px;
border-radius:18px;
text-align:center;
box-shadow:0 8px 25px rgba(0,0,0,.06);
}

@media(max-width:600px){

.dashboard-title{
font-size:28px;
}

.booking-card{
padding:18px;
}

.booking-card h3{
font-size:20px;
}

}

</style>

<h1 class="dashboard-title">📌 My Bookings</h1>

<?php if($res->num_rows > 0): ?>

<div class="booking-grid">

<?php while($r = $res->fetch_assoc()): 

$status = strtolower(trim($r['status']));
if($status == '') $status = 'paid';

?>

<div class="booking-card">

<h3><?= htmlspecialchars($r['title']) ?></h3>

<div class="location">📍 <?= htmlspecialchars($r['location']) ?></div>

<div class="info">👥 People: <?= intval($r['people']) ?></div>

<div class="info">
Status:
<span class="badge <?= $status ?>">
<?= ucfirst($status) ?>
</span>
</div>

<?php if(!empty($r['txn_id'])): ?>
<div class="info">💳 Txn ID: <?= htmlspecialchars($r['txn_id']) ?></div>
<?php endif; ?>

<div class="small">
🕒 Booked at: <?= $r['created_at'] ?>
</div>

<div class="btn-group">

<a href="invoice.php?booking_id=<?= $r['id'] ?>" class="btn invoice-btn">
📄 Download Invoice
</a>

</div>

</div>

<?php endwhile; ?>

</div>

<?php else: ?>

<div class="empty-box">
<h2>No Bookings Yet</h2>
<p>Book your first trek adventure now.</p>
</div>

<?php endif; ?>

<?php include 'footer.php'; ?>