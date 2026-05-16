<?php
session_start();
require '../db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("
        SELECT id,name,password 
        FROM users 
        WHERE email=? AND role='admin'
    ");

    $stmt->bind_param("s",$email);
    $stmt->execute();

    $admin = $stmt->get_result()->fetch_assoc();

    if($admin && password_verify($password,$admin['password'])) {

        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['name'];

        header("Location: dashboard.php");
        exit;
    }

    $error = "Invalid admin credentials!";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Login | HikeHub</title>

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
height:100vh;
display:flex;
justify-content:center;
align-items:center;
overflow:hidden;
position:relative;
}

/* Background Gradient */
.bg-shape{
position:absolute;
border-radius:50%;
filter:blur(80px);
opacity:.4;
z-index:0;
}

.bg1{
width:320px;
height:320px;
background:#0b74de;
top:-100px;
left:-80px;
}

.bg2{
width:300px;
height:300px;
background:#60a5fa;
bottom:-120px;
right:-80px;
}

/* Login Card */
.login-card{
position:relative;
z-index:2;
width:430px;
background:#ffffff;
padding:40px;
border-radius:28px;
box-shadow:0 20px 50px rgba(0,0,0,.08);
border:1px solid #eef2f7;
animation:fadeIn .6s ease;
}

/* Logo */
.logo-wrap{
display:flex;
justify-content:center;
margin-bottom:18px;
}

.logo{
width:78px;
height:78px;
border-radius:22px;
background:linear-gradient(135deg,#0b74de,#3b82f6);
display:flex;
justify-content:center;
align-items:center;
font-size:38px;
color:#fff;
box-shadow:0 12px 25px rgba(11,116,222,.25);
}

/* Title */
.title{
text-align:center;
font-size:34px;
font-weight:800;
color:#111827;
margin-bottom:8px;
}

.subtitle{
text-align:center;
font-size:15px;
color:#6b7280;
margin-bottom:32px;
line-height:1.5;
}

/* Input Group */
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

/* Login Button */
.login-btn{
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

.login-btn:hover{
background:#095bb0;
transform:translateY(-2px);
}

/* Error */
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

/* Footer */
.footer{
margin-top:24px;
text-align:center;
font-size:13px;
color:#94a3b8;
}

/* Animation */
@keyframes fadeIn{
from{
opacity:0;
transform:translateY(18px);
}
to{
opacity:1;
transform:translateY(0);
}
}

/* Mobile */
@media(max-width:500px){

.login-card{
width:92%;
padding:30px 24px;
}

.title{
font-size:28px;
}

.logo{
width:70px;
height:70px;
font-size:34px;
}

}

</style>
</head>

<body>

<div class="bg-shape bg1"></div>
<div class="bg-shape bg2"></div>

<div class="login-card">

<div class="logo-wrap">
<div class="logo">
🏔️
</div>
</div>

<h1 class="title">
Admin Login
</h1>



<?php if(isset($error)): ?>

<div class="error-box">
<?= htmlspecialchars($error) ?>
</div>

<?php endif; ?>

<form method="post">

<div class="input-group">

<label>Email Address</label>

<input
type="email"
name="email"
placeholder="Enter admin email"
required
>

</div>

<div class="input-group">

<label>Password</label>

<input
type="password"
name="password"
placeholder="Enter password"
required
>

</div>

<button type="submit" class="login-btn">
Login to Dashboard
</button>

</form>

<div class="footer">
HikeHub Admin System © 2026
</div>

</div>

</body>
</html>