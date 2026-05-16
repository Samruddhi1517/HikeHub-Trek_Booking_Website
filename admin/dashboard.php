<?php
require '../db.php';
include 'partials/header.php';

$sql = "
SELECT t.*,
       (SELECT filename 
        FROM trek_images ti 
        WHERE ti.trek_id = t.id AND ti.is_cover = 1 
        LIMIT 1) AS cover
FROM treks t
ORDER BY t.id DESC
";

$res = $conn->query($sql);
?>

<style>

body{
background:#f5f8fb;
font-family:'Poppins',sans-serif;
}

/* GRID */
.card-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
gap:22px;
margin-top:30px;
}

/* CARD */
.trek-card{
background:#fff;
border-radius:20px;
overflow:hidden;
box-shadow:0 10px 30px rgba(0,0,0,.08);
transition:.3s;
}

.trek-card:hover{
transform:translateY(-6px);
}

.img-box img{
width:100%;
height:180px;
object-fit:cover;
}

.card-body{
padding:16px;
}

.card-body h3{
font-size:18px;
font-weight:800;
color:#111827;
margin-bottom:6px;
}

.location{
font-size:13px;
color:#6b7280;
margin-bottom:10px;
}

.meta{
display:flex;
gap:10px;
font-size:12px;
color:#64748b;
margin-bottom:12px;
}

.bottom{
display:flex;
justify-content:space-between;
align-items:center;
}

.price{
font-size:18px;
font-weight:800;
color:#0b74de;
}

.actions a{
font-size:12px;
margin-left:8px;
text-decoration:none;
color:#374151;
font-weight:600;
}

.actions a:hover{
color:#0b74de;
}

</style>

<div class="container">

<h1 style="margin-top:30px;font-size:32px;font-weight:800;">
🏔️ Manage Treks
</h1>

<div class="card-grid">

<?php while($row = $res->fetch_assoc()): 
$img = !empty($row['cover']) ? $row['cover'] : 'trek_1.jpg';
?>

<div class="trek-card">

<div class="img-box">
<img src="../images/<?= htmlspecialchars($img) ?>">
</div>

<div class="card-body">

<h3><?= htmlspecialchars($row['title']) ?></h3>

<p class="location">📍 <?= htmlspecialchars($row['location']) ?></p>

<div class="meta">
<span>⛰ <?= $row['difficulty'] ?></span>
<span>⏱ <?= $row['duration'] ?></span>
</div>

<div class="bottom">

<div class="price">₹<?= number_format($row['price']) ?></div>

<div class="actions">
<a href="edit_trek.php?id=<?= $row['id'] ?>">Edit</a>
<a href="delete_trek.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
</div>

</div>

</div>

</div>

<?php endwhile; ?>

</div>

</div>

</body>
</html>