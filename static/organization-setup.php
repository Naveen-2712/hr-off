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
							<h1 class="h2">Organization Setup</h1>
							<p class="lead">Fill in your company details.</p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-3">
									<form method="POST" enctype="multipart/form-data" action="">

										<div class="mb-3">
											<label class="form-label" for="founder_name">Founder Name</label>
											<input class="form-control form-control-lg" type="text" name="founder_name" id="founder_name" placeholder="Enter founder name" required />
										</div>

										<div class="mb-3">
											<label class="form-label" for="ceo">CEO</label>
											<input class="form-control form-control-lg" type="text" name="ceo" id="ceo" placeholder="Enter CEO name" required />
										</div>

										<div class="mb-3">
											<label class="form-label">Departments</label>
											<div id="departments">
												<div class="department-entry mb-3">
													<label>Department Name</label>
													<input class="form-control form-control-lg mb-2" type="text" name="department[]" placeholder="Enter department name" required />
													<label>Employee Count</label>
													<input class="form-control form-control-lg mb-2" type="number" name="employee_count[]" placeholder="Employee count" required />
													<label>Manager</label>
													<input class="form-control form-control-lg mb-2" type="text" name="manager[]" placeholder="Enter Manager name" required />
													<label>Project Manager</label>
													<input class="form-control form-control-lg mb-2" type="text" name="project_manager[]" placeholder="Enter Project Manager name" required />
													<button type="button" class="btn btn-outline-secondary add-department">Add Department</button>
												</div>
											</div>
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

	<script>
		document.addEventListener("DOMContentLoaded", function () {
			document.getElementById("departments").addEventListener("click", function (event) {
				if (event.target.classList.contains("add-department")) {
					let departmentDiv = document.createElement("div");
					departmentDiv.classList.add("department-entry", "mb-3");

					departmentDiv.innerHTML = `
						<label>Department Name</label>
						<input class="form-control form-control-lg mb-2" type="text" name="department[]" placeholder="Enter department name" required />
						<label>Employee Count</label>
						<input class="form-control form-control-lg mb-2" type="number" name="employee_count[]" placeholder="Employee count" required />
						<label>Manager</label>
						<input class="form-control form-control-lg mb-2" type="text" name="manager[]" placeholder="Enter Manager name" required />
						<label>Project Manager</label>
						<input class="form-control form-control-lg mb-2" type="text" name="project_manager[]" placeholder="Enter Project Manager name" required />
						<button type="button" class="btn btn-outline-danger remove-department">Remove Department</button>
					`;

					document.getElementById("departments").appendChild(departmentDiv);
				} else if (event.target.classList.contains("remove-department")) {
					event.target.parentElement.remove();
				}
			});
		});
	</script>
</body>

</html>

<!-- -- PHP Code to Handle Form Submission -- -->
<?php
include 'db.php'; // Database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $founder_name = $_POST['founder_name'];
    $ceo = $_POST['ceo'];
    
    // Insert into organization table
    $stmt = $conn->prepare("INSERT INTO organization (founder_name, ceo) VALUES (?, ?)");
    $stmt->bind_param("ss", $founder_name, $ceo);
    
    if ($stmt->execute()) {
        $organization_id = $stmt->insert_id;
        $stmt->close();
        
        // Insert into departments table
        $departments = $_POST['department'];
        $employee_counts = $_POST['employee_count'];
        $managers = $_POST['manager'];
        $project_managers = $_POST['project_manager'];
        
        $stmt = $conn->prepare("INSERT INTO departments (organization_id, department_name, employee_count, manager, project_manager) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isiss", $organization_id, $department_name, $employee_count, $manager, $project_manager);
        
        for ($i = 0; $i < count($departments); $i++) {
            $department_name = $departments[$i];
            $employee_count = $employee_counts[$i];
            $manager = $managers[$i];
            $project_manager = $project_managers[$i];
            
            $stmt->execute();
        }
        
        $stmt->close();
        echo "<script>alert('Organization details saved successfully!');window.location.href='admin.php'; </script>";
    } else {
        echo "<script>alert('Error saving data.'); window.history.back();</script>";
    }
}
$conn->close();
?>

