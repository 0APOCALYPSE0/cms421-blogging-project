<?php
    require 'Includes/db.php';
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
    <title>Comments</title>
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
                    <h1><i class="fas fa-comments"></i> Manage Comments</h1>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->
    <!-- Main Area Start -->
    <section class="container py-2 mb-4">
        <div class="row" style="min-height:30px;">
            <div class="col-lg-12" style="min-height:400px;">
                <?php echo ErrorMessage(); echo SuccessMessage(); ?>
                <h2>Un-Approved Comments</h2>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Date & Time</th>
                            <th>Name</th>
                            <th>Comment</th>
                            <th>Approve</th>
                            <th>Action</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <?php
                        $sql = "SELECT * FROM comments WHERE status='OFF' ORDER BY id DESC";
                        $result = mysqli_query($conn, $sql);
                        $sr = 0;
                        if (mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)) {
                                $sr++;
                                $CommentId = $row['id'];
                                $DateTime = $row['datetime'];
                                $CommenterName = $row['name'];
                                $CommentContent = $row['comment'];
                                $CommentPostID = $row['post_id'];
                                // if(strlen($CommenterName)>10){ $CommenterName = substr($CommenterName,0,10).'...'; }
                                // if(strlen($DateTime)>11){ $DateTime = substr($DateTime,0,11).'...'; }
                                $sqlForSlug = "SELECT slug from post WHERE id = '$CommentPostID'";
                                $resultForSlug = mysqli_query($conn, $sqlForSlug);
                                if (mysqli_num_rows($resultForSlug) > 0){
                                    $row = mysqli_fetch_assoc($resultForSlug);
                                    $PostSlug = $row['slug'];
                                }
                    ?>
                    <tbody>
                        <tr>
                            <td><?= $sr; ?></td>
                            <td><?= $DateTime; ?></td>
                            <td><?= $CommenterName; ?></td>
                            <td><?= $CommentContent; ?></td>
                            <td style="min-width:140px;"><a class="btn btn-success" href="<?= $serverName; ?>/approvecomment?id=<?= $CommentId; ?>">Approve</a></td>
                            <td><a class="btn btn-danger" href="<?= $serverName; ?>/deletecomment?id=<?= $CommentId; ?>">Delete</a></td>
                            <td style="min-width:140px;"><a class="btn btn-primary" href="<?= $serverName; ?>/post/<?= $PostSlug; ?>">Live Preview</a></td>
                        </tr>
                    </tbody>
                    <?php
                            }
                        }
                    ?>
                </table>
                <h2>Approved Comments</h2>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Date & Time</th>
                            <th>Name</th>
                            <th>Comment</th>
                            <th>Revert</th>
                            <th>Action</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <?php
                        $sql = "SELECT * FROM comments WHERE status='ON' ORDER BY id DESC";
                        $result = mysqli_query($conn, $sql);
                        $sr = 0;
                        if (mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)) {
                                $sr++;
                                $CommentId = $row['id'];
                                $DateTime = $row['datetime'];
                                $CommenterName = $row['name'];
                                $CommentContent = $row['comment'];
                                $CommentPostID = $row['post_id'];
                                $sqlForSlug = "SELECT slug from post WHERE id = '$CommentPostID'";
                                $resultForSlug = mysqli_query($conn, $sqlForSlug);
                                if (mysqli_num_rows($resultForSlug) > 0){
                                    $row = mysqli_fetch_assoc($resultForSlug);
                                    $PostSlug = $row['slug'];
                                }
                                // if(strlen($CommenterName)>10){ $CommenterName = substr($CommenterName,0,10).'...'; }
                                // if(strlen($DateTime)>11){ $DateTime = substr($DateTime,0,11).'...'; }
                    ?>
                    <tbody>
                        <tr>
                            <td><?= $sr; ?></td>
                            <td><?= $DateTime; ?></td>
                            <td><?= $CommenterName; ?></td>
                            <td><?= $CommentContent; ?></td>
                            <td style="min-width:140px;"><a class="btn btn-warning" href="<?= $serverName; ?>/disapprovecomment?id=<?= $CommentId; ?>">Dis-Approve</a></td>
                            <td><a class="btn btn-danger" href="<?= $serverName; ?>/deletecomment?id=<?= $CommentId; ?>">Delete</a></td>
                            <td style="min-width:140px;"><a class="btn btn-primary" href="<?= $serverName; ?>/post/<?= $PostSlug; ?>">Live Preview</a></td>
                        </tr>
                    </tbody>
                    <?php
                            }
                        }
                    ?>
                </table>
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