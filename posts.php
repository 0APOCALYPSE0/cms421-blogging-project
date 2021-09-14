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
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= $cssBaseURL ?>/style.css">
    <title>Posts</title>
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
                    <h1><i class="fas fa-blog"></i> Blog Posts</h1>
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
        <div class="row">
            <div class="col-lg-12">
                <?php echo ErrorMessage(); echo SuccessMessage(); ?>
                <table class='table table-striped table-hover'>
                    <thead class='thead-dark'>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date&TIme</th>
                            <th>Author</th>
                            <th>Banner</th>
                            <th>Comments</th>
                            <th>Action</th>
                            <th>Status</th>
                            <th>Live Preview</th>
                        </tr>
                    </thead>
                    <?php
                        $sql = "SELECT * FROM post";
                        $result = mysqli_query($conn, $sql);
                        $sr = 0;
                        if (mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)) {
                                $sr++;
                                $Id = $row['id'];
                                $PostSlug = $row['slug'];
                                $DateTime = $row['datetime'];
                                $PostTitle = $row['title'];
                                $Category = $row['category'];
                                $Admin = $row['author'];
                                $Image = $row['image'];
                                $PostDescription = $row['post'];
                                $PostStatus = $row['status'];
                    ?>
                    <tbody>
                        <tr>
                            <td><?= $sr ?></td>
                            <td>
                                <?php
                                if(strlen($PostTitle)>20){ $PostTitle=substr($PostTitle, 0, 18).'...'; }
                                echo $PostTitle;
                                ?>
                            </td>
                            <td>
                            <?php
                                if(strlen($Category)>8){ $Category=substr($Category, 0, 8).'...'; }
                                echo $Category;
                                ?>
                            </td>
                            <td>
                            <?php
                                if(strlen($DateTime)>11){ $DateTime=substr($DateTime, 0, 11).'...'; }
                                echo $DateTime;
                                ?>
                            </td>
                            <td>
                            <?php
                                if(strlen($Admin)>8){ $Admin=substr($Admin, 0, 8).'...'; }
                                echo $Admin;
                                ?>
                            </td>
                            <td><img src="<?= $uploadBaseURL; ?>/<?= $Image; ?>" alt="<?= $Image; ?>" width='170px;' height='50px;'></td>
                            <td>
                                <span class="badge badge-success">
                                    <?php echo approvedCommentsAccordingToPost($Id); ?>
                                </span>
                                <span class="badge badge-danger">
                                    <?php echo disapprovedCommentsAccordingToPost($Id); ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= $serverName; ?>/editpost?id=<?= $Id; ?>"><span class='btn btn-sm btn-warning mb-2'><i class="far fa-edit" ></i></span></a>
                                <a href="<?= $serverName; ?>/deletepost?id=<?= $Id; ?>"><span class='btn btn-sm btn-danger mb-2'><i class="fas fa-trash-alt"></i></span></a>
                            </td>
                            <td class="text-center"><a href="<?= $serverName; ?>/togglestatus.php?id=<?= $Id; ?>&status=<?= $PostStatus; ?>"><i class="fad fa-2x fa-toggle-<?= $PostStatus == 'publish' ? 'on' : 'off'; ?> text-<?= $PostStatus == 'publish' ? 'success' : 'danger'; ?>"></i></a></td>
                            <td><a href="<?= $serverName; ?>/post/<?= $PostSlug; ?>" target='_blank'><span class='btn btn-sm btn-primary'>Live Preview</span></a></td>
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