<?php
    require_once 'Includes/db.php';
    require 'Includes/functions.php';
    require 'Includes/sessions.php';
    $category = "";
    if(isset($_GET['category'])){
        $category = $_GET['category'];
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
    <meta name="description" content="<?= $category; ?> Blog">
    <meta name="keywords" content="<?= $category; ?>">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= $cssBaseURL ?>/style.css">
    <title><?= $category; ?>Blogs</title>
    <style>
        .heading{
            font-family: Bitter, Georgia, "Times New Roman", Times, serif;
            font-weight: bold;
            color: #005E90;
        }
        .heading:hover{
            color: #0090DB;
        }
    </style>
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
                        <a href="<?= $serverName; ?>/index" class="nav-link">Home</a>
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
                <?php
                    if(isset($_SESSION['userID'])){
                ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="<?= $serverName; ?>/logout" class="nav-link"><i class='fas fa-user-times'></i> Log Out</a>
                    </li>
                </ul>
                <?php
                    }
                ?>
                <ul class="navbar-nav ml-auto">
                    <form action="<?= $serverName; ?>/blog" class="form-inline d-none d-sm-block">
                        <div class="form-group">
                            <input type="text" class="form-control mr-2" name='search' id='search' placeholder='Serach here...'>
                            <button name="searchButton" class="btn btn-primary" type="submit">Go</button>
                        </div>
                    </form>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->
    <div style="height: 10px; background-color: #27aae1;"></div>

    <!-- Header Start -->
    <div class="main m-auto container-fluid">
        <div class="row mt-4">
            <!-- Main Area Start -->
            <div class="col-lg-8 col-md-12">
                <h1 class="px-3">Latest Popular Blogs <?= $category != '' ? 'on '.$category : ''; ?></h1>
                <?php echo ErrorMessage(); echo SuccessMessage(); ?>
                <?php
                    $showPostFrom = 0;
                    if(isset($_GET['page'])){
                        $page = $_GET['page'];
                        if($page === 0 || $page <= 1){
                            $showPostFrom = 0;
                        }else{
                            $showPostFrom = ($page*5)-5;
                        }
                    }
                    if(isset($_GET['searchButton'])){
                        $search = $_GET['search'];
                        $sql = "SELECT * FROM post WHERE status='publish' AND (datetime LIKE '%$search%' OR title LIKE '%$search%' OR category LIKE '%$search%' OR post LIKE '%$search%') ORDER BY id DESC LIMIT $showPostFrom,5";
                    }
                    // elseif(isset($_GET['page'])){
                    //     $page = $_GET['page'];
                    //     if($page === 0 || $page < 1){
                    //         $showPostFrom = 0;
                    //     }else{
                    //         $showPostFrom = ($page*5)-5;
                    //     }
                    //     $sql = "SELECT * FROM post ORDER BY id DESC LIMIT $showPostFrom,5";
                    // }
                    elseif(isset($_GET['category'])){
                        $category = $_GET['category'];
                        $sql = "SELECT * FROM post WHERE category='$category' AND status='publish' ORDER BY id DESC LIMIT $showPostFrom,5";
                    }else{
                        $sql = "SELECT * FROM post WHERE status='publish' ORDER BY id DESC LIMIT $showPostFrom,5";
                    }
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)) {
                            $PostId = $row['id'];
                            $PostSlug = $row['slug'];
                            $PostTags = $row['tags'];
                            $DateTime = $row['datetime'];
                            $PostTitle = $row['title'];
                            $Category = $row['category'];
                            $Admin = $row['author'];
                            $Image = $row['image'];
                            $PostDescription = $row['post'];
                ?>
                <div class="card my-2 shadow">
                    <img src="<?= $uploadBaseURL ?>/<?= htmlentities($Image); ?>" title="<?= $PostTitle; ?>" alt="<?= $Image; ?>" class='shadow img-fluid card-img-top' max-height='450px;'>
                    <div class="card-body">
                        <h4 class="card-title"><?= htmlentities($PostTitle); ?></h4>
                        <small class='text-muted'>Category: <span class="text-dark"><a href="<?= $serverName; ?>/category/<?= $Category; ?>/1"><?= $Category; ?></a></span> & Written By <span class="text-dark"><a href="<?= $serverName; ?>/profile/<?= $Admin; ?>"><?= htmlentities($Admin); ?></a></span> On <span class="text-dark"><?= htmlentities($DateTime); ?></span></small>
                        <?php
                            if(strlen($PostTags) != 0){
                        ?>
                            <div class="my-1">
                                <span><i class="fas fa-tags"></i> <?= $PostTags; ?></span>
                            </div>
                        <?php } ?>
                        <span style="float:right;" class="badge badge-dark text-light">Comments <?= approvedCommentsAccordingToPost($PostId); ?></span>
                        <hr>
                        <p class="card-text">
                        <?php
                            if(strlen($PostDescription)>150){ $PostDescription=substr($PostDescription, 0, 150).'...'; }
                            echo $PostDescription;
                        ?>
                        </p>
                        <a href="<?= $serverName; ?>/post/<?= $PostSlug; ?>" style="float:right;"><span class='btn btn-info'>Read More >></span></a>
                    </div>
                </div>
                <?php
                        }
                    }else{
                        echo "<h4 class='text-danger text-center my-5'>No Post Found</h4>";
                    }
                ?>
                <br>
                <!-- Pagination Start  -->
                <nav>
                    <ul class="pagination pagination-link">
                        <!-- Backward Button Start -->
                        <?php
                            if(isset($page)){
                                if($page>1){
                        ?>
                        <li class="page-item">
                            <a href="<?= $serverName; ?>/blog/<?= $page-1; ?>" class="page-link">&laquo;</a>
                        </li>
                        <?php
                                }
                            }
                        ?>
                        <!-- Backward Button End -->
                        <?php
                            if(isset($page)){
                                $sql = "SELECT * FROM post";
                                $result = mysqli_query($conn, $sql);
                                $totalPost = mysqli_num_rows($result);
                                $postPagination = ceil($totalPost/5);
                                for($i=1; $i<=$postPagination; $i++){
                                    if($i == $page){
                        ?>
                        <li class="page-item active">
                            <a href="<?= $serverName; ?>/blog/<?= $i; ?>" class="page-link"><?= $i; ?></a>
                        </li>
                        <?php
                                    }else{
                        ?>
                        <li class="page-item">
                            <a href="<?= $serverName; ?>/blog/<?= $i; ?>" class="page-link"><?= $i; ?></a>
                        </li>
                        <?php
                                    }
                                }
                            }
                        ?>
                        <!-- Forward Button Start -->
                        <?php
                            if(isset($page) && !empty($page)){
                                if($page+1 <= $postPagination){
                        ?>
                        <li class="page-item">
                            <a href="<?= $serverName; ?>/blog/<?= $page+1; ?>" class="page-link">&raquo;</a>
                        </li>
                        <?php
                                }
                            }
                        ?>
                        <!-- Forward Button End -->
                    </ul>
                </nav>
                <!-- Pagination End -->
           </div>
            <!-- Main Area End -->

            <!-- Side Area Start -->
            <div class="col-lg-4 col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <img src="<?= $imagesBaseURL ?>/startblog.jpg" class="d-block img-fluid mb-3" alt="startblog.jpg">
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
                        <a href="<?= $serverName; ?>/login"><button type="button" class="btn btn-danger btn-block text-center text-white mb-4" name="button">Login</button></a>
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
                            $sql = "SELECT * FROM post WHERE status='publish' ORDER BY id DESC LIMIT 0,5";
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