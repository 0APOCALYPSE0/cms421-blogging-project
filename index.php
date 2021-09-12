<?php
    require_once 'Includes/db.php';
    require 'Includes/functions.php';
    require 'Includes/sessions.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="Blog, Blogging, Travel Blog, Technology Blog, Food Blog, Fashion Blog, Science Blog, Education Blog, Movie Blog">
    <meta name="description" content="CMS Blogging is responsive website for a blogging. Blogging is about sharing your knowledge with the world. Choosing a topic that you are passionate about makes the process of starting a successful blog so much easier. Start Writing your blog from today.">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css" integrity="sha384-REHJTs1r2ErKBuJB0fCK99gCYsVjwxHrSU0N7I1zl9vZbggVJXRMsv/sLlOAGb4M" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= $cssBaseURL ?>/style.css">
    <script src="https://kit.fontawesome.com/a977020c47.js" crossorigin="anonymous"></script>
    <title>CMS Blogging</title>
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
    <!-- <header class='bg-dark text-white py-2'>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><i class="fas fa-text-height"></i> Home</h1>
                </div>
            </div>
        </div>
    </header> -->
    <!-- Header End -->

    <!-- Carousel Start -->
    <div id="demo" class="carousel slide" data-ride="carousel">

        <!-- Indicators -->
        <ul class="carousel-indicators">
          <li data-target="#demo" data-slide-to="0" class="active"></li>
          <li data-target="#demo" data-slide-to="1"></li>
          <li data-target="#demo" data-slide-to="2"></li>
        </ul>

        <!-- The slideshow -->
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="<?= $imagesBaseURL ?>/carousel3.jpg" alt="Blogging" width="100%" height="500px;">
          </div>
          <div class="carousel-item">
            <img src="<?= $imagesBaseURL ?>/carousel2.jpg" alt="Blog" width="100%" height="500">
          </div>
          <div class="carousel-item">
            <img src="<?= $imagesBaseURL ?>/carousel1.jpg" alt="Blog" width="100%" height="500">
          </div>
        </div>

        <!-- Left and right controls -->
        <a class="carousel-control-prev" href="#demo" data-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#demo" data-slide="next">
          <span class="carousel-control-next-icon"></span>
        </a>
      </div>
    <!-- Carousel End -->

    <!-- Header Start -->
    <div class="m-auto main">
        <div class="row mt-4">
            <!-- Main Area Start -->
            <div class="col-lg-8 col-md-12">
                <h1 class="display-4">Start your own blog on Blogging Lovestoblog</h1>
                <h2 class="lead">Blogging is mode of expressing your feelings</h2>
                <?php echo ErrorMessage(); echo SuccessMessage(); ?>
                <div class="jumbotron text-light" style="background-image: url('<?= $imagesBaseURL ?>/wood.jpg');">
                    <h6 class="display-4">Welcome To The CMS4.2.1 Blog.</h6>
                    <p class="lead">Blogging is about sharing your knowledge with the world. Choosing a topic that you are passionate about makes the process of starting a successful blog so much easier. Writing about more than one topic is totally fine too. As long as you are writing about things that you are genuinely interested in, your passion will shine through and keep your readers interested.</p>
                    <hr class="my-4">
                    <p>Start Writing your blog from today.</p>
                    <p class="lead">
                        <a class="btn btn-primary btn-lg" href="https://www.theblogstarter.com/" role="button">Learn more</a>
                    </p>
                </div>
                <div class="container">
                    <div class="row">
                        <h1 class="display-4 mb-4">Top Blog Stories</h1>
                    </div>
                    <div class="row">
                        <?php
                            $sql = "SELECT * FROM post";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_assoc($result)) {
                                    $PostId = $row['id'];
                                    $DateTime = $row['datetime'];
                                    $PostTitle = $row['title'];
                                    $PostSlug = $row['slug'];
                                    $Category = $row['category'];
                                    $Admin = $row['author'];
                                    $Image = $row['image'];
                                    $PostDescription = $row['post'];
                                    date_default_timezone_set("Asia/Calcutta");
                                    $currentTime = time();
                                    $date1 = $DateTime;
                                    $date2 = $currentTime;
                                    $diff = abs($date2 - strtotime($date1));
                                    $years = floor($diff / (365*60*60*24));
                                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                        ?>
                        <div class="col-md-6 col-sm-12">
                            <div class="card mb-3" style="min-height: 700px">
                                <h3 class="card-header"><?= $PostTitle; ?> </h3>
                                <div class="card-body">
                                    <h5 class="card-title">Posted By: <strong><?= $Admin; ?></strong> On <strong><?= $Category; ?></strong></h5>
                                    <h6 class="card-subtitle text-muted"><?= $DateTime; ?></h6>
                                    <img class="mt-2" style="height: 300px; width: 100%; display: block;" src="<?= $uploadBaseURL ?>/<?= $Image;?>" title="<?= $PostTitle ?>" alt="<?= $Image; ?>">
                                    <p class="card-text"><?php if(strlen($PostDescription)>200){ $PostDescription=substr($PostDescription, 0, 200).'...'; } echo $PostDescription; ?></p>
                                    <a href="<?= $serverName; ?>/post/<?= $PostSlug; ?>" class="card-link btn btn-primary">Read More >></a>
                                </div>
                                <div class="card-footer text-muted">
                                <?= $years?> years, <?= $months ?> months, <?= $days; ?> days ago
                                </div>
                            </div>
                        </div>
                        <?php
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
            <!-- Main Area End -->

            <!-- Side Area Start -->
            <div class="col-lg-4 col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <a href="https://wordpress.com/go/build/create-blog-six-steps/?currency=INR&utm_source=google&utm_campaign=google_wpcom_search_non_desktop_in_en&utm_medium=paid_search&keyword=how%20to%20start%20a%20blog&creative=329678260741&campaignid=683204350&adgroupid=58706083626&matchtype=e&device=c&network=g&targetid=kwd-398495911&gclid=Cj0KCQiAmZDxBRDIARIsABnkbYR1Ts6KmfwwNRZ8Vy6Dj7FRxzcgMWFtySWo5NT6Cb1HJNJIC8fI4H8aAovlEALw_wcB&gclsrc=aw.ds">
                            <img src="<?= $imagesBaseURL ?>/startblog.jpg" class="d-block img-fluid mb-3" alt="startblog.jpg">
                        </a>
                        <div class="text-center">Whether you want to promote your business, design a portfolio, or are looking for the perfect creative outlet, you may be wondering how to create a blog. Fortunately, starting a blog isn’t that complicated.</div>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h2 class="lead">Sign Up</h2>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-success btn-block text-center text-white mb-2" name="button">Join the Forum</button>
                        <a href="<?= $serverName; ?>/login"><button type="button" class="btn btn-danger btn-block text-center text-white mb-4" name="button">Login</button></a>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="" value="" placeholder="Enter your email">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary btn-sm text-center text-white" name="button">Subscribe Email</button>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header bg-primary text-light">
                        <h2 class="lead">Categories</h2>
                    </div>
                    <div class="card-body">
                        <?php
                            $sql = "SELECT * FROM category ORDER BY id DESC";
                            $result = mysqli_query($conn, $sql);
                            if(mysqli_num_rows($result)>0){
                                while($row = mysqli_fetch_assoc($result)){
                                    $categoryID = $row['id'];
                                    $categoryTitle = $row['title'];
                        ?>
                        <a href="<?= $serverName; ?>/category/<?= $categoryTitle; ?>/1"><span class="heading"><?= $categoryTitle; ?></span><br></a>
                        <?php
                                }
                            }
                        ?>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h2 class="lead">Recent Posts</h2>
                    </div>
                    <div class="card-body">
                        <?php
                            $sql = "SELECT * FROM post ORDER BY id DESC LIMIT 0,5";
                            $result = mysqli_query($conn, $sql);
                            if(mysqli_num_rows($result)>0){
                                while($row = mysqli_fetch_assoc($result)){
                                    $postID = $row['id'];
                                    $postSlug = $row['slug'];
                                    $postTitle = $row['title'];
                                    $datetime = $row['datetime'];
                                    $image = $row['image'];
                        ?>
                        <div class="media">
                            <img src="<?= $uploadBaseURL ?>/<?= $image; ?>" class="d-block img-fluid align-self-start" width="94px;" height="94px;" title="<?= $postTitle; ?>" alt="<?= $image; ?>">
                            <div class="media-body ml-2">
                                <a href="<?= $serverName; ?>/post/<?= $postSlug; ?>" target="_blank"><h6 class="lead"><?= $postTitle; ?></h6></a>
                                <p class="small"><?= $datetime; ?></p>
                            </div>
                        </div>
                        <hr>
                        <?php
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
            <!-- Side Area End -->
        </div>
    </div>
    <!-- Header End -->

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

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        $('#year').text(new Date().getFullYear());
    </script>
</body>
</html>