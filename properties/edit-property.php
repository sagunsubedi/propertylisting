<?php
/** @var mysqli $link */
require_once '../config.php';

if(!isset($_SESSION['user_id'])){
    header('location: ../auth/login.php');
    exit();
}

$id = $_GET['id'];
$property = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM properties WHERE id=$id AND user_id=".$_SESSION['user_id']));

if(!$property){
    echo "Property not found.";
    exit();
}

$error = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $title       = trim($_POST['title']);
    $type        = $_POST['type'];
    $price       = $_POST['price'];
    $location    = trim($_POST['location']);
    $description = trim($_POST['description']);

    if(empty($title) || empty($price) || empty($location)){
        $error = "Title, price and location are required.";
    } else {
        $result = mysqli_query($link, "UPDATE properties SET title='$title', type='$type', price='$price', location='$location', description='$description' WHERE id=$id");
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

<h2>Edit Property</h2>

<?php if($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<div class="col-md-6">
    <form method="POST">
        <div class="form-group mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="<?= $property['title'] ?>" required>
        </div>
        <div class="form-group mb-3">
            <label>Type</label>
            <select name="type" class="form-control">
                <option value="rent" <?= $property['type'] == 'rent' ? 'selected' : '' ?>>Rent</option>
                <option value="sale" <?= $property['type'] == 'sale' ? 'selected' : '' ?>>Sale</option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label>Price</label>
            <input type="number" name="price" class="form-control" value="<?= $property['price'] ?>" required>
        </div>
        <div class="form-group mb-3">
            <label>Location</label>
            <input type="text" name="location" class="form-control" value="<?= $property['location'] ?>" required>
        </div>
        <div class="form-group mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="4"><?= $property['description'] ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Property</button>
        <a href="../index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>