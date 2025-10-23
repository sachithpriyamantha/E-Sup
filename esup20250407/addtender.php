<?php
session_start();

// if (!isset($_SESSION['mobile_number']) || !isset($_SESSION['name']) || !isset($_SESSION['entry'])) {
// 	header('Location: admin.php');
// 	exit();
// }
// include 'config.php';
// $entry = $_SESSION['entry'];
// if ($entry == 'N') {
// 	$ButtonsDisabled = true;
// } else {
// 	$ButtonsDisabled = false;
// }
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {

// 	if (isset($_POST['insertbtn'])) {
// 		$separator = "-Week";
// 		// $week = "week";
// 		$year = $_POST['year'];
// 		$sdate = $_POST['sdate'];
// 		$edate = $_POST['edate'];
// 		$mtd_bidclose_date = $_POST['bidclosedate'];

// 		$mtd_bidclose_date_obj = new DateTime($mtd_bidclose_date);
// 		date_default_timezone_set('Asia/Colombo');
// 		// Format the date and time in the desired format
// 		$formatted_closetime = $mtd_bidclose_date_obj->format('Y-m-d g:i A');

// 		// $createdby = $_SESSION["sup_code"];
// 		$createdby = $_SESSION['name'];
// 		$createddate = date('Y-m-d');

// 		//$selQuery = "SELECT TOP 1 mtd_tender_no FROM mms_tender_details WHERE mtd_year='$year' ORDER BY mtd_tender_no DESC";
// 		$selQuery = "SELECT  mtd_tender_no FROM mms_tender_details WHERE mtd_year='$year' ORDER BY mtd_tender_no DESC LIMIT 1";
// 		$query_run = mysqli_query($con, $selQuery);
// 		if (!$query_run) {
// 			echo "Error:";
// 			// echo json_encode(mysqli_error($con));
// 			// die;
// 			die("database error:" . mysqli_error($con));
// 		}
// 		$row = mysqli_fetch_array($query_run, MYSQLI_ASSOC);
// 		$suffix = 0;

// 		if ($row && $row["mtd_tender_no"]) {
// 			// UPDATE last tender in same year status to I(Inactive)

// 			$explode = explode($separator, $row["mtd_tender_no"]);
// 			$suffix = count($explode) > 1 ? $explode[1] : 0;
// 		}
// 		$query = "UPDATE mms_tender_details SET mtd_status='I'";
// 		$query_run = mysqli_query($con, $query);

// 		$tno = $year . $separator . ($suffix + 1);
// 		// var_dump($tno);
// 		// die();
// 		$query = "INSERT INTO mms_tender_details (mtd_year,mtd_tender_no,mtd_start_date,mtd_end_date,mtd_bidclose_date,mtd_status,created_by,created_date) 
// 		VALUES ('$year','$tno', '$sdate',' $edate','$formatted_closetime','A','$createdby','$createddate')";
// 		$query_run = mysqli_query($con, $query);

// 		if ($query_run) {
// 			echo "<script>alert('Records Saved Successfully!!'); </script>";
// 		} else {
// 			echo "<script>alert('ERROR!'); </script>";
// 			echo json_encode(mysqli_error($con));
// 			die;
// 		}
// 	}
// }
// 

if (!isset($_SESSION['mobile_number']) || !isset($_SESSION['name']) || !isset($_SESSION['entry'])) {
	header('Location: admin.php');
	exit();
}

include 'config.php';

$entry = $_SESSION['entry'];

$ButtonsDisabled = ($entry == 'N');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (isset($_POST['insertbtn'])) {
		$separator = "-Week";
		$year = $_POST['year'];
		$sdate = $_POST['sdate'];
		$edate = $_POST['edate'];
		$mtd_bidclose_date = $_POST['bidclosedate'];

		$mtd_bidclose_date_obj = new DateTime($mtd_bidclose_date);
		date_default_timezone_set('Asia/Colombo');
		$formatted_closetime = $mtd_bidclose_date_obj->format('Y-m-d g:i A');

		$createdby = $_SESSION['name'];
		$createddate = date('Y-m-d');

		$selQuery = "SELECT MAX(CAST(SUBSTRING_INDEX(mtd_tender_no, '-Week', -1) AS UNSIGNED)) AS max_week 
					 FROM mms_tender_details 
					 WHERE mtd_year = '$year'";
		$query_run = mysqli_query($con, $selQuery);

		if (!$query_run) {
			die("Database error while getting max week: " . mysqli_error($con));
		}

		$row = mysqli_fetch_array($query_run, MYSQLI_ASSOC);
		$suffix = $row && $row["max_week"] ? (int)$row["max_week"] : 0;

		// Generate new tender number
		$tno = $year . $separator . ($suffix + 1);

		// Update all existing tenders to Inactive
		$query = "UPDATE mms_tender_details SET mtd_status='I' WHERE mtd_year='$year'";
		$query_run = mysqli_query($con, $query);

		// Insert new tender
		$query = "INSERT INTO mms_tender_details 
					(mtd_year, mtd_tender_no, mtd_start_date, mtd_end_date, mtd_bidclose_date, mtd_status, created_by, created_date) 
				  VALUES 
					('$year', '$tno', '$sdate', '$edate', '$formatted_closetime', 'A', '$createdby', '$createddate')";
		$query_run = mysqli_query($con, $query);

		if ($query_run) {
			echo "<script>alert('Records Saved Successfully!!');</script>";
		} else {
			echo "<script>alert('ERROR!');</script>";
			echo json_encode(mysqli_error($con));
			die;
		}
	}
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="./static/img/2.svg" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>eSupplier-CDL</title>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css" crossorigin="anonymous" />

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<link href="./static/css/app.css" rel="stylesheet">
	<link href="./static/css/main.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">


	<script src="./static/js/jquery-3.3.1.min.js"></script>
	<script src="./static/js/jquery.validate.min.js"></script>
	<script src="./static/js/jquery.validate.unobtrusive.min.js"></script>

	<script src="./static/js/app.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>



</head>

<body>

	<div class="wrapper">
		<?php include './Admin_components/adminsidenav.php' ?>
		<div class="main">
			<?php include './Admin_components/adminnavbar.php' ?>
			<!-- dashboard content -->
			<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">
						<strong>
							eSupplier Add Tender
						</strong>
					</h1>
					<form form id="tender" name="tender" method="POST">
						<div class="form-group">
							<label for="exampleFormControlInput1">Year</label>
							<!-- <input type="number" class="form-control" name="year" id="year" placeholder="Year" required> -->

							<select class="form-control" name="year">
								<option value="2023" selected>2023</option>
								<option value="2024">2024</option>
								<option value="2025">2025</option>
								<option value="2026">2026</option>
								<option value="2027">2027</option>
								<option value="2028">2028</option>
								<option value="2029">2029</option>
								<option value="2030">2030</option>
							</select>

						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Start Date</label>
							<input type="date" class="form-control" name="sdate" id="sdate" required>
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">End Date</label>
							<input type="date" class="form-control" name="edate" id="edate" required>
						</div>

						<div class="form-group">
							<label for="exampleFormControlInput1">Bid Closing Date</label>
							<input type="datetime-local" class="form-control" name="bidclosedate" id="bidclosedate" required>
						</div>

						<div class="modal-footer">
							<a href="tenderview.php">
								<button type="button" class="btn btn-primary">Back</button>
							</a>
							<button type="submit" name="insertbtn" id="insertbtn" class="btn btn-success" <?php if ($ButtonsDisabled) echo 'disabled'; ?>>Save changes </button>
						</div>

					</form>
				</div>
			</main>
			<?php include './components/footer.php' ?>
		</div>
	</div>

	<script>
		function logoutfunction() {
			alert("Please Confirm To Logout!!");
		}
	</script>
</body>

</html>