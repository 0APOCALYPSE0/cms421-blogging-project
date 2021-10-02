<?php
    require 'Includes/db.php';
    require 'Includes/functions.php';
    require 'Includes/sessions.php';
    $_SESSION['trackingURL'] = $_SERVER["PHP_SELF"];
    confirmLogin();

    $AdminId = $_SESSION['userID'];
    $sql = "SELECT * FROM admins WHERE id='$AdminId'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)){
        while($row = mysqli_fetch_assoc($result)){
            $existingName = $row['aname'];
            $existingHeadline = $row['headline'];
            $existingBio = $row['bio'];
            $existingImage = $row['image'];
            $existingUsername = $row['username'];
        }
    }
    if(isset($_POST['submit'])){
        $AdminName = $_POST['name'];
        $headline = $_POST['headline'];
        $image = $_FILES['image']['name'];
        $bio = $_POST['bio'];
        $target = "<?= $imagesBaseURL; ?>/".basename($_FILES['image']['name']);

        if(strlen($headline)>30){
            $_SESSION['ErrorMessage'] = 'Headline should be less than 30 characters.';
            Redirect_To($serverName."/myprofile");
        }elseif(strlen($bio)>499){
            $_SESSION['ErrorMessage'] = 'Bio should be less than 500 character.';
            Redirect_To($serverName."/myprofile");
        }else{
            if(!empty($_FILES['image']['name'])){
                $sql = "UPDATE admins SET aname='$AdminName', headline='$headline', image='$image', bio='$bio' WHERE id='$AdminId' ";
            }else{
                $sql = "UPDATE admins SET aname='$AdminName', headline='$headline', bio='$bio' WHERE id='$AdminId' ";
            }
            $execute = mysqli_query($conn, $sql);
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
            // $sql = "INSERT INTO category(title, author, datetime)";
            // $sql .= "VALUES(:categoryName, :adminName, :datetime);";
            // $stmt = $conn->prepare($sql);

            // $stmt->bindValue(':categoryName', $category);
            // $stmt->bindValue(':adminName', $admin);
            // $stmt->bindValue(':datetime', $dateTime);
            // $execute = $stmt->execute();
            if($execute){
                $_SESSION['SuccessMessage'] = "Profile Updated Successfully.";
                Redirect_To($serverName."/myprofile");
            }else{
                $_SESSION['ErrorMessage'] = "Something went wrong. Try Again.";
                Redirect_To($serverName."/myprofile");
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= $cssBaseURL ?>/style.css">
    <title>My Profile</title>
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
                    <li class="nav-item">
                        <a href="<?= $serverName; ?>/myprofile" class="nav-link"> <i class='fas fa-user'></i>My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $serverName; ?>/dashboard?page=1" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $serverName; ?>/posts?page=1" class="nav-link">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $serverName; ?>/categories?page=1" class="nav-link">Categories</a>
                    </li>
                    <?php if($_SESSION['permission'] == 'Superuser'){ ?>
                    <li class="nav-item">
                        <a href="<?= $serverName; ?>/admin" class="nav-link">Manage Admins</a>
                    </li>
                    <?php } ?>
                    <?php if($_SESSION['permission'] != 'User'){ ?>
                    <li class="nav-item">
                        <a href="<?= $serverName; ?>/comments" class="nav-link">Comments</a>
                    </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a href="<?= $serverName; ?>/blog/1" class="nav-link">Live Blog</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="<?= $serverName; ?>/logout" class="nav-link"><i class='fas fa-user-times'></i> Log Out</a>
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
                    <h1><i class='fas fa-user' style="color: #27aae1;"></i>  @<?= $existingUsername; ?></h1>
                    <small><?= $existingHeadline; ?></small>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Main Area Start -->
    <section class="container py-2 mb-4">
        <div class="row">
            <!-- Left Area Start -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h3><?= $existingName; ?></h3>
                    </div>
                    <div class="card-body">
                        <img src="<?= $imagesBaseURL; ?>/<?= ($existingImage != '')? $existingImage : "profile.jpg"; ?>" alt="<?= $existingImage; ?>" class="block img-fluid mb-3">
                        <div><?= $existingBio; ?></div>
                    </div>
                </div>
            </div>
            <!-- Left Area End -->
            <!-- Right Area Start -->
            <div class="col-md-9" style="min-height: 400px;">
                <?php echo ErrorMessage(); echo SuccessMessage(); ?>
                <form action="<?= $serverName; ?>/myprofile" method='post' enctype="multipart/form-data">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-header bg-secondary text-light">
                            <h4>Edit Profile</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <input type="text" name='name' class="form-control" placeholder='Enter your name'>
                            </div>
                            <div class="form-group">
                                <input type="text" name='headline' class="form-control" placeholder='Enter your headline'>
                                <small class="text-muted">Add a Professional Headline</small>
                                <span class="text-danger">Not more than 30 character.</span>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="bio" cols="80" rows="10" placeholder="Bio"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="imageSelect"><span class="fieldInfo">Select Image</span></label>
                                <div class="custom-file">
                                    <input class="custom-file-input" type="file" name='image' id='imageSelect' value=''>
                                    <label for="imageSelect" class="custom-file-label">Select Image</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="<?= $serverName; ?>/dashboard" class='btn btn-warning btn-block'><i class='fas fa-arrow-left'></i> Back To Dashboard</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button class='btn btn-success btn-block' type='submit' name='submit'><i class='fas fa-check'></i> Publish</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Right Area End -->
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