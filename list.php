<?php
require 'db.php';

$search   = $_GET['q'] ?? '';
$location = $_GET['location'] ?? '';
$sort     = $_GET['sort'] ?? 'newest';

$where = ['1=1'];
$params = [];
$types = '';

if($search != ''){
    $where[] = "(title LIKE ? OR short_desc LIKE ?)";
    $params[] = "%".$search."%";
    $params[] = "%".$search."%";
    $types .= "ss";
}

if($location != ''){
    $where[] = "location = ?";
    $params[] = $location;
    $types .= "s";
}

$where_sql = implode(" AND ", $where);

$order_by = "t.created_at DESC";

if($sort == 'price_asc')  $order_by = "t.price ASC";
if($sort == 'price_desc') $order_by = "t.price DESC";
if($sort == 'popular')    $order_by = "t.is_featured DESC, t.created_at DESC";

$sql = "
SELECT
t.id,
t.title,
t.short_desc,
t.price,
t.location,
t.duration,
(
SELECT filename
FROM trek_images
WHERE trek_id=t.id
AND is_cover=1
LIMIT 1
) AS cover
FROM treks t
WHERE $where_sql
ORDER BY $order_by
";

$stmt = $conn->prepare($sql);

if($types){
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$res = $stmt->get_result();
$items = $res->fetch_all(MYSQLI_ASSOC);

include 'header.php';
?>

<style>

.page-title{
font-size:36px;
font-weight:800;
margin:28px 0 18px;
color:#111827;
}

.sub-text{
color:#6b7280;
margin-bottom:22px;
font-size:16px;
}

.controls{
background:#ffffff;
padding:18px;
border-radius:18px;
box-shadow:0 10px 25px rgba(0,0,0,.06);
display:grid;
grid-template-columns:2fr 1fr 1fr auto;
gap:14px;
margin-bottom:28px;
}

.controls input,
.controls select{
padding:13px 14px;
border:1px solid #dbe3ea;
border-radius:12px;
font-size:15px;
outline:none;
}

.controls input:focus,
.controls select:focus{
border-color:#0b74de;
box-shadow:0 0 0 3px rgba(11,116,222,.12);
}

.apply-btn{
background:#0b74de;
color:#fff;
border:none;
padding:13px 20px;
border-radius:12px;
font-weight:700;
cursor:pointer;
transition:.3s;
}

.apply-btn:hover{
background:#095bb0;
}

.trek-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
gap:22px;
margin-bottom:30px;
}

.trek-card{
background:#fff;
border-radius:22px;
overflow:hidden;
box-shadow:0 10px 30px rgba(0,0,0,.08);
transition:.3s;
border:1px solid #eef2f7;
}

.trek-card:hover{
transform:translateY(-6px);
box-shadow:0 18px 35px rgba(0,0,0,.12);
}

.trek-card img{
width:100%;
height:220px;
object-fit:cover;
}

.card-body{
padding:18px;
}

.trek-title{
font-size:22px;
font-weight:800;
margin-bottom:8px;
color:#111827;
}

.meta{
font-size:14px;
color:#6b7280;
margin-bottom:10px;
}

.desc{
font-size:15px;
color:#374151;
line-height:1.5;
min-height:48px;
}

.bottom{
display:flex;
justify-content:space-between;
align-items:center;
margin-top:18px;
}

.price{
font-size:24px;
font-weight:800;
color:#0b74de;
}

.view-btn{
background:#0b74de;
color:#fff;
text-decoration:none;
padding:10px 16px;
border-radius:12px;
font-weight:700;
transition:.3s;
}

.view-btn:hover{
background:#095bb0;
}

.empty-box{
background:#fff;
padding:50px;
border-radius:20px;
text-align:center;
box-shadow:0 8px 25px rgba(0,0,0,.06);
}

@media(max-width:900px){

.controls{
grid-template-columns:1fr 1fr;
}

}

@media(max-width:600px){

.page-title{
font-size:28px;
}

.controls{
grid-template-columns:1fr;
}

.trek-card img{
height:200px;
}

}

</style>

<h1 class="page-title">🏔️ Upcoming Treks</h1>
<p class="sub-text">Choose your next adventure and book instantly.</p>

<form method="get" class="controls">

<input 
type="text"
name="q"
placeholder="🔍 Search treks..."
value="<?= htmlspecialchars($search) ?>"
>

<select name="location">
<option value="">📍 All Locations</option>
<option value="Pune" <?=($location=='Pune')?'selected':''?>>Pune</option>
<option value="Lonavala" <?=($location=='Lonavala')?'selected':''?>>Lonavala</option>
<option value="Malshej" <?=($location=='Malshej')?'selected':''?>>Malshej</option>
</select>

<select name="sort">
<option value="newest" <?=($sort=='newest')?'selected':''?>>Newest</option>
<option value="popular" <?=($sort=='popular')?'selected':''?>>Popular</option>
<option value="price_asc" <?=($sort=='price_asc')?'selected':''?>>Price ↑</option>
<option value="price_desc" <?=($sort=='price_desc')?'selected':''?>>Price ↓</option>
</select>

<button class="apply-btn">Apply</button>

</form>

<?php if(count($items) > 0): ?>

<div class="trek-grid">

<?php foreach($items as $it): ?>

<div class="trek-card">

<img src="images/<?= htmlspecialchars($it['cover'] ?: 'trek_1.jpg') ?>">

<div class="card-body">

<div class="trek-title">
<?= htmlspecialchars($it['title']) ?>
</div>

<div class="meta">
📍 <?= htmlspecialchars($it['location']) ?>
&nbsp; • &nbsp;
⏱ <?= htmlspecialchars($it['duration']) ?>
</div>

<div class="desc">
<?= htmlspecialchars($it['short_desc']) ?>
</div>

<div class="bottom">

<div class="price">
₹<?= number_format($it['price'],2) ?>
</div>

<a href="trek.php?id=<?= $it['id'] ?>" class="view-btn">
View Trek
</a>

</div>

</div>
</div>

<?php endforeach; ?>

</div>

<?php else: ?>

<div class="empty-box">
<h2>No Treks Found</h2>
<p>Try another search or location.</p>
</div>

<?php endif; ?>

<?php include 'footer.php'; ?>