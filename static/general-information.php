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

	<title>Company Profile | AdminKit Demo</title>

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
							<h1 class="h2">General Information</h1>
							<p class="lead">Fill in your company details.</p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-3">
									<for method="POST" enctype="multipart/form-data" action="">

										<div class="mb-3">
											<label class="form-label" for="company_name">Company Name</label>
											<input class="form-control form-control-lg" type="text" name="company_name" id="company_name" placeholder="Enter company name" required />
										</div>
										
										<div class="mb-3">
											<label class="form-label" for="company_logo">Company Logo</label>
											<input class="form-control form-control-lg" type="file" name="company_logo" id="company_logo" accept=".jpg,.png" required />
											<small class="form-text text-muted">Only JPG and PNG file formats are allowed. Max size: 2MB.</small>
										</div>

										<div class="mb-3">
											<label class="form-label" for="tagline">Tagline</label>
											<input class="form-control form-control-lg" type="text" name="tagline" id="tagline" placeholder="Enter company tagline" required />
										</div>

										<div class="mb-3">
											<label class="form-label" for="industry">Industry</label>
											<input class="form-control form-control-lg" type="text" name="industry" id="industry" placeholder="Enter industry" required />
										</div>

										<div class="mb-3">
											<label class="form-label" for="year_established">Year Established</label>
											<input class="form-control form-control-lg" type="text" name="year_established" id="year_established" placeholder="Enter year established" required />
										</div>

										<div class="mb-3">
											<label class="form-label" for="about_us">About Us</label>
											<textarea class="form-control form-control-lg" name="about_us" id="about_us" rows="4" placeholder="Enter about us information" required></textarea>
										</div>

										<div class="mb-3">
											<label class="form-label" for="mission">Mission</label>
											<textarea class="form-control form-control-lg" name="mission" id="mission" rows="3" placeholder="Enter mission" required></textarea>
										</div>

										<div class="mb-3">
											<label class="form-label" for="vision">Vision</label>
											<textarea class="form-control form-control-lg" name="vision" id="vision" rows="3" placeholder="Enter vision" required></textarea>
										</div>

										<div class="mb-3">
											<label class="form-label" for="partnership">Partnership</label>
											<textarea class="form-control form-control-lg" name="partnership" id="partnership" rows="3" placeholder="Enter partnership details" required></textarea>
										</div>

										<div class="d-grid gap-2 mt-3">
											<button type="submit" class="btn btn-lg btn-primary" href="">Save Details</button>
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
</body>

</html>
<!-- backend -->
<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company_name = $_POST['company_name'];
    $tagline = $_POST['tagline'];
    $industry = $_POST['industry'];
    $year_established = $_POST['year_established'];
    $about_us = $_POST['about_us'];
    $mission = $_POST['mission'];
    $vision = $_POST['vision'];
    $partnership = $_POST['partnership'];

    // File upload handling
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($_FILES["company_logo"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = array("jpg", "png");

    if (in_array($imageFileType, $allowed_types) && $_FILES["company_logo"]["size"] <= 2097152) {
        if (move_uploaded_file($_FILES["company_logo"]["tmp_name"], $target_file)) {
            $company_logo = $target_file;
        } else {
            die("Error uploading file.");
        }
    } else {
        die("Invalid file type or size.");
    }

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO company (company_name, company_logo, tagline, industry, year_established, about_us, mission, vision, partnership) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $company_name, $company_logo, $tagline, $industry, $year_established, $about_us, $mission, $vision, $partnership);

    if ($stmt->execute()) { echo "<script>alert('Organization details saved successfully!'); window.location.href='admin.php'; </script>";
} else {
	echo "<script>alert('Error saving data.'); window.history.back();</script>";
}

    $stmt->close();
    $conn->close();
}
?>
