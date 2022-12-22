<?php

	$error = false;

	if (isset($_GET['id']) && is_numeric($_GET['id'])) {
		$id =  $_GET['id'];

		$sql = "SELECT * FROM tbl_admin WHERE id = ? LIMIT 1";
		$stmt = $connect->prepare($sql);
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($id, $username, $password, $email, $full_name, $role);
		$stmt->fetch();

	} else {
		die('404 Oops!!!');
	}

	$error = false;
	/**
	 * Update Command
	 */
	if (isset($_POST['btnEdit'])) {

		$newusername   	= $_POST['username'];
		$newfullname    = $_POST['full_name'];
		$newpassword   	= trim($_POST['password']);
		$newrepassword 	= trim($_POST['repassword']);
		$newemail 		= $_POST['email'];
        //$newrole  = $_POST['role'] ? : '102';
		$newrole  		= $_POST['role'];

		if (strlen($newusername) < 3) {
			$error[] = 'Username is too short!';
		}

		if (empty($newfullname)) {
			$error[] = 'Full name can not be empty!';
		}

		if (empty($newpassword)) {
			$error[] = 'Password can not be empty!';
		}

		if ($newpassword != $newrepassword) {
			$error[] = 'Password does not match!';
		}

		//$newpassword = hash('sha256', $newusername.$newpassword);

		if (filter_var($newemail, FILTER_VALIDATE_EMAIL) === FALSE) {
			$error[] = 'Email is not valid!';
		}

		if (! $error) {
			$sql = "UPDATE tbl_admin SET username = ?,
			 							password = ?,
			 							email = ?,
			 							full_name = ?,
			 							user_role = ?
			 						WHERE
			 							id = ?";
			$update = $connect->prepare($sql);
			$update->bind_param(
				'sssssi',
				$newusername,
				$newpassword,
				$newemail,
				$newfullname,
				$newrole,
				$id
			);

			$update->execute();

			$succes =<<<EOF
			<script>
			alert('Update Profile Success');
			window.location = 'edit-profile.php?id=$id';
			</script>

EOF;
			echo $succes;
		}
	}

?>

<div id="content" class="pmd-content content-area dashboard">
	<div class="container-fluid full-width-container">
		<h1></h1>
			
		<ol class="breadcrumb text-left">
		  <li><a href="dashboard.php">Dashboard</a></li>
		  <li class="active">Edit Profile</li>
		</ol>
	
		<div class="section"> 

			<form id="validationForm" method="post" enctype="multipart/form-data">
			<div class="pmd-card pmd-z-depth">
				<div class="pmd-card-body">

					<div class="group-fields clearfix row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="lead">EDIT PROFILE</div>
							<?php echo $error ? '<div class="alert alert-warning">'. implode('<br>', $error) . '</div>' : '';?>
						</div>
					</div>

					<div class="group-fields clearfix row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group pmd-textfield pmd-textfield-floating-label">
								<label for="username" class="control-label">
									Username
								</label>
								<input type="text" name="username" id="username" class="form-control" value="<?php echo $username; ?>" required>
							</div>
						</div>
					</div>

					<div class="group-fields clearfix row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group pmd-textfield pmd-textfield-floating-label">
								<label for="full_name" class="control-label">
									Full Name
								</label>
								<input type="text" name="full_name" id="full_name" class="form-control" value="<?php echo $full_name; ?>" required>
							</div>
						</div>
					</div>

					<div class="group-fields clearfix row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group pmd-textfield pmd-textfield-floating-label">
								<label for="email" class="control-label">
									Email
								</label>
								<input type="text" name="email" id="email" class="form-control" value="<?php echo $email; ?>" required>
							</div>
						</div>
					</div>

					<div class="group-fields clearfix row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group pmd-textfield pmd-textfield-floating-label">
								<label for="password" class="control-label">
									Password
								</label>
								<input type="password" name="password" id="password" class="form-control" required>
							</div>
						</div>
					</div>

					<div class="group-fields clearfix row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group pmd-textfield pmd-textfield-floating-label">
								<label for="repassword" class="control-label">
									Re Password
								</label>
								<input type="password" name="repassword" id="repassword" class="form-control" required>
							</div>
						</div>
					</div>

					<input type="hidden" name="role" id="role" value="<?php echo $role; ?>" />

				</div>

				<div class="pmd-card-actions">
					<p align="right">
					<button type="submit" class="btn pmd-ripple-effect btn-danger" name="btnEdit">Update</button>
					</p>
				</div>
			</div>
			</form>
		</div>
			
	</div>

</div>