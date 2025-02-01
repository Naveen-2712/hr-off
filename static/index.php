<?php
session_start();
include 'db.php';
include 'functions.php';

$error = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];


    // Admin credentials
    if ($email === 'admin' && $password === 'admin') {
        $_SESSION['is_admin'] = true;
        header("Location: admin.php");
        exit();
    }

    // User login
    $stmt = $conn->prepare("SELECT id, password, is_approved FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];
        $isApproved = $row['is_approved'];

        // Decrypt and verify password
        if (decryptPassword($storedPassword) === $password) {
            if ($isApproved) {
                $_SESSION['user_id'] = $row['id'];
                setcookie('logged_in', true, time() + (86400 * 30), "/"); // 30-day cookie
                header("Location: business_setup.php");
                exit();
            } else {
                $error = "Your account is pending approval. Please wait for admin approval.";
            }
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "User not found. Please register first.";
    }
	
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-in.html" />

	<title>Sign In</title>

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">Welcome back!</h1>
							<p class="lead">
								Sign in to your account to continue
							</p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-3">
								<?php if ($error): ?>
                            	<div class="alert alert-danger"><?= $error ?></div>
                				<?php endif; ?>
                        		<form method="POST">
                            		<div class="mb-3">
                                		<label for="email" class="form-label"><i class="bi bi-envelope"></i> Email/Username</label>
                                		<input type="text" name="email" id="email" class="form-control" required>
                            		</div>
                            		<div class="mb-3">
                                		<label for="password" class="form-label"><i class="bi bi-lock"></i> Password</label>
                                	<input type="password" name="password" id="password" class="form-control" required>
                            	</div>
                            	<button type="submit" class="btn btn-primary w-100"><i class="bi bi-box-arrow-in-right"></i> Login</button>
                        		</form>
								</div>
							</div>
						</div>
						<div class="text-center mb-3">
							Don't have an account? <a href="sign-up.php">Sign up</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="js/app.js"></script>

</body>

</html>