<?php
/** @var mysqli $link */

require_once '../config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $result = mysqli_query($link, "SELECT * FROM users WHERE email='$email'");
    $user   = mysqli_fetch_assoc($result);

    if($user && password_verify($password, $user['password'])){
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        
        header('location: ../index.php');
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<?php require_once '../includes/header.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h2 class="my-3">Login</h2>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
                <a href="register.php" class="btn btn-secondary btn-block mt-2">Don't have account? Register</a>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>