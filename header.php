<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Trip Booking</title>

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
}

/* BLUE HEADER */
.site-header{
background:linear-gradient(135deg, #0b74de, #1d4ed8);
padding:18px 0;
box-shadow:0 6px 20px rgba(0,0,0,.15);
}

/* CONTAINER */
.container{
max-width:1200px;
margin:auto;
padding:0 20px;
}

.nav-flex{
display:flex;
justify-content:space-between;
align-items:center;
}

/* LOGO */
.logo{
font-size:26px;
font-weight:800;
color:#fff;
text-decoration:none;
}

/* NAV */
.nav{
display:flex;
align-items:center;
gap:14px;
}

.nav a{
padding:10px 16px;
border-radius:10px;
text-decoration:none;
font-size:14px;
font-weight:600;
color:#fff;
transition:.3s;
background:rgba(255,255,255,0.12);
}

.nav a:hover{
background:rgba(255,255,255,0.25);
}

/* USER TEXT */
.nav span{
color:#fff;
font-size:14px;
font-weight:600;
margin-right:10px;
}

/* SPECIAL BUTTONS */
.admin-link{
background:rgba(255,255,255,0.2);
}

.logout{
background:rgba(255,0,0,0.25);
}

.logout:hover{
background:rgba(255,0,0,0.4);
}

/* RESPONSIVE */
@media(max-width:768px){
.nav-flex{
flex-direction:column;
align-items:flex-start;
gap:12px;
}
.nav{
flex-wrap:wrap;
}
}

</style>

</head>

<body>

<header class="site-header">

<div class="container">

<div class="nav-flex">

<!-- LOGO -->
<a href="list.php" class="logo">🏔️ HikeHub</a>

<!-- NAV -->
<nav class="nav">

<?php if(isset($_SESSION['user_id'])): ?>

<span>Hi, <?= htmlspecialchars($_SESSION['user_name']); ?></span>

<a href="dashboard.php">My Bookings</a>

<a href="admin/login.php" class="admin-link">Admin</a>

<a href="logout.php" class="logout">Logout</a>

<?php else: ?>

<a href="admin/login.php">Admin</a>
<a href="login.php">Login</a>
<a href="register.php">Register</a>

<?php endif; ?>

</nav>

</div>

</div>

</header>

<main class="container">