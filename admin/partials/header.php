<?php
session_start();

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Panel</title>

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

/* BLUE ADMIN HEADER */
.admin-navbar{
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

/* NAV LINKS */
.nav-links{
display:flex;
align-items:center;
gap:14px;
}

.nav-link{
padding:10px 16px;
border-radius:10px;
text-decoration:none;
font-size:14px;
font-weight:600;
color:#fff;
background:rgba(255,255,255,0.12);
transition:.3s;
}

.nav-link:hover{
background:rgba(255,255,255,0.25);
}

/* ACTIVE LINK */
.active{
background:#ffffff;
color:#1d4ed8;
}

/* LOGOUT BUTTON */
.logout-btn{
background:rgba(255,0,0,0.25);
color:#fff;
}

.logout-btn:hover{
background:rgba(255,0,0,0.4);
}

/* RESPONSIVE */
@media(max-width:768px){

.nav-flex{
flex-direction:column;
gap:12px;
align-items:flex-start;
}

.nav-links{
flex-wrap:wrap;
}

}

</style>

</head>

<body>

<div class="admin-navbar">

<div class="container">

<div class="nav-flex">

<a href="dashboard.php" class="logo">
🏔️ HikeHub Admin
</a>

<div class="nav-links">

<a 
href="dashboard.php"
class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>"
>
Dashboard
</a>

<a 
href="add_trek.php"
class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'add_trek.php' ? 'active' : '' ?>"
>
Add Trek
</a>

<a 
href="logout.php"
class="nav-link logout-btn"
>
Logout
</a>

</div>

</div>

</div>

</div>