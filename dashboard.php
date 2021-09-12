<?php
    require_once 'Includes/db.php';
    require 'Includes/functions.php';
    require 'Includes/sessions.php';
    $_SESSION['trackingURL'] = $_SERVER["PHP_SELF"];
    confirmLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css" integrity="sha384-REHJTs1r2ErKBuJB0fCK99gCYsVjwxHrSU0N7I1zl9vZbggVJXRMsv/sLlOAGb4M" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= $cssBaseURL ?>/style.css">
    <title>Dashboard</title>
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
                        <a href="<?= $serverName; ?>/dashboard" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $serverName; ?>/posts" class="nav-link">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $serverName; ?>/categories" class="nav-link">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $serverName; ?>/admin" class="nav-link">Manage Admins</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $serverName; ?>/comments" class="nav-link">Comments</a>
                    </li>
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
                    <h1><i class="fas fa-cog"></i> Dashboard</h1>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="<?= $serverName; ?>/addnewpost" class='btn btn-primary btn-block'><i class='fas fa-edit'></i> Add New Post</a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="<?= $serverName; ?>/categories" class='btn btn-info btn-block'><i class='fas fa-folder-plus'></i> Add New Category</a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="<?= $serverName; ?>/admin" class='btn btn-warning btn-block'><i class='fas fa-user-plus'></i> Add New Admin</a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="<?= $serverName; ?>/comments" class='btn btn-success btn-block'><i class='fas fa-check'></i> Approve Comments</a>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Main Area Start -->
    <section class="container py-2 mb-4">
        <?php echo ErrorMessage(); echo SuccessMessage(); ?>
        <div class="row">
            <!-- Left Side Area Start  -->
            <div class="col-lg-2 d-none d-md-block">
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Posts</h1>
                        <h4 class="display-5"><i class="fab fa-readme"></i>
                            <?php
                                echo totalPosts();
                            ?>
                        </h4>
                    </div>
                </div>
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Categories</h1>
                        <h4 class="display-5"><i class="fas fa-folder"></i>
                            <?php
                                echo totalCategories();
                            ?>
                        </h4>
                    </div>
                </div>
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Admins</h1>
                        <h4 class="display-5"><i class="fas fa-users"></i>
                            <?php
                                echo totalAdmins();
                            ?>
                        </h4>
                    </div>
                </div>
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Comments</h1>
                        <h4 class="display-5"><i class="fas fa-comments"></i>
                            <?php
                                echo totalComments();
                            ?>
                        </h4>
                    </div>
                </div>
            </div>
            <!-- Left Side Area End -->
            <!-- Right Side Area Start -->
            <div class="col-lg-10">
                <h1>Top Posts</h1>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Title</th>
                            <th>Date & Time</th>
                            <th>Author</th>
                            <th>Comments</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <?php
                        $sql = "SELECT * FROM post ORDER BY id DESC LIMIT 0,5";
                        $result = mysqli_query($conn, $sql);
                        $sr=0;
                        if (mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                $sr++;
                                $PostId = $row['id'];
                                $PostSlug = $row['slug'];
                                $datetime = $row['datetime'];
                                $Author = $row['author'];
                                $Title = $row['title'];
                    ?>
                    <tbody>
                        <tr>
                            <td><?= $sr; ?></td>
                            <td><?= $Title; ?></td>
                            <td><?= $datetime; ?></td>
                            <td><?= $Author; ?></td>
                            <td>
                                <span class="badge badge-success">
                                    <?php echo approvedCommentsAccordingToPost($PostId); ?>
                                </span>
                                <span class="badge badge-danger">
                                    <?php echo disapprovedCommentsAccordingToPost($PostId); ?>
                                </span>
                            </td>
                            <td>
                                <a target="_blank" href="<?= $serverName; ?>/post/<?= $PostSlug; ?>"><span class="btn btn-info">Preview</span></a>
                            </td>
                        </tr>
                    </tbody>
                    <?php
                           }
                       }
                    ?>
                </table>
            </div>
            <!-- Right Side Area End -->
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