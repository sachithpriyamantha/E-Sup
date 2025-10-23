<?php
session_start();
?>
<?php
include 'config.php';


if (isset($_SESSION['msd_supplier_name'])) {
  header("Location: dashboard.php");
}
if (isset($_POST['submit'])) {

  $msd_supplier_name = $_POST["msd_supplier_name"];
  $tsql = "SELECT msd_supplier_code,msd_mobileno,msd_supplier_name
  FROM mms_supplier_pending_details";
  $stmt = mysqli_query($con, $tsql);
  if ($stmt->num_rows > 0) {
    $user = mysqli_fetch_array($stmt);

    $_SESSION["msd_supplier_name"] = $msd_supplier_name;
    header("Location: dashboard.php");
  } else {
    // echo "<script>alert('Invalid User.')</script>";
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    .buttonload {
      background-color: white;
      /* Green background */
      border: none;
      /* Remove borders */
      color: black;
      /* White text */
      padding: 12px 24px;
      /* Some padding */
      font-size: 16px;
      /* Set a font-size */
    }

    /* Add a right margin to each icon */
    .fa {
      margin-left: -12px;
      margin-right: 8px;
    }

    input,
    input::placeholder {
      font: 17px/3 sans-serif;
    }
  </style>

  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="shortcut icon" href="./static/img/9.png" />
  <link rel="stylesheet" href="./static/css/login.css" />


  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <!-- <script src="./static/js/jquery-3.3.1.min.js"></script> -->
  <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>

  <script src="./static/js/jquery.validate.min.js"></script>
  <script src="./static/js/jquery.validate.unobtrusive.min.js"></script>

  <title>eSupplier-CDPLC</title>

  <!-- insert function -->
  <script>
    $(document).ready(function() {
      $('#insertbtn').click(function(e) {
        e.preventDefault();
        $.ajax({
          type: "post",
          url: "supRegistration.php",
          data: $('#insertsup').serialize(),
          dataType: "text",
          success: function(response) {
            $('#messagedisplay').html(data);
          },

          success: function(data) {
            $('#messagedisplay').html(data);
          },
        })
      })
    });
  </script>

</head>

<body>

  <div class="container">

    <div class="forms-container">
      <div class="signin-signup">
        <form id="frm-mobile-verification" style="padding-top: 50px; justify-content: center;" class="sign-in-form">
          <!-- <center><img src="img/2.svg" style="height: 60px; width: 100%;"  alt=""></center>  -->
          <img class="mb-4" src="static/img/9.png" width="50%" alt="">
          <br>
          <h2 class="title">Sign in</h2>
          <div class="input-field">
            <i class="fas fa-phone-alt"></i>
            <input type="number" id="mobile" placeholder="Mobile Number" maxlength="10" />
          </div>
          <div class="error" style="color: red; font-weight: bold;"></div>

          <div class="form-group first">
          </div>
          <!-- Loader Button -->

          <button class="buttonload" id="loadbutton" style="display:none;" disabled>
            <i class="fa fa-spinner fa-spin"></i>Loading! Please Wait....
          </button>

          <!-- Login buttons - both buttons needed  -->
          <input id="submit" type="button" name="submit" class="" onclick="sendOTP();" style="visibility: hidden; height: 1px;" />
          <input value="Login" class="btn btnSubmit solid" type="button" name="submit" id="submit" onclick="sendOTP();"  />
          


        </form>

        <?php
        include 'supRegistration.php';
        ?>

        <form id="insertsup" method="post" class="sign-up-form">
          <img class="mb-4" src="static/img/9.png" width="20%" alt="">
          <h2 class="title">Register</h2>
          <b>
            <p id="messagedisplay"></p>
          </b>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Supplier Name" name="supname" id="supname" required />
          </div>
          <p class="note" style="color:red">* Please make sure that supplier name is same as BR name.</p>

          <div class="input-field mb-3">
            <i class="fas fa-list"></i>
            <select class="form-select" name="supcat" id="supcat" required>
              <option selected value="RI">Ration Items</option>
            </select>
          </div>
          <div class="input-field">
            <i class="fas fa-list"></i>
            <input type="textarea" placeholder="Category Description" name="description" id="description" required />
          </div>
          <div class="input-field">
            <i class="fas fa-map-marker"></i>
            <input type="text" placeholder="Address" name="address" id="address" required />
          </div>
          <div class="input-field">
            <i class="fas fa-phone-alt"></i>
            <input type="tel" placeholder="0778978987" name="mobile" id="mobile1" pattern="[0]{1}[7]{1}[0-9]{8}" required />
          </div>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder="Email Address" name="email" id="email" required />
          </div>

          <div class="form-group ">
            <div class="g-recaptcha" data-sitekey="6LeyhpcgAAAAAAwsDOsKlWMVpwvmorC6sJ6oLNRz"></div>
          </div>
          <input type="submit" name="insertbtn" id="insertbtn" class="btn" value="Register" />
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <img class="mb-5 pb-4" src="static/img/dockyardlogo.png" width="50%" alt="">
          <br>
          <p>
            Please use this LOGIN-IN to place a tender and select the categories as required to proceed !!!
          </p>
          <button class="btn transparent" id="sign-up-btn">
            Register
          </button>
        </div>
        <img src="./static/img/loginimage.svg" class="image" alt="" />
      </div>
      <div class="panel right-panel">
        <div class="content">
          <img class="mb-5 pb-4" src="static/img/dockyardlogo.png" width="50%" alt="">
          <h3>Register to SIGN-In</h3>
          <p>
            If you have an account please use SIGN-IN to login and proceed the tender
          </p>
          <button class="btn transparent" id="sign-in-btn">
            Login
          </button>
        </div>
        <img src="./static/img/registrationNew.svg" class="image" alt="" />
      </div>
    </div>
  </div>


  <script>
    $("#mobile1").attr("maxlength", 10);
  </script>

  <script src="./static/js/login.js"></script>
  <script src="./static/js/showhideelement.js"></script>
  <script src="js/verification.js"></script>

</body>

</html>