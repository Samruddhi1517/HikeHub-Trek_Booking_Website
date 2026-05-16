<?php
require_once 'db.php';
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("
        INSERT INTO users (name,email,password)
        VALUES (?,?,?)
    ");

    $stmt->bind_param("sss",$name,$email,$password);

    if($stmt->execute()){

        header("Location: login.php?registered=1");
        exit;

    } else {

        $error = "Email already exists or database error.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Register | HikeHub</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{
font-family:'Poppins',sans-serif;
background:#f5f8fb;
min-height:100vh;
display:flex;
justify-content:center;
align-items:center;
overflow:hidden;
position:relative;
padding:20px;
}

/* BACKGROUND */
.bg-shape{
position:absolute;
border-radius:50%;
filter:blur(90px);
opacity:.35;
z-index:0;
}

.bg1{
width:340px;
height:340px;
background:#0b74de;
top:-120px;
left:-100px;
}

.bg2{
width:320px;
height:320px;
background:#60a5fa;
bottom:-120px;
right:-100px;
}

/* CARD */
.register-card{
position:relative;
z-index:2;
width:460px;
background:#fff;
padding:42px;
border-radius:30px;
box-shadow:0 20px 50px rgba(0,0,0,.08);
border:1px solid #eef2f7;
animation:fadeIn .5s ease;
}

/* LOGO */
.logo-wrap{
display:flex;
justify-content:center;
margin-bottom:20px;
}

.logo{
width:82px;
height:82px;
border-radius:24px;
background:linear-gradient(135deg,#0b74de,#3b82f6);
display:flex;
justify-content:center;
align-items:center;
font-size:38px;
color:#fff;
box-shadow:0 12px 25px rgba(11,116,222,.25);
}

/* TITLE */
.title{
text-align:center;
font-size:34px;
font-weight:800;
color:#111827;
margin-bottom:10px;
}

.subtitle{
text-align:center;
font-size:15px;
color:#6b7280;
margin-bottom:32px;
line-height:1.5;
}

/* INPUT */
.input-group{
margin-bottom:22px;
}

.input-group label{
display:block;
font-size:14px;
font-weight:600;
margin-bottom:8px;
color:#374151;
}

.input-group input{
width:100%;
padding:15px 16px;
border-radius:14px;
border:1px solid #dbe3ea;
font-size:15px;
outline:none;
transition:.3s;
background:#f9fbfd;
}

.input-group input:focus{
border-color:#0b74de;
background:#fff;
box-shadow:0 0 0 4px rgba(11,116,222,.12);
}

/* BUTTON */
.register-btn{
width:100%;
padding:15px;
border:none;
border-radius:14px;
background:#0b74de;
color:#fff;
font-size:16px;
font-weight:700;
cursor:pointer;
transition:.3s;
box-shadow:0 12px 22px rgba(11,116,222,.22);
}

.register-btn:hover{
background:#095bb0;
transform:translateY(-2px);
}

/* ERROR */
.error-box{
background:#fff1f2;
border:1px solid #fecdd3;
padding:14px;
border-radius:14px;
margin-bottom:22px;
font-size:14px;
color:#e11d48;
text-align:center;
}

/* LOGIN LINK */
.login-link{
margin-top:22px;
text-align:center;
font-size:14px;
color:#64748b;
}

.login-link a{
color:#0b74de;
font-weight:700;
text-decoration:none;
}

.login-link a:hover{
text-decoration:underline;
}

/* FOOTER */
.footer{
margin-top:24px;
text-align:center;
font-size:13px;
color:#94a3b8;
}

/* ANIMATION */
@keyframes fadeIn{

from{
opacity:0;
transform:translateY(20px);
}

to{
opacity:1;
transform:translateY(0);
}

}

/* MOBILE */
@media(max-width:500px){

.register-card{
width:100%;
padding:30px 24px;
}

.title{
font-size:28px;
}

.logo{
width:72px;
height:72px;
font-size:34px;
}

}

</style>
</head>

<body>

<div class="bg-shape bg1"></div>
<div class="bg-shape bg2"></div>

<div class="register-card">

<div class="logo-wrap">
<div class="logo">
🏔️
</div>
</div>

<h1 class="title">
Create Account
</h1>



<?php if(isset($error)): ?>

<div class="error-box">
<?= htmlspecialchars($error) ?>
</div>

<?php endif; ?>

<form method="POST">

<div class="input-group">

<label>Full Name</label>

<input
type="text"
name="name"
placeholder="Enter your full name"
required
>

</div>

<div class="input-group">

<label>Email Address</label>

<input
type="email"
name="email"
placeholder="Enter your email"
required
>

</div>

<div class="input-group">

<label>Password</label>

<input
type="password"
name="password"
placeholder="Create strong password"
required
>

</div>

<button type="submit" class="register-btn">
Create Account
</button>

</form>

<div class="login-link">
Already have an account?
<a href="login.php">Login Here</a>
</div>

</div>

</body>
</html>