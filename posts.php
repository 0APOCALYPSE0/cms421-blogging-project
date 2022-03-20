<?php
    require_once 'Includes/db.php';
    require 'Includes/functions.php';
    require 'Includes/sessions.php';
    $_SESSION['trackingURL'] = $_SERVER["PHP_SELF"].'?page=1';
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
                        <a href="<?= $serverName; ?>/admin?page=1" class="nav-link">Manage Admins</a>
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
                    <h1><i class="fas fa-blog"></i> Blog Posts</h1>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="<?= $serverName; ?>/addnewpost" class='btn btn-primary btn-block'><i class='fas fa-edit'></i> Add New Post</a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="<?= $serverName; ?>/categories" class='btn btn-info btn-block'><i class='fas fa-folder-plus'></i> Add New Category</a>
                </div>
                <?php if($_SESSION['permission'] == 'Superuser'){ ?>
                <div class="col-lg-3 mb-2">
                    <a href="<?= $serverName; ?>/admin" class='btn btn-warning btn-block'><i class='fas fa-user-plus'></i> Add New Admin</a>
                </div>
                <?php } ?>
                <?php if($_SESSION['permission'] != 'User'){ ?>
                <div class="col-lg-3 mb-2">
                    <a href="<?= $serverName; ?>/comments" class='btn btn-success btn-block'><i class='fas fa-check'></i> Approve Comments</a>
                </div>
                <?php } ?>
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
                    <tbody>
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
                        if($_SESSION['permission'] == 'User'){
                            $user_id = $_SESSION['userID'];
                            $sql = "SELECT * FROM post WHERE user_id='$user_id' LIMIT $showPostFrom,5";
                        }else{
                            $sql = "SELECT * FROM post LIMIT $showPostFrom,5";
                        }
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
                            <td><img src="<?= $uploadBaseURL; ?>/<?= $Image; ?>" alt="<?= $Image; ?>" width='170px;' height='50px;' style="object-fit: cover;" ></td>
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
                    <?php
                            }
                        }else{
                            echo "<tr><td colspan='10' class='text-danger text-center'>No Post Available</td></tr>";
                        }
                    ?>
                    </tbody>
                </table>
                <!-- Pagination Start  -->
                <nav>
                    <ul class="pagination pagination-link">
                        <!-- Backward Button Start -->
                        <?php
                            if(isset($page)){
                                if($page>1){
                        ?>
                        <li class="page-item">
                            <a href="<?= $serverName; ?>/post?page=<?= $page-1; ?>" class="page-link">&laquo;</a>
                        </li>
                        <?php
                                }
                            }
                        ?>
                        <!-- Backward Button End -->
                        <?php
                            if(isset($page)){
                                if($_SESSION['permission'] == 'User'){
                                    $user_id = $_SESSION['userID'];
                                    $sql = "SELECT * FROM post WHERE user_id='$user_id'";
                                }else{
                                    $sql = "SELECT * FROM post";
                                }
                                $result = mysqli_query($conn, $sql);
                                $totalPost = mysqli_num_rows($result);
                                $postPagination = ceil($totalPost/5);
                                for($i=1; $i<=$postPagination; $i++){
                                    if($i == $page){
                        ?>
                        <li class="page-item active">
                            <a href="<?= $serverName; ?>/post?page=<?= $i; ?>" class="page-link"><?= $i; ?></a>
                        </li>
                        <?php
                                    }else{
                        ?>
                        <li class="page-item">
                            <a href="<?= $serverName; ?>/post?page=<?= $i; ?>" class="page-link"><?= $i; ?></a>
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
                            <a href="<?= $serverName; ?>/post?page=<?= $page+1; ?>" class="page-link">&raquo;</a>
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