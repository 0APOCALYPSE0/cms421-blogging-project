<?php
    require_once 'Includes/db.php';
    require 'Includes/functions.php';
    require 'Includes/sessions.php';

    $searchQryParam = $_GET['id'];
    if(isset($_POST['Submit'])){
        $name = $_POST['commenterName'];
        $email = $_POST['commenterEmail'];
        $comment = $_POST['commenterThoughts'];
        $postIdFromURL = $searchQryParam;
        date_default_timezone_set("Asia/Calcutta");
        $currentTime = time();
        $dateTime = strftime("%e %b %y %H:%M:%S", $currentTime);

        if(empty($name) || empty($email) || empty($comment)){
            $_SESSION['ErrorMessage'] = 'All fields must be filled out.';
            Redirect_To("fullpost.php?id={$searchQryParam}");
        }elseif(strlen($comment)>500){
            $_SESSION['ErrorMessage'] = 'Comment length should be less than 500 character.';
            Redirect_To("fullpost.php?id={$searchQryParam}");
        }else{
            $sql = "INSERT INTO comments(datetime, name, email, comment, approvedby, status, post_id) VALUES(?, ?, ?, ?, 'Pending', 'OFF', ?);";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $dateTime, $name, $email, $comment, $searchQryParam);
            $execute = $stmt->execute();
            $last_id = $conn->insert_id;
            // $sql = "INSERT INTO category(title, author, datetime)";
            // $sql .= "VALUES(:categoryName, :adminName, :datetime);";
            // $stmt = $conn->prepare($sql);

            // $stmt->bindValue(':categoryName', $category);
            // $stmt->bindValue(':adminName', $admin);
            // $stmt->bindValue(':datetime', $dateTime);
            // $execute = $stmt->execute();
            if($execute){
                $_SESSION['SuccessMessage'] = "Comment Added Successfully.";
                Redirect_To("fullpost.php?id={$searchQryParam}");
            }else{
                $_SESSION['ErrorMessage'] = "Something went wrong. Try Again.";
                Redirect_To("fullpost.php?id={$searchQryParam}");
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css" integrity="sha384-REHJTs1r2ErKBuJB0fCK99gCYsVjwxHrSU0N7I1zl9vZbggVJXRMsv/sLlOAGb4M" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <title>Blog Page</title>
</head>
<body>
    <div style="height: 10px; background-color: #27aae1;"></div>
    <!-- Navbar  -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand">CMS Blogging</a>
            <button class="navbar-toggler" data-toggle='collapse' data-target='#navbarcollapseCMS'>
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapseCMS">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="about.php" class="nav-link">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="blog.php" class="nav-link"> Blogs</a>
                    </li>
                    <li class="nav-item">
                        <a href="contact.php" class="nav-link">Contact Us</a>
                    </li>
                </ul>
                <?php
                    if(isset($_SESSION['userID'])){
                ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link"><i class='fas fa-user-times'></i> Log Out</a>
                    </li>
                </ul>
                <?php
                    }
                ?>
                <ul class="navbar-nav ml-auto">
                    <form action="blog.php" class="form-inline d-none d-sm-block">
                        <div class="form-group">
                            <input type="text" class="form-control mr-2" name='search' id='search' placeholder='Serach here...'>
                            <button name='searchButton' class="btn btn-primary">Go</button>
                        </div>
                    </form>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->
    <div style="height: 10px; background-color: #27aae1;"></div>

    <!-- Header Start -->
    <div class="main m-auto">
        <div class="row mt-4">
            <!-- Main Area Start -->
            <div class="col-lg-8 col-md-12">
                <h1>The Complete responsive CMS Blog</h1>
                <h1 class="lead">The Complete blog by using php</h1>
                <?php echo ErrorMessage(); echo SuccessMessage(); ?>
                <?php
                    if(isset($_GET['searchButton'])){
                        $search = $_GET['search'];
                        $sql = "SELECT * FROM post WHERE datetime LIKE '%$search%' OR title LIKE '%$search%' OR category LIKE '%$search%' OR post LIKE '%$search%'";
                    }else{
                        $PostIDFromURL = $_GET['id'];
                        if(!isset($PostIDFromURL)){
                            $_SESSION['ErrorMessage'] = "Bad Request !";
                            Redirect_To('blog.php');
                        }
                        $sql = "SELECT * FROM post Where id='$PostIDFromURL'";
                    }
                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result)!=1){
                        $_SESSION['ErrorMessage'] = "Bad Request!";
                        Redirect_To("blog.php?page=1");
                    }
                    if (mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)) {
                            $PostId = $row['id'];
                            $DateTime = $row['datetime'];
                            $PostTitle = $row['title'];
                            $Category = $row['category'];
                            $Admin = $row['author'];
                            $Image = $row['image'];
                            $PostDescription = $row['post'];
                ?>
                <div class="card">
                    <img src="Upload/<?= htmlentities($Image); ?>" alt="<?= $Image; ?>" class='img-fluid card-img-top' max-height='450px;'>
                    <div class="card-body">
                        <h4 class="card-title"><?= htmlentities($PostTitle); ?></h4>
                        <small class='text-muted'>Category: <span class="text-dark"><a href="blog.php?category=<?= $Category; ?>"><?= $Category; ?></a></span> & Written By <span class="text-dark"><a href="profile.php?username=<?= $Admin; ?>"><?= htmlentities($Admin); ?></a></span> On <span class="text-dark"><?= htmlentities($DateTime); ?></span></small>
                        <span style="float:right;" class="badge badge-dark text-light">Comments <?= approvedCommentsAccordingToPost($PostId); ?></span>
                        <hr>
                        <p class="card-text">
                        <?php echo nl2br($PostDescription); ?>
                        </p>
                    </div>
                </div>
                <?php
                        }
                    }
                ?>
                <!-- Comment Start -->
                <!-- Fetching Existing Comments Start -->
                <br>
                <span class="fieldInfo">Comments</span>
                <br><br>
                <?php
                    $sql = "SELECT * FROM comments WHERE post_id = '$searchQryParam' AND status='ON'";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)) {
                            $commentDate = $row['datetime'];
                            $commenterName = $row['name'];
                            $commentContent = $row['comment'];
                ?>
                <div>
                    <div class="media commentBlock">
                            <img class="d-block img-fluid align-self-start" src="Images/comment.png" alt="">
                        <div class="media-body ml-2">
                            <h6 class="lead"><?= $commenterName; ?></h6>
                            <p class="small"><?= $commentDate; ?></p>
                            <p><?= $commentContent; ?></p>
                        </div>
                    </div>
                </div>
                <hr>
                <?php
                        }
                    }

                ?>
                <!-- Fetching Existing Comments End -->
                <div class=''>
                    <form action="fullpost.php?id=<?= $searchQryParam; ?>" method="post">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="fieldInfo">Share your thoughts about this post.</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" name='commenterName' class="form-control" placeholder="Name" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="email" name='commenterEmail' class="form-control" placeholder="Email" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <textarea name="commenterThoughts" cols="80" rows="10" class="form-control"></textarea>
                                </div>
                                <div>
                                    <button type="submit" name="Submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Comment End -->
            </div>
            <!-- Main Area End -->

            <!-- Side Area Start -->
            <div class="col-lg-4 col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <img src="Images/startblog.jpg" class="d-block img-fluid mb-3" alt="startblog.jpg">
                        <div class="text-center">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quasi nobis ab magni, maxime assumenda asperiores magnam illo pariatur ipsam dolorem porro, saepe voluptatum, aut facere ullam totam perspiciatis aliquam! Cum.</div>
                    </div>
                </div>
                <br>
                <?php
                    if(!isset($_SESSION['userID'])){
                ?>
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h2 class="lead">Sign Up</h2>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-success btn-block text-center text-white mb-2" name="button">Join the Forum</button>
                        <a href="login.php"><button type="button" class="btn btn-danger btn-block text-center text-white mb-4" name="button">Login</button></a>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="" value="" placeholder="Enter your email">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary btn-sm text-center text-white" name="button">Subscribe Email</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                ?>
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
                        <a href="blog.php?category=<?= $categoryTitle; ?>"><span class="heading"><?= $categoryTitle; ?></span><br></a>
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
                                    $postTitle = $row['title'];
                                    $datetime = $row['datetime'];
                                    $image = $row['image'];
                        ?>
                        <div class="media">
                            <img src="Upload/<?= $image; ?>" class="d-block img-fluid align-self-start" width="94px;" height="94px;" alt="<?= $image; ?>">
                            <div class="media-body ml-2">
                                <a href="fullpost.php?id=<?= $postID; ?>" target="_blank"><h6 class="lead"><?= $postTitle; ?></h6></a>
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
    <br>
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