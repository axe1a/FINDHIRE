<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/styles/styles.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="/styles/navbar.php?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<div class="top-navbar">
    <div class="navbar-item">
        <a href="index.php"><img src="logo/NAME.png" class="navbar-logo">
    </div>
    <div class="navbar-item">
        <a href="index.php" class="navbar-item-text"><i class="fa-solid fa-house navbar-item-icon"></i></i><br>
        <span>Home</span></a>
    </div>
    <div class="navbar-item">
        <a href="profile.php?user_id=<?php echo $_SESSION['user_id']; ?>" class="navbar-item-text"><i class="fa-solid fa-user navbar-item-icon"></i><br>
        <span>Profile</span></a>
    </div>
    <div class="navbar-item">
        <a href="applications.php" class="navbar-item-text"><i class="fa-solid fa-briefcase navbar-item-icon"></i></i><br>
        <span>Applications</span></a>
    </div>
    <div class="navbar-item">
        
    </div>
    <div class="navbar-item">
        
    </div>
    <div class="navbar-item">
        
    </div>
    <div class="navbar-item">
    <p style="color:black;">Hello, <?php echo $_SESSION['first_name']; ?>!</p> 

    </div>    
    <div class="navbar-item">
        <a href="core/handleForms.php?logoutUserBtn=1" class="navbar-item-text">Logout</a>
    </div>  
</div>
</body>
</html>