<?php
session_start();
include 'db.php';

// Fetch all users from the database
$query = "SELECT users.email, users.name, users.phone_number, jobs.role, jobs.department, jobs.date_of_joining, users.status 
          FROM users 
          JOIN jobs ON users.email = jobs.email"; // Assuming there's a foreign key relationship
$result = mysqli_query($conn, $query);

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

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>AdminKit Demo - Bootstrap 5 Admin Template</title>

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

	<style>
.switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: red;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:checked + .slider:before {
            transform: translateX(16px);
        }

        .status-container {
            display: inline-block;
            align-items: center;
            gap: 10px;
        }
        /* Cards Animation */
.card-animation {
    animation: slideInUp 1s ease-out;
}

/* Keyframe for table fade-in effect */
@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Keyframe for card slide-in effect */
@keyframes slideInUp {
    0% {
        opacity: 0;
        transform: translateY(30px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}
table {
    border-collapse: collapse;
    caption-side: bottom;
    width: fit-content;
}

tbody,td,tfoot,th,tr {
    border: 0 solid;
    border-color: inherit;
}

	.table thead th {
    text-align: center;
    background-color: #222E3C; /* Change header color to blue */
    color: white; /* Change text color to white for contrast */
}
/* Style for table cells */
.table td {
    vertical-align: middle;
}

/* Style for the avatar and name cell */
.table td:first-child {
    display: flex;
    align-items: center;
    gap: 10px;
}

.table td:first-child img {
    min-width: 48px;
    height: 48px;
    object-fit: cover;
}

.wrapper {
    width: 100%;
    min-height: 100vh;
    display: flex;
}

.main {
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    width: 100%;
    overflow-x: hidden;
}

.content {
    flex: 1;
    padding: 1.5rem;
    overflow-y: auto;
    overflow-x: hidden;
    width: 100%;
}

.container-fluid {
    max-width: 100%;
    padding: 1rem;
    overflow-x: hidden;
}

.table-responsive {
    margin-top: 1rem;
    overflow-x: auto;
    padding: 0;
    border-radius: 0.5rem;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.card .card-body {
    height: 300px;
}

.table {
    margin-bottom: 0;
    white-space: normal;
}

.table-container {
            height: 650px; /* Adjust height as needed */
            overflow-y: scroll;
			position: relative;
        }
        .table-container table {
            width: 100%;
			border-collapse: collapse;
        }
		.table-container thead th {
            position: sticky;
            top: 0;
            background-color: #222E3C;
            z-index: 1;
		}

/* Make table columns more responsive */
.table th,
.table td {
    white-space: nowrap;
    word-wrap: break-word;
    min-width: auto;
    max-width: none;
}

.table th:nth-child(1) { width: 100px; }
.table th:nth-child(2) { width: 100px; }
.table th:nth-child(3) { width: 80px; }
.table th:nth-child(4) { width: 100px; }
.table th:nth-child(5) { width: 120px; }
.table th:nth-child(6) { width: 180px; }
.table th:nth-child(7) { width: 100px; }
.table th:nth-child(8) { width: 120px; }
.table th:nth-child(9) { width: 80px; }

td .edit, td .delete-btn {
    display: inline-block;
    margin: 0 5px;
}

td:last-child {
    text-align: center;
    }
    
.container-fluid {
    max-width: 100%;
        padding: 1rem;
    }
    
.card {
    margin-bottom: 1rem;
    border-radius: 0.5rem;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

	</style>
</head>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="admin.php">
          <span class="align-middle">Hr-Mate Admin</span>
        </a>

				<ul class="sidebar-nav">
					<li class="sidebar-header">
					<b>Menu's</b>
					</li>

					<li class="sidebar-item active">
						<a class="sidebar-link" href="admin.php">
              <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
            </a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link " data-bs-toggle="collapse" data-bs-target="#companyDetails" aria-expanded="false">
              <i class="align-middle" data-feather="home"></i> <span class="align-middle">Add Company Details</span>
            </a>
			<div id="companyDetails" class="collapse">
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="general-information.php">
					<i class="align-middle" data-feather="plus-square"></i> <span class="align-middle">General Information</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="contact-details.php">
					<i class="align-middle" data-feather="help-circle"></i><span class="align-middle">Contact Details</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="organization-setup.php">
					<i class="align-middle" data-feather="layers"></i> <span class="align-middle">Organization Setup</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="policy.php">
					<i class="align-middle" data-feather="paperclip"></i> <span class="align-middle">Company Policy</span>
                    </a>
                </li>
            </ul>
        </div>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="sign-up.php">
              <i class="align-middle" data-feather="user-plus"></i> <span class="align-middle">Sign Up</span>
            </a>
					</li>
				</ul>
			</div>
		</nav>
		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
          <i class="hamburger align-self-center"></i>
        </a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
								<div class="position-relative">
									<i class="align-middle" data-feather="bell"></i>
									<span class="indicator">4</span>
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
								<div class="dropdown-menu-header">
									4 New Notifications
								</div>
								<div class="list-group">
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-danger" data-feather="alert-circle"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Update completed</div>
												<div class="text-muted small mt-1">Restart server 12 to complete the update.</div>
												<div class="text-muted small mt-1">30m ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-warning" data-feather="bell"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Lorem ipsum</div>
												<div class="text-muted small mt-1">Aliquam ex eros, imperdiet vulputate hendrerit et.</div>
												<div class="text-muted small mt-1">2h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-primary" data-feather="home"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Login from 192.186.1.8</div>
												<div class="text-muted small mt-1">5h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-success" data-feather="user-plus"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">New connection</div>
												<div class="text-muted small mt-1">Christina accepted your request.</div>
												<div class="text-muted small mt-1">14h ago</div>
											</div>
										</div>
									</a>
								</div>
								<div class="dropdown-menu-footer">
									<a href="#" class="text-muted">Show all notifications</a>
								</div>
							</div>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown" data-bs-toggle="dropdown">
								<div class="position-relative">
									<i class="align-middle" data-feather="message-square"></i>
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="messagesDropdown">
								<div class="dropdown-menu-header">
									4 New Messages
								</div>
								<div class="list-group">
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<img src="img/avatars/avatar-5.jpg" class="avatar img-fluid rounded-circle" alt="Vanessa Tucker">
											</div>
											<div class="col-10 ps-2">
												<div class="text-dark">Vanessa Tucker</div>
												<div class="text-muted small mt-1">Nam pretium turpis et arcu. Duis arcu tortor.</div>
												<div class="text-muted small mt-1">15m ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<img src="img/avatars/avatar-2.jpg" class="avatar img-fluid rounded-circle" alt="William Harris">
											</div>
											<div class="col-10 ps-2">
												<div class="text-dark">William Harris</div>
												<div class="text-muted small mt-1">Curabitur ligula sapien euismod vitae.</div>
												<div class="text-muted small mt-1">2h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<img src="img/avatars/avatar-4.jpg" class="avatar img-fluid rounded-circle" alt="Christina Mason">
											</div>
											<div class="col-10 ps-2">
												<div class="text-dark">Christina Mason</div>
												<div class="text-muted small mt-1">Pellentesque auctor neque nec urna.</div>
												<div class="text-muted small mt-1">4h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<img src="img/avatars/avatar-3.jpg" class="avatar img-fluid rounded-circle" alt="Sharon Lessman">
											</div>
											<div class="col-10 ps-2">
												<div class="text-dark">Sharon Lessman</div>
												<div class="text-muted small mt-1">Aenean tellus metus, bibendum sed, posuere ac, mattis non.</div>
												<div class="text-muted small mt-1">5h ago</div>
											</div>
										</div>
									</a>
								</div>
								<div class="dropdown-menu-footer">
									<a href="#" class="text-muted">Show all messages</a>
								</div>
							</div>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                <i class="align-middle" data-feather="settings"></i>
              </a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                <img src="img/avatars/avatar.jpg" class="avatar img-fluid rounded me-1" alt="Charles Hall" /> <span class="text-dark">Charles Hall</span>
              </a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="pages-profile.html"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
								<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i> Analytics</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="index.html"><i class="align-middle me-1" data-feather="settings"></i> Settings & Privacy</a>
								<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#">Log out</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>

	<div class="main">
		<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3"><strong>List of Employee's</strong></h1>
					<div class = "table-responsive table-container">
					<div class="row">
						<div class="col-12">
							<table class="table table-striped table-hover table-bordered">
								<thead>
									<tr>
										<th>Name <i class="align-middle" data-feather="user"></i></th>
										<th>Email <i class="align-middle" data-feather="mail"></i></th>
										<th>Contact <i class="align-middle" data-feather="phone-call"></i></th>
										<th>Department <i class="align-middle" data-feather="git-pull-request"></i></th>
										<th>Role <i class="align-middle" data-feather="git-merge"></i></th>
										<th>DOJ <i class="align-middle" data-feather="calendar"></i></th>
										<th>Status <i class="align-middle" data-feather="check-square"></i></th>
										<th>Action <i class="align-middle" data-feather="settings"></i></th>
									</tr>
								</thead>
								<tbody>
								<?php while($row = mysqli_fetch_assoc($result)): ?>
									<tr>
										<td>
											<img src="img/avatars/avatar-3.jpg" width="48" height="48" class="rounded-circle me-2" alt="Avatar"><?php echo htmlspecialchars($row['name']); ?>
										</td>
										<td><?php echo htmlspecialchars($row['email']); ?></td>
										<td><?php echo htmlspecialchars($row['phone_number']); ?></td>
										<td><?php echo htmlspecialchars($row['department']); ?></td>
										<td><?php echo htmlspecialchars($row['role']); ?></td>
										<td><?php echo htmlspecialchars($row['date_of_joining']); ?></td>
										<td>
											<div class="status-container">
												<label class="switch">
													<input type="checkbox" 
														   onchange="updateStatus(this, '<?php echo $row['email']; ?>')"
														   <?php echo ($row['status'] == 'Approved') ? 'checked' : ''; ?>>
													<span class="slider"></span>
												</label>
												<span class="status-text">
													<?php 
													$status = $row['status'] ?? 'Pending';
													echo $status; 
													?>
												</span>
											</div>
										</td>
										<td>
											<a href=""><i class="edit" data-feather="edit"></i></a>
											<a href="delete.php?email=<?php echo urlencode($row['email']); ?>" onclick="return confirmDelete('<?php echo $row['email']; ?>')" class="delete-btn"><i data-feather="trash"></i></a>
										</td>
									</tr>
								<?php endwhile; ?>
								</tbody>
							</table>
						</div>
					</div>
					</div>

					<?php
					// Fetch data for charts
					$charts_data = [
						'dept' => ['query' => "SELECT department, COUNT(*) as count FROM jobs GROUP BY department"],
						'role' => ['query' => "SELECT role, COUNT(*) as count FROM jobs GROUP BY role"],
						'status' => ['query' => "SELECT status, COUNT(*) as count FROM users GROUP BY status"]
					];

					foreach ($charts_data as $key => &$data) {
						$result = mysqli_query($conn, $data['query']);
						$data['labels'] = [];
						$data['values'] = [];
						while ($row = mysqli_fetch_assoc($result)) {
							$data['labels'][] = $row[array_key_first($row)];
							$data['values'][] = $row['count'];
						}
					}
					?>

					<div class="row mt-4">
						<div class="col-md-4">
							<div class="card">
								<div class="card-header">
									<h5 class="card-title">Department Distribution</h5>
								</div>
								<div class="card-body">
									<canvas id="doughnutChart1"></canvas>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card">
								<div class="card-header">
									<h5 class="card-title">Role Distribution</h5>
								</div>
								<div class="card-body">
									<canvas id="doughnutChart2"></canvas>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card">
								<div class="card-header">
									<h5 class="card-title">Status Distribution</h5>
								</div>
								<div class="card-body">
									<canvas id="doughnutChart3"></canvas>
								</div>
							</div>
						</div>
					</div>

					<script>
					document.addEventListener("DOMContentLoaded", function() {
						const chartConfigs = [
							{
								id: 'doughnutChart1',
								labels: <?php echo json_encode($charts_data['dept']['labels']); ?>,
								data: <?php echo json_encode($charts_data['dept']['values']); ?>,
								colors: [window.theme.primary, window.theme.success, window.theme.warning, window.theme.info]
							},
							{
								id: 'doughnutChart2',
								labels: <?php echo json_encode($charts_data['role']['labels']); ?>,
								data: <?php echo json_encode($charts_data['role']['values']); ?>,
								colors: [window.theme.primary, window.theme.success, window.theme.warning, window.theme.info]
							},
							{
								id: 'doughnutChart3',
								labels: <?php echo json_encode($charts_data['status']['labels']); ?>,
								data: <?php echo json_encode($charts_data['status']['values']); ?>,
								colors: [window.theme.success, window.theme.warning, window.theme.danger, window.theme.primary]
							}
						];

						chartConfigs.forEach(config => {
							new Chart(document.getElementById(config.id), {
								type: "doughnut",
								data: {
									labels: config.labels,
									datasets: [{
										data: config.data,
										backgroundColor: config.colors,
										borderColor: "transparent"
									}]
								},
								options: {
									maintainAspectRatio: false,
									cutoutPercentage: 65,
									legend: {
										display: true,
										position: 'bottom'
									},
									tooltips: {
										callbacks: {
											label: function(tooltipItem, data) {
												const total = data.datasets[0].data.reduce((a, b) => a + b, 0);
												const value = data.datasets[0].data[tooltipItem.index];
												const percentage = Math.round((value/total) * 100);
												return `${data.labels[tooltipItem.index]}: ${value} (${percentage}%)`;
											}
										}
									}
								}
							});
						});
					});
					</script>

    </div>
			</main>
		</div>
	</div>
	<script src="js/app.js"></script>
    <script src="js/sidebar-active.js"></script>
    <script src="js/content-loader.js"></script>

	<script>
function confirmDelete(email) {
    if (confirm('Are you sure you want to delete?')) {
        window.location.href = 'delete.php?email=' + encodeURIComponent(email);
    }
    return false;
}
</script>

<script>
    function updateStatus(checkbox, email) {
        const status = checkbox.checked ? 'Approved' : 'Pending';
        const statusText = checkbox.closest('.status-container').querySelector('.status-text');
        
        fetch('update_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `email=${email}&status=${status}`
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // Update the status text dynamically
                statusText.textContent = status;
                console.log('Status updated successfully');
            } else {
                console.error('Failed to update status');
                // Revert checkbox if update fails
                checkbox.checked = !checkbox.checked;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Revert checkbox if there's an error
            checkbox.checked = !checkbox.checked;
        });
    }
    </script>

</body>

</html>