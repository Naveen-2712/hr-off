<?php
include 'connection.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Retrieve form data
    $email = $_POST['email'];
    $name = $_POST['name'];
    $phone_number = $_POST['number'];
    $emergency_number = $_POST['emergency_contact'];
    $date_of_birth = $_POST['dob'];
    $blood_group = $_POST['bloodgroup'];
    $marital_status = $_POST['marital_status'];
    $address_line1 = $_POST['address_line1'];
    $address_line2 = $_POST['address_line2'];
    $postal_code = $_POST['postal_code'];
	$state=$_POST['state'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // File upload handling
    $photo = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; // Folder where images will be stored
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
        }
        $fileName = time() . '_' . basename($_FILES['photo']['name']); // Unique file name
        $targetPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
            $photo = $targetPath; // Save the file path in the database
        }
    }
    // Job Information
    $role = $_POST['role'];
    $department = $_POST['department'];
    $date_of_joining = $_POST['dateofjoining'];
    $work_experience = $_POST['work_experience'];
    $previous_company_name = $_POST['company_name'];
    $previous_company_role = $_POST['role1'];
    $previous_company_salary = $_POST['salary'];
    $number_of_years_experience = $_POST['years_worked'];

    // Bank Information
    $account_holder_name = $_POST['account_holder_name'];
    $account_number = $_POST['account_number'];
    $IFSC_code = $_POST['ifsc'];
    $bank_name = $_POST['bank_name'];
    $bank_branch_name = $_POST['branch'];

    try {
        // Insert into users table
        $stmt = $pdo->prepare("INSERT INTO users (email, name, phone_number, emergency_number, date_of_birth, blood_group, marital_status, address_line1, address_line2, postal_code, state, city, country, photo, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$email, $name, $phone_number, $emergency_number, $date_of_birth, $blood_group, $marital_status, $address_line1, $address_line2, $postal_code, $state, $city, $country, $photo, $password]);

        // Insert into jobs table
        foreach ($previous_company_name as $index => $company_name) {
            $stmt = $pdo->prepare("INSERT INTO jobs (email, role, department, date_of_joining, work_experience, previous_company_name, previous_company_role, previous_company_salary, number_of_years_experience) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$email, $role, $department, $date_of_joining, $work_experience, $company_name, $previous_company_role[$index], $previous_company_salary[$index], $number_of_years_experience[$index]]);
        }
        // Insert into banks table
        $stmt = $pdo->prepare("INSERT INTO banks (email, account_holder_name, account_number, IFSC_code, bank_name, bank_branch_name) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$email, $account_holder_name, $account_number, $IFSC_code, $bank_name, $bank_branch_name]);
    	} catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
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
							<h1 class="h2">Welcome to HRMATE</h1>
							<p class="lead">Start creating your profile.</p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-3">
									<h4 class="mb-4">Personal Details</h4>
									<form method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
										<div class="mb-3">
											<label class="form-label" for="name">Full name</label>
											<input class="form-control form-control-lg" type="text" name="name" id="name" placeholder="Enter your name" required aria-label="Full name" />
										</div>
										<div class="mb-3">
											<label class="form-label" for="number">Phone Number</label>
											<input class="form-control form-control-lg" type="tel" name="number" id="number" placeholder="Enter your contact number" required aria-label="Phone Number" pattern="[0-9]{10}" />
										</div>
										<div class="mb-3">
											<label class="form-label" for="email">Mail ID</label>
											<input class="form-control form-control-lg" type="email" name="email" id="email" placeholder="Enter email id" required aria-label="Email" />
										</div>
										<div class="mb-3">
											<label class="form-label" for="dob">Date of Birth</label>
											<input class="form-control form-control-lg" type="date" name="dob" id="dob" placeholder="Enter Your Date of Birth" required aria-label="Date of Birth" />
										</div>
										<h5 class="mb-3">Address</h5>
										<div class="mb-3">
											<label class="form-label" for="address_line1">Address Line 1</label>
											<input class="form-control form-control-lg" type="text" name="address_line1" id="address_line1" placeholder="Enter address line 1" required aria-label="Address Line 1" />
										</div>
										<div class="mb-3">
											<label class="form-label" for="address_line2">Address Line 2</label>
											<input class="form-control form-control-lg" type="text" name="address_line2" id="address_line2" placeholder="Enter address line 2 (optional)" aria-label="Address Line 2" />
										</div>
										<div class="mb-3">
											<label class="form-label" for="postal_code">Postal Code</label>
											<input class="form-control form-control-lg" type="text" name="postal_code" id="postal_code" placeholder="Enter postal code" />
										</div>
										<div class="mb-3">
											<label class="form-label" for="state">State</label>
											<input class="form-control form-control-lg" type="text" name="state" id="state" placeholder="Enter State" required aria-label="City" />
										</div>
										<div class="mb-3">
											<label class="form-label" for="city">City</label>
											<input class="form-control form-control-lg" type="text" name="city" id="city" placeholder="Enter city" required aria-label="City" />
										</div>
										<div class="mb-3">
											<label class="form-label" for="country">Country</label>
											<input class="form-control form-control-lg" type="text" name="country" id="country" placeholder="Enter country" required aria-label="Country" />
										</div>
										<div class="mb-3">
											<label class="form-label" for="emergency_contact">Emergency Contact No.</label>
											<input class="form-control form-control-lg" type="tel" name="emergency_contact" id="emergency_contact" placeholder="Enter your emergency contact number" required aria-label="Emergency Contact" pattern="[0-9]{10}" />
										</div>
										<div class="mb-3">
											<label class="form-label" for="bloodgroup">Blood Group</label>
											<input class="form-control form-control-lg" type="text" name="bloodgroup" id="bloodgroup" placeholder="Enter your blood group" required aria-label="Blood Group" />
										</div>
										<div class="mb-3">
											<label class="form-label">Marital Status</label>
											<div>
												<div class="form-check">
													<input class="form-check-input" type="radio" name="marital_status" value="Single" id="single" required />
													<label class="form-check-label" for="single">Single</label>
												</div>
												<div class="form-check">
													<input class="form-check-input" type="radio" name="marital_status" value="Married" id="married" />
													<label class="form-check-label" for="married">Married</label>
												</div>
												<div class="form-check">
													<input class="form-check-input" type="radio" name="marital_status" value="Divorced" id="divorced" />
													<label class="form-check-label" for="divorced">Divorced</label>
												</div>
												<div class="form-check">
													<input class="form-check-input" type="radio" name="marital_status" value="Widowed" id="widowed" />
													<label class="form-check-label" for="widowed">Widowed</label>
												</div>
											</div>
										</div>

										<div class="mb-3">
											<label class="form-label" for="photo">Photo</label>
											<input 
												class="form-control form-control-lg" 
												type="file" 
												name="photo" 
												id="photo" 
												accept=".jpg,.png" 
												required 
												aria-label="Photo" 
												onchange="validateAndPreviewPhoto(event)" 
											/>
											<small class="form-text text-muted">
												Only JPG and PNG file formats are allowed. Max size: 2MB.
											</small>
											<div id="photoPreview" class="mt-3">
												<!-- Image preview will be displayed here -->
											</div>
										</div>
										
										<h4 class="mb-4">Job Details</h4>


										
										<div class="mb-3">
											<label class="form-label" for="department">Department</label>
											<select class="form-control form-control-lg" name="department" id="departmentDropdown" onchange="updateRoles()" required>
												<option value="">Select Department</option>
												<option value="IT">IT</option>
											</select>
										</div>

										<div class="mb-3">
											<label class="form-label" for="role">Role</label>
											<select class="form-control form-control-lg" name="role" id="roleDropdown">
												<option value="">Select Role</option>
											</select>
										</div>
										<div class="mb-3">
											<label class="form-label" for="dateofjoining">Date of joining</label>
											<input class="form-control form-control-lg" type="date" name="dateofjoining" id="dateofjoining" placeholder="Enter your date of joining" />
										</div>
										<div class="mb-3">
											<label class="form-label">Work Experience</label>
											<div>
												<input type="radio" id="experienceYes" name="experiences" value="yes" onclick="toggleCompanyDetails(true)" />
												<label for="experienceYes">Yes</label>
												<input type="radio" id="experienceNo" name="experiences" value="no" onclick="toggleCompanyDetails(false)" />
												<label for="experienceNo">No</label>
											</div>
										</div>
										
										<!-- Container for company details -->
										<div id="companyDetailsContainer" style="display: none; margin-top: 20px;">
										<div class="mb-3">
											<label class="form-label" for="postal_code">Work experiance</label>
											<input class="form-control form-control-lg" type="number" name="work_experience" id="work_experience" placeholder="Enter work experience" />
										</div>
											<h5 class="mb-3">Previous Company Details</h5>
											<div id="companyDetails">
												<div class="company-detail">
													<div class="mb-3">
														<label class="form-label" for="company_name">Company Name</label>
														<input class="form-control form-control-lg" type="text" name="company_name[]" placeholder="Enter company name" />
													</div>
													<div class="mb-3">
														<label class="form-label" for="role">Role</label>
														<input class="form-control form-control-lg" type="text" name="role1[]" placeholder="Enter your role" />
													</div>
													<div class="mb-3">
														<label class="form-label" for="salary">Salary</label>
														<input class="form-control form-control-lg" type="number" name="salary[]" placeholder="Enter your salary" />
													</div>
													<div class="mb-3">
														<label class="form-label" for="years_worked">Years Worked</label>
														<input class="form-control form-control-lg" type="number" name="years_worked[]" placeholder="Enter years worked" />
													</div>
												</div>
											</div>
											<button type="button" class="btn btn-sm btn-secondary" onclick="addAnotherCompany()">Add Another Company</button>
										</div>
										
										<h4 class="mb-4">Bank Details</h4>
										<div class="mb-3">
											<label class="form-label" for="account_holder_name">Account holder name</label>
											<input class="form-control form-control-lg" type="text" name="account_holder_name" id="account_holder_name" placeholder="Enter the name" />
										</div>
										<div class="mb-3">
											<label class="form-label" for="account_number">Account number</label>
											<input class="form-control form-control-lg" type="text" name="account_number" id="account_number" placeholder="Enter account number" />
										</div>
										<div class="mb-3">
											<label class="form-label" for="ifsc">IFSC Code</label>
											<input class="form-control form-control-lg" type="text" name="ifsc" id="ifsc" placeholder="Enter the IFSC Code" />
										</div>
										<div class="mb-3">
											<label class="form-label" for="bank_name">Bank Name</label>
											<input class="form-control form-control-lg" type="text" name="bank_name" id="bank_name" placeholder="Enter the name" />
										</div>
										<div class="mb-3">
											<label class="form-label" for="branch">Branch</label>
											<input class="form-control form-control-lg" type="text" name="branch" id="branch" placeholder="Enter the branch" />
										</div>
										<div class="mb-3">
											<label class="form-label" for="password">Password</label>
											<input class="form-control form-control-lg" type="password" name="password" id="password" placeholder="Enter your password" required />
										</div>

										<div class="mb-3">
											<label class="form-label" for="confirm_password">Confirm Password</label>
											<input class="form-control form-control-lg" type="password" name="confirm_password" id="confirm_password" placeholder="Re-enter your password" required />
										</div>
										<div class="d-grid gap-2 mt-3">
											<button type="submit" class="btn btn-lg btn-primary">Sign up</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="text-center mb-3">
							Already have account? <a href="pages-sign-in.html">Log In</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="js/app.js"></script>
	<script>
    function validateAndPreviewPhoto(event) {
        const fileInput = event.target;
        const file = fileInput.files[0];
        const previewContainer = document.getElementById("photoPreview");
        const maxFileSize = 2 * 1024 * 1024; // 2MB

        // Clear previous preview
        previewContainer.innerHTML = "";

        if (file) {
            // Validate file type
            const allowedTypes = ["image/jpeg", "image/png"];
            if (!allowedTypes.includes(file.type)) {
                alert("Invalid file format. Only JPG and PNG are allowed.");
                fileInput.value = ""; // Reset the input
                return;
            }

            // Validate file size
            if (file.size > maxFileSize) {
                alert("File is too large. Maximum size is 2MB.");
                fileInput.value = ""; // Reset the input
                return;
            }

            // Generate a preview
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement("img");
                img.src = e.target.result;
                img.alt = "Preview";
                img.style.maxWidth = "150px";
                img.style.borderRadius = "8px";
                img.style.boxShadow = "0 4px 6px rgba(0,0,0,0.1)";
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    }

    function validateForm() {
        const email = document.getElementById("email").value;
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirm_password").value;

        // Check if email is valid
        if (!emailPattern.test(email)) {
            alert("Please enter a valid email address.");
            return false;
        }

        // Check if passwords match
        if (password !== confirmPassword) {
            alert("Passwords do not match.");
            return false;
        }

        // Check password length (optional validation)
        if (password.length < 6) {
            alert("Password must be at least 6 characters long.");
            return false;
        }

        return true;
    }

    function updateRoles() {
        const department = document.getElementById("departmentDropdown").value;
        const roleDropdown = document.getElementById("roleDropdown");

        // Clear existing options
        roleDropdown.innerHTML = '<option value="">Select Role</option>';

        // Define roles for each department
        const roles = {
            IT: ["Manager", "Project Manager", "Senior Developer", "Junior Developer", "Intern"],
            Finance: ["Manager", "Project Manager", "Senior Accountant", "Junior Accountant", "Intern"]
        };

        // Add new options based on selected department
        if (roles[department]) {
            roles[department].forEach(role => {
                const option = document.createElement("option");
                option.value = role;
                option.textContent = role;
                roleDropdown.appendChild(option);
            });
        }
    }

    function toggleCompanyDetails(show) {
        const container = document.getElementById("companyDetailsContainer");
        container.style.display = show ? "block" : "none";
    }

    function addAnotherCompany() {
        const companyDetails = document.getElementById("companyDetails");

        // Create a new set of fields for another company
        const newCompanyDetail = document.createElement("div");
        newCompanyDetail.classList.add("company-detail");
        newCompanyDetail.innerHTML = `
            <hr class="my-3" />
            <div class="mb-3">
                <label class="form-label">Company Name</label>
                <input class="form-control form-control-lg" type="text" name="company_name[]" placeholder="Enter company name" />
            </div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <input class="form-control form-control-lg" type="text" name="role1[]" placeholder="Enter your role" />
            </div>
            <div class="mb-3">
                <label class="form-label">Salary</label>
                <input class="form-control form-control-lg" type="number" name="salary[]" placeholder="Enter your salary" />
            </div>
            <div class="mb-3">
                <label class="form-label">Years Worked</label>
                <input class="form-control form-control-lg" type="number" name="years_worked[]" placeholder="Enter years worked" />
            </div>
        `;
        companyDetails.appendChild(newCompanyDetail);
    }
	</script>
</body>

</html>


