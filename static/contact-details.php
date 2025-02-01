<?php
include 'db.php';
// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company_address = $conn->real_escape_string($_POST['company_address']);
    $company_phone_number = $conn->real_escape_string($_POST['company_phone_number']);
    $company_email = $conn->real_escape_string($_POST['company_email']);
    $website_url = $conn->real_escape_string($_POST['website_url']);
    $branch_office = !empty($_POST['branch_office']) ? $conn->real_escape_string($_POST['branch_office']) : NULL;

    // Insert data into database
    $sql = "INSERT INTO contact_details (company_address, company_phone_number, company_email, website_url, branch_office) 
            VALUES ('$company_address', '$company_phone_number', '$company_email', '$website_url', '$branch_office')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Details saved successfully!'); window.location.href=' admin.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-up.html" />

	<title>Sign Up | AdminKit Demo</title>

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
							<h1 class="h2">Contact Details</h1>
							<p class="lead">
								 Fill in your Company Details
							</p> 
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-3">
									 
								<form method="POST" action="" enctype="multipart/form-data" onsubmit="return validateForm()">


						 
										<div class="mb-3">
											<label class="form-label" for="company_address">Address</label>
											<textarea class="form-control form-control-lg" name="company_address" id="company_address" placeholder="Enter the company address" required aria-label="Company Address"></textarea>
										</div>
										<div class="mb-3">
											<label class="form-label" for="company_phone_number">Phone Number</label>
											<input class="form-control form-control-lg" type="tel" name="company_phone_number" id="company_phone_number" placeholder="Enter the contact number" required aria-label="Company Phone Number" pattern="[0-9]{10}" />
										</div>
										<div class="mb-3">
											<label class="form-label" for="company_email">Email ID</label>
											<input class="form-control form-control-lg" type="email" name="company_email" id="company_email" placeholder="Enter the email ID" required aria-label="Company Email ID" />
										</div>
										<div class="mb-3">
											<label class="form-label" for="website_url">Website URL</label>
											<input class="form-control form-control-lg" type="url" name="website_url" id="website_url" placeholder="Enter the website URL" required aria-label="Website URL" />
										</div>
										<div class="mb-3">
											<label class="form-label" for="branch_office">Branch Office Address</label>
											<textarea class="form-control form-control-lg" name="branch_office" id="branch_office" placeholder="Enter the branch office address (optional)" aria-label="Branch Office Address"></textarea>
										</div>
										<div class="d-grid gap-2 mt-3">
											<button type="submit" class="btn btn-lg btn-primary">Save Details</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="js/app.js"></script>

</body>

</html>
