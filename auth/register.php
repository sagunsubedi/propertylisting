<?php

require_once '../config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $phone    = trim($_POST['phone']);

    $check = mysqli_query($link, "SELECT id FROM users WHERE email='$email'");
    if(mysqli_num_rows($check) > 0){
        $error = "Email already registered.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $result = mysqli_query($link, "INSERT INTO users (name, email, password, phone, role) VALUES ('$name', '$email', '$hashed', '$phone', 'user')");

        if($result){
            header('location: login.php');
            exit();
        } else {
            $error = "Registration failed. Try again.";
        }
    }
}
?>

<?php require_once '../includes/header.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h2 class="my-3">Register</h2>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
                <a href="login.php" class="btn btn-secondary btn-block mt-2">Already have account? Login</a>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>