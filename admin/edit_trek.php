<?php
require '../db.php';
include 'partials/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

/* ================= UPDATE TREK DETAILS ================= */
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_trek'])){

    $title = $_POST['title'];
    $location = $_POST['location'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("
        UPDATE treks 
        SET title=?, location=?, price=? 
        WHERE id=?
    ");

    $stmt->bind_param("ssdi", $title, $location, $price, $id);
    $stmt->execute();
}

/* ================= UPLOAD IMAGES ================= */
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_images'])){

    if(!empty($_FILES['new_images']['name'][0])){

        foreach($_FILES['new_images']['name'] as $key => $name){

            $ext = pathinfo($name, PATHINFO_EXTENSION);
            $filename = time().'_'.rand(1000,9999).'.'.$ext;

            move_uploaded_file(
                $_FILES['new_images']['tmp_name'][$key],
                "../images/".$filename
            );

            $check = $conn->query("
                SELECT COUNT(*) as c 
                FROM trek_images 
                WHERE trek_id=$id AND is_cover=1
            ");

            $row = $check->fetch_assoc();
            $is_cover = ($row['c'] == 0 && $key == 0) ? 1 : 0;

            $stmt = $conn->prepare("
                INSERT INTO trek_images (trek_id, filename, is_cover)
                VALUES (?,?,?)
            ");

            $stmt->bind_param("isi", $id, $filename, $is_cover);
            $stmt->execute();
        }
    }
}

/* ================= FETCH TREK ================= */
$trek = $conn->query("SELECT * FROM treks WHERE id=$id")->fetch_assoc();

/* ================= FETCH IMAGES (SAFE FIX) ================= */
$images = $conn->query("
SELECT * FROM trek_images 
WHERE trek_id=$id 
ORDER BY is_cover DESC, id ASC
");

if(!$images){
    die("DB Error: " . $conn->error);
}
?>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<style>

body{
background:#f5f8fb;
font-family:'Poppins',sans-serif;
}

.container{
max-width:1000px;
margin:auto;
padding:20px;
}

/* ================= FORM ================= */
.form-box{
background:#fff;
padding:25px;
border-radius:18px;
box-shadow:0 10px 25px rgba(0,0,0,.06);
margin-bottom:20px;
}

.form-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:15px;
}

input{
width:100%;
padding:12px;
border-radius:10px;
border:1px solid #ddd;
outline:none;
}

/* BUTTON */
button{
background:#0b74de;
color:#fff;
border:none;
padding:12px 18px;
border-radius:10px;
font-weight:700;
cursor:pointer;
margin-top:12px;
}

/* ================= UPLOAD BOX ================= */
.upload-card{
background:#fff;
padding:25px;
border-radius:18px;
box-shadow:0 10px 25px rgba(0,0,0,.06);
margin-bottom:20px;
text-align:center;
}

.drop-zone{
border:2px dashed #0b74de;
padding:40px;
border-radius:16px;
cursor:pointer;
background:#f8fbff;
font-weight:600;
color:#475569;
transition:.3s;
}

.drop-zone:hover{
background:#eaf4ff;
}

/* ================= GALLERY ================= */
.gallery{
display:flex;
flex-wrap:wrap;
gap:12px;
margin-top:20px;
}

.img-item{
width:130px;
text-align:center;
background:#fff;
padding:10px;
border-radius:14px;
box-shadow:0 8px 20px rgba(0,0,0,.06);
}

.img-item img{
width:100%;
height:90px;
object-fit:cover;
border-radius:10px;
cursor:grab;
border:2px solid #e5e7eb;
}

.btn{
width:100%;
margin-top:6px;
padding:5px;
font-size:11px;
border:none;
border-radius:6px;
cursor:pointer;
font-weight:600;
}

.cover-btn{
background:#0b74de;
color:#fff;
}

.delete-btn{
background:#fee2e2;
color:#dc2626;
}

.cover-tag{
font-size:10px;
background:#22c55e;
color:#fff;
padding:2px 6px;
border-radius:6px;
margin-top:5px;
display:inline-block;
}

</style>

<div class="container">

<h2>✏️ Edit Trek</h2>

<!-- ================= EDIT FORM ================= -->
<div class="form-box">

<form method="post">

<div class="form-grid">

<div>
<label>Title</label>
<input type="text" name="title" value="<?= htmlspecialchars($trek['title']) ?>" required>
</div>

<div>
<label>Location</label>
<input type="text" name="location" value="<?= htmlspecialchars($trek['location']) ?>" required>
</div>

<div>
<label>Price</label>
<input type="number" name="price" value="<?= htmlspecialchars($trek['price']) ?>" required>
</div>

</div>

<button type="submit" name="update_trek">
Update Trek
</button>



</form>

</div>

<!-- ================= UPLOAD BOX ================= -->
<div class="upload-card">

<h3>➕ Add More Images</h3>
<p>Drag & drop images or click to upload</p>

<form method="post" enctype="multipart/form-data">

<div id="dropZone" class="drop-zone">
📁 Drop images here or click to browse
<input type="file" name="new_images[]" id="fileInput" multiple accept="image/*" hidden>
</div>

<button type="submit" name="upload_images">
Upload Images
</button>

</form>

</div>



<!-- ================= GALLERY ================= -->
<h3>🖼️ Gallery Manager</h3>

<div id="gallery" class="gallery">

<?php while($img = $images->fetch_assoc()): ?>

<div class="img-item" data-id="<?= $img['id'] ?>">

<img src="../images/<?= htmlspecialchars($img['filename']) ?>">

<?php if($img['is_cover'] == 1): ?>
<div class="cover-tag">Cover</div>
<?php endif; ?>

<button class="btn cover-btn" onclick="setCover(<?= $img['id'] ?>)">
Set Cover
</button>

<button class="btn delete-btn" onclick="deleteImg(<?= $img['id'] ?>)">
Delete
</button>

</div>


<?php endwhile; ?>

</div>

</div>

<script>

/* DRAG & DROP UPLOAD */
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('fileInput');

dropZone.addEventListener('click', () => fileInput.click());

dropZone.addEventListener('dragover', (e) => {
e.preventDefault();
dropZone.style.background = "#dbeafe";
});

dropZone.addEventListener('dragleave', () => {
dropZone.style.background = "#f8fbff";
});

dropZone.addEventListener('drop', (e) => {
e.preventDefault();
fileInput.files = e.dataTransfer.files;
dropZone.style.background = "#f8fbff";
});

/* DRAG REORDER GALLERY */
new Sortable(document.getElementById("gallery"), {
    animation: 150,
    onEnd: function () {

        let order = [];

        document.querySelectorAll(".img-item").forEach((el, i) => {
            order.push({
                id: el.dataset.id,
                position: i
            });
        });

        fetch("update_order.php", {
            method: "POST",
            headers: {"Content-Type":"application/json"},
            body: JSON.stringify(order)
        });

    }
});

/* SET COVER */
function setCover(id){
    fetch("set_cover.php", {
        method: "POST",
        headers: {"Content-Type":"application/x-www-form-urlencoded"},
        body: "id="+id
    }).then(()=>location.reload());
}

/* DELETE IMAGE */
function deleteImg(id){
    if(confirm("Delete image?")){
        fetch("delete_image.php?id="+id)
        .then(()=>location.reload());
    }
}

</script>

</body>
</html>