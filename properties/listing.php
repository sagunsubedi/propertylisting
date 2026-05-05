<?php
/** @var mysqli $link */

require_once '../config.php';
require_once '../includes/header.php';

$id = $_GET['id'];
$property = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM properties WHERE id=$id"));

if(!$property){
    echo "Property not found.";
    exit();
}

$success = "";
$error = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $sender_name = trim($_POST['sender_name']);
    $email       = trim($_POST['email']);
    $message     = trim($_POST['message']);

    if(empty($sender_name) || empty($email) || empty($message)){
        $error = "All fields are required.";
    } else {
        $result = mysqli_query($link, "INSERT INTO inquiries (property_id, sender_name, email, message) VALUES ('$id', '$sender_name', '$email', '$message')");
        if($result){
            $success = "Inquiry sent successfully.";
        } else {
            $error = "Something went wrong. Try again.";
        }
    }
}
?>

<h2><?= $property['title'] ?></h2>

<table class="table table-bordered col-md-6">
    <tr>
        <th>Type</th>
        <td><?= ucfirst($property['type']) ?></td>
    </tr>
    <tr>
        <th>Price</th>
        <td>Rs. <?= $property['price'] ?></td>
    </tr>
    <tr>
        <th>Location</th>
        <td><?= $property['location'] ?></td>
    </tr>
    <tr>
        <th>Description</th>
        <td><?= $property['description'] ?></td>
    </tr>
</table>

<h4>Send Inquiry</h4>

<?php if($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
<?php endif; ?>

<?php if($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<div class="col-md-6">
    <form method="POST">
        <div class="form-group mb-3">
            <label>Name</label>
            <input type="text" name="sender_name" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label>Message</label>
            <textarea name="message" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Inquiry</button>
        <a href="../index.php" class="btn btn-secondary">Back</a>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>