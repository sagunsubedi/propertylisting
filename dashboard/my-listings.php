<?php
/** @var mysqli $link */
require_once '../config.php';

if(!isset($_SESSION['user_id'])){
    header('location: ../auth/login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$result = mysqli_query($link, "SELECT * FROM properties WHERE user_id=$user_id ORDER BY created_at DESC");

require_once '../includes/header.php';
?>

<h2>My Listings</h2>

<a href="/propertylisting/properties/post-property.php" class="btn btn-primary mb-3">Post New Property</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Title</th>
            <th>Type</th>
            <th>Price</th>
            <th>Location</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['title'] ?></td>
                <td><?= ucfirst($row['type']) ?></td>
                <td>Rs. <?= $row['price'] ?></td>
                <td><?= $row['location'] ?></td>
                <td>
                    <a href="/propertylisting/properties/edit-property.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="/propertylisting/properties/delete-property.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">No properties found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php require_once '../includes/footer.php'; ?>