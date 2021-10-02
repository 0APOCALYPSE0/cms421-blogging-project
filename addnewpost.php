<?php
    require 'Includes/db.php';
    require 'Includes/functions.php';
    require 'Includes/sessions.php';
    $_SESSION['trackingURL'] = $_SERVER["PHP_SELF"];
    confirmLogin();
    if(isset($_POST['submit'])){
        $postTitle = $_POST['postTitle'];
        $postSlug = $_POST['postSlug'] == '' ? post_slug($_POST['postTitle']) : $_POST['postSlug'];
        $postTags = $_POST['postTags'];
        $category = $_POST['category'];
        $image = $_FILES['image']['name'];
        $postDescription = $_POST['postDescription'];
        $postStatus = $_POST['postTags'];
        $target = "Upload/".basename($_FILES['image']['name']);
        $admin = $_SESSION['username'];
        date_default_timezone_set("Asia/Calcutta");
        $currentTime = time();
        $dateTime = strftime("%e %b %y %H:%M:%S", $currentTime);

        $counter = 0;
        $intialPostSlug = $postSlug;
        while(mysqli_num_rows(mysqli_query($conn, "SELECT *
                                               FROM post
                                               WHERE slug = '$postSlug' "))){

            $counter++;
            $postSlug = "{$intialPostSlug}-{$counter}";
        }
        echo $target;
        if(empty($postTitle)){
            $_SESSION['ErrorMessage'] = 'Post title can\'t be empty.';
            Redirect_To($serverName."/addnewpost");
        }elseif(strlen($postTitle)<5){
            $_SESSION['ErrorMessage'] = 'Post title should be greater than 5 character.';
            Redirect_To($serverName."/addnewpost");
        }elseif(strlen($category)>999){
            $_SESSION['ErrorMessage'] = 'Post title should be less than 1000 character.';
            Redirect_To($serverName."/addnewpost");
        }else{
            $sql = "INSERT INTO post(datetime, title, slug, tags, category, author, image, post, status) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?);";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssss",$dateTime, $postTitle, $postSlug, $postTags, $category, $admin, $image, $postDescription, $postStatus);
            $execute = $stmt->execute();
            $last_id = $conn->insert_id;
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
            // $sql = "INSERT INTO category(title, author, datetime)";
            // $sql .= "VALUES(:categoryName, :adminName, :datetime);";
            // $stmt = $conn->prepare($sql);

            // $stmt->bindValue(':categoryName', $category);
            // $stmt->bindValue(':adminName', $admin);
            // $stmt->bindValue(':datetime', $dateTime);
            // $execute = $stmt->execute();
            if($execute){
                $_SESSION['SuccessMessage'] = "Post with ID: $last_id Added Successfully.";
                Redirect_To($serverName."/addnewpost");
            }else{
                $_SESSION['ErrorMessage'] = "Something went wrong. Try Again.";
                Redirect_To($serverName."/addnewpost");
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
    <script src="https://cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>
    <title>Add Post</title>
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
                        <a href="<?= $serverName; ?>/myprofile" class="nav-link"> <i class='fas fa-user'></i> My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $serverName; ?>/dashboard" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $serverName; ?>/posts" class="nav-link">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $serverName; ?>/categories" class="nav-link"> Categories</a>
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
                    <h1><i class='fas fa-edit' style="color: #27aae1;"></i>  Add New Post</h1>
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
                <form action="<?= $serverName; ?>/addnewpost" method='post' enctype="multipart/form-data">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-header">
                            <h1>Add New Post</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="postTitle"><span class="fieldInfo">Post Title</span></label>
                                <input type="text" name='postTitle' class="form-control" id='postTitle' placeholder='Enter post title'>
                            </div>
                            <div class="form-group">
                                <label for="postSlug"><span class="fieldInfo">Post Slug</span></label>
                                <input type="text" name='postSlug' class="form-control" id='postSlug' placeholder='Enter post slug'>
                            </div>
                            <div class="form-group">
                                <label for="postTags"><span class="fieldInfo">Post Tags</span></label>
                                <input type="text" name='postTags' class="form-control" id='postTags' placeholder='Enter post tags'>
                            </div>
                            <div class="form-group">
                                <label for="postTitle"><span class="fieldInfo">Choose Category</span></label>
                                <select class='form-control' name="category" id="categoryTitle">
                                    <?php
                                        $sql = "SELECT id, title FROM category";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0){
                                            while($row = mysqli_fetch_assoc($result)) {
                                                $Id = $row['id'];
                                                $categoryName = $row['title'];
                                    ?>
                                    <option value="<?= $categoryName ?>"><?php echo $categoryName ?></option>
                                    <?php  }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="imageSelect"><span class="fieldInfo">Select Image</span></label>
                                <div class="custom-file">
                                    <input class="custom-file-input" type="file" name='image' id='imageSelect' value=''>
                                    <label for="imageSelect" class="custom-file-label">Select Image</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="post"><span class="fieldInfo">Post Description</span></label>
                                <textarea class="form-control" name="postDescription" id="post" cols="80" rows="10"></textarea>
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

    <script type="text/javascript">
	    CKEDITOR.replace('postDescription');
    </script>
    <script src="https://kit.fontawesome.com/a977020c47.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script>
        $('#year').text(new Date().getFullYear());
    </script>
</body>
</html>