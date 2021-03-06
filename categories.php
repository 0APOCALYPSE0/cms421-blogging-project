<?php
    require 'Includes/db.php';
    require 'Includes/functions.php';
    require 'Includes/sessions.php';
    $_SESSION['trackingURL'] = $_SERVER["PHP_SELF"];
    confirmLogin();

    if(isset($_POST['submit'])){
        $category = $_POST['categoryTitle'];
        $admin = $_SESSION['username'];
        date_default_timezone_set("Asia/Calcutta");
        $currentTime = time();
        $dateTime = strftime("%e %b %y %H:%M:%S", $currentTime);

        if(empty($category)){
            $_SESSION['ErrorMessage'] = 'All fields must be filled out.';
            Redirect_To($serverName."/categories");
        }elseif(strlen($category)<3){
            $_SESSION['ErrorMessage'] = 'Category title should be greater than 2 character.';
            Redirect_To($serverName."/categories");
        }elseif(strlen($category)>49){
            $_SESSION['ErrorMessage'] = 'Category title should be less than 50 character.';
            Redirect_To($serverName."/categories");
        }else{
            $sql = "INSERT INTO category(title, author, datetime) VALUES(?, ?, ?);";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $category, $admin, $dateTime);
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
                $_SESSION['SuccessMessage'] = "Category with ID: $last_id Added Successfully.";
                Redirect_To($serverName."/categories");
            }else{
                $_SESSION['ErrorMessage'] = "Something went wrong. Try Again.";
                Redirect_To($serverName."/categories");
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
    <title>Categories</title>
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
                    <h1><i class='fas fa-edit' style="color: #27aae1;"></i>  Manage Categories</h1>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Main Area Start -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-lg-1 col-lg-10" style="min-height: 400px;">
            <?php echo ErrorMessage(); echo SuccessMessage(); ?>
                <form action="<?= $serverName; ?>/categories" method='post'>
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-header">
                            <h1>Add New Category</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"><span class="fieldInfo">Category Title</span></label>
                                <input type="text" name='categoryTitle' class="form-control" id='title' placeholder='Enter title'>
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
                <h2>Existing Categories</h2>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Date & Time</th>
                            <th>Category Name</th>
                            <th>Creater Name</th>
                            <?php if($_SESSION['permission'] != 'User'){ ?>
                            <th>Action</th>
                            <?php } ?>
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
                        $sql = "SELECT * FROM category ORDER BY id DESC LIMIT $showPostFrom,5";
                        $result = mysqli_query($conn, $sql);
                        $sr = $showPostFrom;
                        if (mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)) {
                                $sr++;
                                $CategorytId = $row['id'];
                                $DateTime = $row['datetime'];
                                $CategoryName = $row['title'];
                                $CreaterName = $row['author'];
                    ?>
                        <tr>
                            <td><?= $sr; ?></td>
                            <td><?= $DateTime; ?></td>
                            <td><?= $CategoryName; ?></td>
                            <td><?= $CreaterName; ?></td>
                            <?php if($_SESSION['permission'] != 'User'){ ?>
                            <td><a class="btn btn-danger" href="<?= $serverName; ?>/deletecategory?id=<?= $CategorytId; ?>">Delete</a></td>
                            <?php } ?>
                        </tr>
                    <?php
                            }
                        }else{
                            echo "<tr colspan='4' class='text-danger text-center'><td>No Category Available</td></tr>";
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
                            <a href="<?= $serverName; ?>/categories?page=<?= $page-1; ?>" class="page-link">&laquo;</a>
                        </li>
                        <?php
                                }
                            }
                        ?>
                        <!-- Backward Button End -->
                        <?php
                            if(isset($page)){
                                $sql = "SELECT * FROM category";
                                $result = mysqli_query($conn, $sql);
                                $totalPost = mysqli_num_rows($result);
                                $postPagination = ceil($totalPost/5);
                                for($i=1; $i<=$postPagination; $i++){
                                    if($i == $page){
                        ?>
                        <li class="page-item active">
                            <a href="<?= $serverName; ?>/categories?page=<?= $i; ?>" class="page-link"><?= $i; ?></a>
                        </li>
                        <?php
                                    }else{
                        ?>
                        <li class="page-item">
                            <a href="<?= $serverName; ?>/categories?page=<?= $i; ?>" class="page-link"><?= $i; ?></a>
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
                            <a href="<?= $serverName; ?>/categories?page=<?= $page+1; ?>" class="page-link">&raquo;</a>
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