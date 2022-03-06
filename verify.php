<?php
  require_once 'Includes/db.php';
  require 'Includes/functions.php';
  require 'Includes/sessions.php';

  if(!isset($_SESSION['sessionId'])){
    Redirect_To($serverName."/login");
  }

  $errorMessage = "";

  if(!empty($_POST["authenticate"]) && $_POST["otp"]!='') {
    echo "hello";
    $sqlQuery = "SELECT * FROM authentication WHERE otp='". $_POST["otp"]."' AND expired!=1 AND NOW() <= DATE_ADD(created, INTERVAL 1 HOUR)";
    $result = mysqli_query($conn, $sqlQuery);
    $count = mysqli_num_rows($result);
    if(!empty($count)) {
      $sqlUpdate = "UPDATE authentication SET expired = 1 WHERE otp = '" . $_POST["otp"] . "'";
      $result = mysqli_query($conn, $sqlUpdate);

      $_SESSION['userID'] = $_SESSION["sessionId"];
      $_SESSION['SuccessMessage'] = "Welcome ".$_SESSION['adminName'];

      if(isset($_SESSION['trackingURL'])){
        Redirect_To($_SESSION['trackingURL']);
      }else{
        Redirect_To($serverName."/dashboard?page=1");
      }
    } else {
      $_SESSION['ErrorMessage'] = "Invalid OTP!";
    }
  } else if(!empty($_POST["otp"])){
    $_SESSION['ErrorMessage'] = "Enter OTP!";
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-G3QB45L9DK"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-G3QB45L9DK');
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= $cssBaseURL ?>/style.css">
    <title>Verify OTP</title>
</head>
<body>
    <div style="height: 10px; background-color: #27aae1;"></div>
    <!-- Navbar  -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="<?= $serverName; ?>/index" class="navbar-brand">CMS Blogging</a>
            <button class="navbar-toggler" data-toggle='collapse' data-target='#navbarcollapseCMS'>
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapseCMS">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a href="<?= $serverName; ?>/index" class="nav-link">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $serverName; ?>/about" class="nav-link">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $serverName; ?>/blog/1" class="nav-link">Blogs</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $serverName; ?>/contact" class="nav-link">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->
    <div style="height: 10px; background-color: #27aae1;"></div>

    <!-- Header Start -->
    <header class='bg-dark text-white py-2'>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Main Area Start -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-sm-3 col-sm-6" style="min-height: 500px;">
                <br><br><br>
                <?php echo ErrorMessage(); ?>
                <div class="card bg-secondary text-ligh">
                    <div class="card-header">
                        <h4>Enter OTP</h4>
                    </div>
                    <div class="card-body bg-dark">
                        <form action="<?= $serverName; ?>/verify" method="post">
                            <div class="form-group">
                                <label for="otp"><span class="fieldInfo">Check your email for OTP:</span></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-white bg-info"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="text" name="otp" id="otp" class="form-control">
                                </div>
                            </div>
                            <input type="submit" name="authenticate" class="btn btn-success btn-block" value="Submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Main Area End -->

    <!-- Footer Start -->
    <footer class="bg-dark text-white py-1">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="lead text-center small">CMS Blog By | Aakash | <span id='year'></span> &copy; All Right Reseverd.</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer End -->
    <div style="height: 10px; background-color: #27aae1;"></div>

    <script src="https://kit.fontawesome.com/a977020c47.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script>
        $('#year').text(new Date().getFullYear());
    </script>
</body>
</html>