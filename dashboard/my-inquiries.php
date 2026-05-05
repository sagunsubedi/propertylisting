<?php
/** @var mysqli $link */
require_once '../config.php';

if(!isset($_SESSION['user_id'])){
    header('location: ../auth/login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$result = mysqli_query($link, "SELECT inquiries.*, properties.title FROM inquiries 
    JOIN properties ON inquiries.property_id = properties.id 
    WHERE properties.user_id=$user_id 
    ORDER BY inquiries.created_at DESC");

require_once '../includes/header.php';
?>

<h2>My Inquiries</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Property</th>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php if(mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['title'] ?></td>
                <td><?= $row['sender_name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['message'] ?></td>
                <td><?= $row['created_at'] ?></td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">No inquiries yet.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php require_once '../includes/footer.php'; ?>