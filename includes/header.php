<?php  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Listing</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-dark bg-dark px-4">
    <a class="navbar-brand" href="/propertylisting/index.php">Property Listing</a>
    <div class="d-flex gap-3">
        <a class="nav-link d-inline text-white" href="/propertylisting/index.php">Home</a>
        <a class="nav-link d-inline text-white" href="/propertylisting/properties/post-property.php">Post Property</a>

        <?php if(isset($_SESSION['user_id'])): ?>
            <a class="nav-link d-inline text-white" href="/propertylisting/dashboard/my-listings.php">My Listings</a>
            <a class="nav-link d-inline text-white" href="/propertylisting/dashboard/my-inquiries.php">My Inquiries</a>
            <a class="nav-link d-inline text-warning" href="/propertylisting/auth/logout.php">Logout</a>
        <?php else: ?>
            <a class="nav-link d-inline text-white" href="/propertylisting/auth/login.php">Login</a>
            <a class="nav-link d-inline text-white" href="/propertylisting/auth/register.php">Register</a>
        <?php endif; ?>
    </div>
</nav>

<div class="container mt-4">