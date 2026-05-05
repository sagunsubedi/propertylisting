<?php
/** @var mysqli $link */

require_once '../config.php';

if(!isset($_SESSION['user_id'])){
    header('location: ../auth/login.php');
    exit();
}

$error = "";


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $title       = trim($_POST['title']);
    $type        = $_POST['type'];
    $price       = $_POST['price'];
    $location    = trim($_POST['location']);
    $description = trim($_POST['description']);
    $user_id     = $_SESSION['user_id'];

    if(empty($title) || empty($price) || empty($location)){
        $error = "Title, price and location are required.";
    } else {
        $result = mysqli_query($link, "INSERT INTO properties (user_id, title, type, price, location, description) VALUES ('$user_id', '$title', '$type', '$price', '$location', '$description')");
        if($result){
            header('location: ../index.php');
            exit();
        } else {
            $error = "Something went wrong. Try again.";
        }
    }
}

require_once '../includes/header.php';
?>

<h2>Post Property</h2>

<?php if($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<div class="row">
    <div class="col-md-6">
        <form method="POST">
            <div class="form-group mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label>Type</label>
                <select name="type" class="form-control">
                    <option value="rent">Rent</option>
                    <option value="sale">Sale</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label>Price</label>
                <input type="number" name="price" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label>Location</label>
                <input type="text" name="location" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Post Property</button>
            <a href="../index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>