<?php
require '../db.php';
include 'partials/header.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $title = trim($_POST['title']);
    $location = trim($_POST['location']);
    $duration = trim($_POST['duration']);
    $difficulty = trim($_POST['difficulty']);
    $price = $_POST['price'];
    $short_desc = trim($_POST['short_desc']);
    $long_desc = trim($_POST['long_desc']);

    $stmt = $conn->prepare("
        INSERT INTO treks
        (title,location,duration,difficulty,price,short_desc,long_desc)
        VALUES (?,?,?,?,?,?,?)
    ");

    $stmt->bind_param("ssssdss",
        $title,$location,$duration,$difficulty,$price,$short_desc,$long_desc
    );

    $stmt->execute();
    $trek_id = $conn->insert_id;

    if(!empty($_FILES['images']['name'][0])){

        foreach($_FILES['images']['name'] as $key => $name){

            $ext = pathinfo($name, PATHINFO_EXTENSION);
            $filename = time().'_'.rand(1000,9999).'.'.$ext;

            move_uploaded_file($_FILES['images']['tmp_name'][$key], "../images/".$filename);

            $is_cover = ($key == 0) ? 1 : 0;

            $imgStmt = $conn->prepare("
                INSERT INTO trek_images (trek_id, filename, is_cover)
                VALUES (?,?,?)
            ");

            $imgStmt->bind_param("isi", $trek_id, $filename, $is_cover);
            $imgStmt->execute();
        }
    }

    header("Location: dashboard.php");
    exit;
}
?>

<style>

/* BACKGROUND */
body{
margin:0;
font-family:'Poppins',sans-serif;
background:linear-gradient(135deg,#eef5ff,#f8fafc);
}

/* HEADER TEXT */
.page-header{
text-align:center;
margin:30px 0;
}

.page-title{
font-size:40px;
font-weight:900;
color:#0f172a;
}

.page-sub{
color:#64748b;
margin-top:6px;
}

/* CARD */
.form-card{
max-width:950px;
margin:0 auto 50px;
background:#fff;
padding:40px;
border-radius:28px;
box-shadow:0 20px 60px rgba(0,0,0,.08);
border:1px solid #eef2f7;
}

/* GRID */
.form-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:22px;
}

/* INPUT */
.input-group label{
font-weight:700;
font-size:14px;
color:#334155;
display:block;
margin-bottom:8px;
}

input,select,textarea{
width:100%;
padding:14px;
border-radius:14px;
border:1px solid #e2e8f0;
background:#f8fafc;
outline:none;
transition:.3s;
font-family:'Poppins';
}

textarea{
min-height:120px;
resize:vertical;
}

input:focus,select:focus,textarea:focus{
border-color:#3b82f6;
background:#fff;
box-shadow:0 0 0 4px rgba(59,130,246,.12);
}

/* FULL WIDTH */
.full{
grid-column:1 / -1;
}

/* DROP ZONE (PREMIUM LOOK) */
.drop-zone{
border:2px dashed #3b82f6;
padding:50px;
border-radius:22px;
text-align:center;
background:linear-gradient(135deg,#eff6ff,#f8fafc);
cursor:pointer;
transition:.3s;
position:relative;
overflow:hidden;
}

.drop-zone:hover{
transform:scale(1.01);
box-shadow:0 10px 30px rgba(59,130,246,.15);
}

.drop-zone p{
font-weight:600;
color:#475569;
}

/* PREVIEW */
.preview-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(110px,1fr));
gap:10px;
margin-top:15px;
}

.preview-grid img{
width:100%;
height:90px;
object-fit:cover;
border-radius:14px;
border:2px solid #e2e8f0;
}

/* BUTTON */
.submit-btn{
background:linear-gradient(135deg,#3b82f6,#1d4ed8);
color:#fff;
border:none;
padding:16px;
width:100%;
border-radius:16px;
font-size:16px;
font-weight:800;
cursor:pointer;
margin-top:25px;
transition:.3s;
box-shadow:0 10px 25px rgba(59,130,246,.25);
}

.submit-btn:hover{
transform:translateY(-2px);
box-shadow:0 15px 35px rgba(59,130,246,.35);
}

/* MOBILE */
@media(max-width:768px){
.form-grid{
grid-template-columns:1fr;
}
.page-title{
font-size:30px;
}
.form-card{
padding:25px;
}
}

</style>

<div class="page-header">
    <div class="page-title">🏔️ Create New Trek</div>
</div>

<div class="form-card">

<form method="post" enctype="multipart/form-data">

<div class="form-grid">

<div class="input-group">
<label>Trek Title</label>
<input type="text" name="title" required>
</div>

<div class="input-group">
<label>Location</label>
<input type="text" name="location" required>
</div>

<div class="input-group">
<label>Duration</label>
<input type="text" name="duration" required>
</div>

<div class="input-group">
<label>Difficulty</label>
<select name="difficulty" required>
<option>Easy</option>
<option>Moderate</option>
<option>Hard</option>
</select>
</div>

<div class="input-group">
<label>Price</label>
<input type="number" name="price" required>
</div>

<!-- DRAG DROP -->
<div class="input-group full">

<label>Trek Gallery</label>

<div class="drop-zone" id="dropZone">
<input type="file" name="images[]" id="fileInput" multiple accept="image/*" hidden>
<p>📁 Drag & Drop images or click to upload</p>
</div>

<div class="preview-grid" id="previewGrid"></div>

</div>

<div class="input-group full">
<label>Short Description</label>
<textarea name="short_desc" required></textarea>
</div>

<div class="input-group full">
<label>Long Description</label>
<textarea name="long_desc" required></textarea>
</div>

</div>

<button class="submit-btn">+ Publish Trek</button>

</form>

</div>

<script>

const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('fileInput');
const previewGrid = document.getElementById('previewGrid');

dropZone.addEventListener('click',()=>fileInput.click());

dropZone.addEventListener('dragover',(e)=>{
e.preventDefault();
dropZone.style.borderColor="#1d4ed8";
});

dropZone.addEventListener('dragleave',()=>{
dropZone.style.borderColor="#3b82f6";
});

dropZone.addEventListener('drop',(e)=>{
e.preventDefault();
fileInput.files = e.dataTransfer.files;
showPreview();
});

fileInput.addEventListener('change',showPreview);

function showPreview(){
previewGrid.innerHTML="";
Array.from(fileInput.files).forEach(file=>{
const reader=new FileReader();
reader.onload=e=>{
const img=document.createElement("img");
img.src=e.target.result;
previewGrid.appendChild(img);
};
reader.readAsDataURL(file);
});
}

</script>

</body>
</html>