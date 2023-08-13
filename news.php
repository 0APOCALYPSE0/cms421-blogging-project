<?php
    require_once 'Includes/db.php';
    require 'Includes/functions.php';
    require 'Includes/sessions.php';
    require_once(__DIR__."/vendor/autoload.php");
    require_once(__DIR__."/vendor/fabpot/goutte/Goutte/Client.php");
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
    <title>News</title>
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
                        <a href="<?= $serverName; ?>/news" class="nav-link">News</a>
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
                <h1 class="px-3">Latest Popular News</h1>
                <?php echo ErrorMessage(); echo SuccessMessage(); ?>
                <?php
                    use Goutte\Client;
                    $client = new Client();

                    $url = "https://inshorts.com/en/read";
                    $crawler = $client->request('GET', $url);

                    $crawler->filter('div[itemtype="http://schema.org/NewsArticle"]')->each(function ($node) {
                      $title = $node->filter('span[itemprop="headline"]')->text();
                      $image = $node->filter('[itemprop="url"]')->attr('content');
                      $description = $node->filter('div[itemprop="articleBody"]')->html();
                      $sourceUrl = $node->filter('div > a')->last();
                      if($sourceUrl->count() > 0){
                        $url = $sourceUrl->attr('href');
                        $source = $sourceUrl->text();
                      }
                ?>
                <div class="card my-2 shadow">
                  <div class="row">
                    <div class="col-sm-4">
                      <img src="<?= htmlentities($image); ?>" title="<?= $title; ?>" alt="<?= $image; ?>" class='shadow card-img-top' height='268px;' width="320px">
                    </div>
                    <div class="col-sm-8">
                      <div class="card-body">
                          <h5 class="card-title"><?= htmlentities($title); ?></h5>
                          <hr>
                          <p class="card-text">
                          <?php
                              if(strlen($description)>150){ $description; }
                              echo $description;
                          ?>
                          </p>
                          <?php
                            if(isset($url)){
                          ?>
                          Read more at <a href="<?= $url ?>"><?= $source ?></a>
                          <?php
                            }
                          ?>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                  });
                ?>
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
                        <a href="<?= $serverName; ?>/signup"><button type="button" class="btn btn-success btn-block text-center text-white mb-2" name="button">Sign Up</button></a>
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