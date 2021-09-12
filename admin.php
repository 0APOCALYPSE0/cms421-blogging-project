<?php
    require 'Includes/db.php';
    require 'Includes/functions.php';
    require 'Includes/sessions.php';
    $_SESSION['trackingURL'] = $_SERVER["PHP_SELF"];
    confirmLogin();

    if(isset($_POST['submit'])){
        $userName = $_POST['userName'];
        $adminName = $_POST['name'];
        $password = $_POST['password'];
        $cPassword = $_POST['cPassword'];
        $admin = $_SESSION['username'];
        date_default_timezone_set("Asia/Calcutta");
        $currentTime = time();
        $dateTime = strftime("%e %b %y %H:%M:%S", $currentTime);

        if(empty($userName) || empty($password) || empty($cPassword)){
            $_SESSION['ErrorMessage'] = 'All fields must be filled out.';
            Redirect_To($serverName."/admin");
        }elseif(strlen($password)<3){
            $_SESSION['ErrorMessage'] = 'Password should be greater than 3 character.';
            Redirect_To($serverName."/admin");
        }elseif($password !== $cPassword){
            $_SESSION['ErrorMessage'] = 'Password and Confirm Password are not matching.';
            Redirect_To($serverName."/admin");
        }elseif(checkUsernameExist($userName)){
            $_SESSION['ErrorMessage'] = 'This username is already taken. Please choose another one.';
            Redirect_To($serverName."/admin");
        }else{
            $sql = "INSERT INTO admins(datetime, username, password, aname, addedby) VALUES(?, ?, ?, ?, ?);";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $dateTime, $userName, $password, $adminName, $admin);
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
                $_SESSION['SuccessMessage'] = "New Admin with Name ".$adminName." Added Successfully.";
                Redirect_To($serverName."/admin");
            }else{
                $_SESSION['ErrorMessage'] = "Something went wrong. Try Again.";
                Redirect_To($serverName."/admin");
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
    <link rel="stylesheet" href="<?= $cssBaseURL ?>/style.css">
    <title>Admin Page</title>
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
                    <h1><i class='fas fa-user' style="color: #27aae1;"></i>  Manage Admins</h1>
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
                <form action="<?= $serverName; ?>/admin" method='post'>
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-header">
                            <h1>Add New Admin</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="userName"><span class="fieldInfo">User Name</span></label>
                                <input type="text" name='userName' class="form-control" id='userName' placeholder='Enter title'>
                            </div>
                            <div class="form-group">
                                <label for="name"><span class="fieldInfo">Name</span></label>
                                <input type="text" name='name' class="form-control" id='name' placeholder='Enter Name'>
                                <small class="text-warning text-muted">Optional</small>
                            </div>
                            <div class="form-group">
                                <label for="password"><span class="fieldInfo">Password</span></label>
                                <input type="password" name='password' class="form-control" id='password'>
                            </div>
                            <div class="form-group">
                                <label for="cPassword"><span class="fieldInfo">Confirm Password</span></label>
                                <input type="text" name='cPassword' class="form-control" id='cPassword'>
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
                <h2>Existing Admins</h2>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Date & Time</th>
                            <th>Username</th>
                            <th>Admin Name</th>
                            <th>Added By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php
                        $sql = "SELECT * FROM admins ORDER BY id DESC";
                        $result = mysqli_query($conn, $sql);
                        $sr = 0;
                        if (mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)) {
                                $sr++;
                                $AdmintId = $row['id'];
                                $DateTime = $row['datetime'];
                                $AdminUsername = $row['username'];
                                $AdminName = $row['aname'];
                                $AddedBy = $row['addedby'];
                    ?>
                    <tbody>
                        <tr>
                            <td><?= $sr; ?></td>
                            <td><?= $DateTime; ?></td>
                            <td><?= $AdminUsername; ?></td>
                            <td><?= $AdminName; ?></td>
                            <td><?= $AddedBy; ?></td>
                            <td><a class="btn btn-danger" href="<?= $serverName; ?>/deleteadmin?id=<?= $AdmintId; ?>">Delete</a></td>
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