<?php
require 'db.php';

$id = intval($_GET['id'] ?? 0);

/* GET TREK DETAILS */
$stmt = $conn->prepare("SELECT * FROM treks WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$trip = $stmt->get_result()->fetch_assoc();

if(!$trip){
    header("Location:list.php");
    exit;
}

/* GET ALL GALLERY IMAGES */
$stmt = $conn->prepare("
SELECT filename 
FROM trek_images 
WHERE trek_id=?
ORDER BY is_cover DESC, id ASC
");
$stmt->bind_param("i",$id);
$stmt->execute();
$imgs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

include 'header.php';
?>

<style>
.trek-wrap{
display:flex;
gap:25px;
flex-wrap:wrap;
margin:25px 0;
}

.left-box,.right-box{
flex:1;
min-width:320px;
}

.main-img{
width:100%;
height:420px;
object-fit:cover;
border-radius:18px;
box-shadow:0 12px 30px rgba(0,0,0,.08);
}

.price{
font-size:34px;
font-weight:800;
color:#0b74de;
margin-bottom:12px;
}

.meta{
margin:10px 0;
font-size:16px;
color:#374151;
}

.desc{
margin:18px 0;
line-height:1.7;
color:#444;
}

.book-btn{
display:inline-block;
padding:14px 24px;
background:#0b74de;
color:#fff;
text-decoration:none;
border-radius:12px;
font-weight:700;
margin-top:12px;
}

.book-btn:hover{
opacity:.92;
}

.gallery-title{
font-size:28px;
font-weight:800;
margin:35px 0 18px;
}

.gallery-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:16px;
}

.gallery-grid img{
width:100%;
height:180px;
object-fit:cover;
border-radius:14px;
cursor:pointer;
transition:.3s;
box-shadow:0 8px 18px rgba(0,0,0,.08);
}

.gallery-grid img:hover{
transform:scale(1.04);
}

/* LIGHTBOX */
#lightbox{
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,.85);
justify-content:center;
align-items:center;
z-index:999;
padding:20px;
}

#lightbox img{
max-width:95%;
max-height:90%;
border-radius:14px;
}

#lightbox span{
position:absolute;
top:20px;
right:30px;
font-size:42px;
color:#fff;
cursor:pointer;
}

@media(max-width:768px){
.main-img{
height:260px;
}
}
</style>

<h1 style="margin-top:18px;">
<?= htmlspecialchars($trip['title']) ?>
</h1>

<div class="trek-wrap">

<div class="left-box">
<img 
id="mainImage"
src="images/<?= htmlspecialchars($imgs[0]['filename'] ?? 'trek_1.jpg') ?>" 
class="main-img">
</div>

<div class="right-box">

<div class="price">
₹<?= number_format($trip['price'],2) ?>
</div>

<div class="meta"><strong>📍 Location:</strong> <?= htmlspecialchars($trip['location']) ?></div>
<div class="meta"><strong>⏳ Duration:</strong> <?= htmlspecialchars($trip['duration']) ?></div>
<div class="meta"><strong>🥾 Difficulty:</strong> <?= htmlspecialchars($trip['difficulty']) ?></div>

<div class="desc">
<?= nl2br(htmlspecialchars($trip['long_desc'])) ?>
</div>

<a class="book-btn" href="book_form.php?trek_id=<?= $trip['id'] ?>">
Book Now
</a>

</div>

</div>

<h2 class="gallery-title">📸 Trek Gallery</h2>

<div class="gallery-grid">

<?php foreach($imgs as $im): ?>
<img 
src="images/<?= htmlspecialchars($im['filename']) ?>"
onclick="changeMain(this.src)">
<?php endforeach; ?>

</div>

<!-- LIGHTBOX -->
<div id="lightbox" onclick="closeBox()">
<span>&times;</span>
<img id="lightboxImg">
</div>

<script>
function changeMain(src){
document.getElementById("mainImage").src = src;
openBox(src);
}

function openBox(src){
document.getElementById("lightbox").style.display="flex";
document.getElementById("lightboxImg").src = src;
}

function closeBox(){
document.getElementById("lightbox").style.display="none";
}
</script>

<?php include 'footer.php'; ?>