<?php
include 'db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process multiple shifts
    if (!empty($_POST['shift_name'])) {
        foreach ($_POST['shift_name'] as $key => $shiftName) {
            $shiftStart = $_POST['shift_start'][$key];
            $shiftEnd = $_POST['shift_end'][$key];

            $stmt = $conn->prepare("INSERT INTO company_policies (shift_name, shift_start, shift_end) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $shiftName, $shiftStart, $shiftEnd);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Process multiple leave policies
    if (!empty($_POST['leave_type'])) {
        foreach ($_POST['leave_type'] as $key => $leaveType) {
            $leaveDays = $_POST['leave_days'][$key];

            $stmt = $conn->prepare("INSERT INTO company_policies (leave_type, leave_days) VALUES (?, ?)");
            $stmt->bind_param("si", $leaveType, $leaveDays);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Process multiple insurance policies
    if (!empty($_FILES['insurance_policy']['name'][0])) {
        $uploadDir = "uploads/insurance/";
        foreach ($_FILES['insurance_policy']['name'] as $key => $fileName) {
            $targetFile = $uploadDir . basename($fileName);
            move_uploaded_file($_FILES['insurance_policy']['tmp_name'][$key], $targetFile);

            $expiryDate = $_POST['expiry_date'][$key];

            $stmt = $conn->prepare("INSERT INTO company_policies (insurance_policy, expiry_date) VALUES (?, ?)");
            $stmt->bind_param("ss", $targetFile, $expiryDate);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Process company guidelines (Single file upload)
    if (!empty($_FILES['company_guidelines']['name'])) {
        $uploadDir = "uploads/guidelines/";
        $targetFile = $uploadDir . basename($_FILES['company_guidelines']['name']);
        move_uploaded_file($_FILES['company_guidelines']['tmp_name'], $targetFile);

        $stmt = $conn->prepare("INSERT INTO company_policies (company_guidelines) VALUES (?)");
        $stmt->bind_param("s", $targetFile);
        $stmt->execute();
        $stmt->close();
    }

    echo "<script>alert('Details saved successfully!'); window.location.href=' admin.php';</script>";
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Company Policy Form</title>
	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<style>
		.add-remove-buttons {
			display: flex;
			align-items: center;
			gap: 5px;
		}
	</style>
</head>

<body>
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">Company Policy Form</h1>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-3">
									<form method="POST"   enctype="multipart/form-data">

										<!-- Shift Management -->
										<div class="mb-3">
											<label class="form-label">Shifts</label>
											<div id="shift-container">
												<div class="d-flex align-items-center mt-2">
													<input type="text" class="form-control" name="shift_name[]" placeholder="Shift Name" required>
													<input type="time" class="form-control ms-2" name="shift_start[]" required>
													<input type="time" class="form-control ms-2" name="shift_end[]" required>
													<div class="add-remove-buttons">
														<button type="button" class="btn btn-success ms-2" onclick="addShift()">+</button>
														<button type="button" class="btn btn-danger ms-2" onclick="removeField(this)">-</button>
													</div>
												</div>
											</div>
										</div>

										<!-- Leave Policy -->
										<div class="mb-3">
											<label class="form-label">Leave Policy</label>
											<div id="leave-container">
												<div class="d-flex align-items-center mt-2">
													<input type="text" class="form-control" name="leave_type[]" placeholder="Leave Type (e.g., Paid Leave)" required>
													<input type="number" class="form-control ms-2" name="leave_days[]" placeholder="Days" min="1" required>
													<div class="add-remove-buttons">
														<button type="button" class="btn btn-success ms-2" onclick="addLeave()">+</button>
														<button type="button" class="btn btn-danger ms-2" onclick="removeField(this)">-</button>
													</div>
												</div>
											</div>
										</div>

										<!-- Insurance Policy -->
										<div class="mb-3">
											<label class="form-label">Insurance Policy</label>
											<div id="insurance-container">
												<div class="d-flex align-items-center mt-2">
													<input type="file" class="form-control" name="insurance_policy[]" required>
													<input type="date" class="form-control ms-2" name="expiry_date[]" required>
													<div class="add-remove-buttons">
														<button type="button" class="btn btn-success ms-2" onclick="addInsurance()">+</button>
														<button type="button" class="btn btn-danger ms-2" onclick="removeField(this)">-</button>
													</div>
												</div>
											</div>
										</div>

										<!-- Company Rules & Guidelines -->
										<div class="mb-3">
											<label class="form-label">Company Rules & Guidelines</label>
											<input type="file" class="form-control" name="company_guidelines" required>
										</div>

										<!-- Submit Button -->
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
		// Function to add a shift
		function addShift() {
			let container = document.getElementById("shift-container");
			let div = document.createElement("div");
			div.classList.add("d-flex", "mt-2", "align-items-center");
			div.innerHTML = `
				<input type="text" class="form-control" name="shift_name[]" placeholder="Shift Name" required>
				<input type="time" class="form-control ms-2" name="shift_start[]" required>
				<input type="time" class="form-control ms-2" name="shift_end[]" required>
				<div class="add-remove-buttons">
					<button type="button" class="btn btn-success ms-2" onclick="addShift()">+</button>
					<button type="button" class="btn btn-danger ms-2" onclick="removeField(this)">-</button>
				</div>`;
			container.appendChild(div);
		}

		// Function to add a leave policy
		function addLeave() {
			let container = document.getElementById("leave-container");
			let div = document.createElement("div");
			div.classList.add("d-flex", "mt-2", "align-items-center");
			div.innerHTML = `
				<input type="text" class="form-control" name="leave_type[]" placeholder="Leave Type (e.g., Paid Leave)" required>
				<input type="number" class="form-control ms-2" name="leave_days[]" placeholder="Days" min="1" required>
				<div class="add-remove-buttons">
					<button type="button" class="btn btn-success ms-2" onclick="addLeave()">+</button>
					<button type="button" class="btn btn-danger ms-2" onclick="removeField(this)">-</button>
				</div>`;
			container.appendChild(div);
		}

		// Function to add an insurance file upload field with expiry date
		function addInsurance() {
			let container = document.getElementById("insurance-container");
			let div = document.createElement("div");
			div.classList.add("d-flex", "mt-2", "align-items-center");
			div.innerHTML = `
				<input type="file" class="form-control" name="insurance_policy[]" required>
				<input type="date" class="form-control ms-2" name="expiry_date[]" required>
				<div class="add-remove-buttons">
					<button type="button" class="btn btn-success ms-2" onclick="addInsurance()">+</button>
					<button type="button" class="btn btn-danger ms-2" onclick="removeField(this)">-</button>
				</div>`;
			container.appendChild(div);
		}

		// Function to remove a field
		function removeField(button) {
			button.parentElement.parentElement.remove();
		}
	</script>

</body>

</html>

