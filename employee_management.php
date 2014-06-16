<?php
session_start();
require("connect.php");
if (!$_SESSION['e_auth'] == 1) {
    // check if authentication was performed

    header( 'Location: employee_login.php?message=2' );
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Game Share</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/shop-homepage.css" rel="stylesheet">

</head>

<body>

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="employee_management.php">Management</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="logout.php">Not <?php echo $_SESSION['e_name'] ?>? Logout</a>
                    </li>
                    <li><a href="#services"></a>
                    </li>
                    <li><a href="#contact"></a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <div class="container">

        <div class="row">

            <div class="col-md-3">
                <p class="lead">Your Information</p>
                <div class="list-group">
                    <?php
                    $empCon = mysqli_connect($db_location,$db_user,$db_password,$db_dbname);

                    if (mysqli_connect_errno()) {
                        printf("Connect failed: %s\n", mysqli_connect_error());
                        exit();  
                    }

                    $empRes = mysqli_query($empCon,"SELECT * FROM Employee WHERE username = '".$_SESSION['e_name']."'");
                    //Employee Info
                    while($emprow = mysqli_fetch_array($empRes)) {
                        echo '<span class="list-group-item">ID: '.$emprow['empID'].'</span>';
                        echo '<span class="list-group-item">username: '.$emprow['username'].'</span>';
                        echo '<span class="list-group-item">Full Name: '.$emprow['name'].'</span>';
                        echo '<span class="list-group-item">DOB: '.$emprow['dateOfBirth'].'</span>';

                    }
                    //Calculated Age using SQL 
                    $ageRes = mysqli_query($empCon, "SELECT YEAR(CURRENT_TIMESTAMP) - YEAR(dateOfBirth) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(dateOfBirth, 5)) as age FROM Employee WHERE username ='".$_SESSION['e_name']."'");

                    $printAge = mysqli_fetch_array($ageRes);
                    echo '<span class="list-group-item">Age: '.$printAge['age'].'</span>';
                    mysqli_close($empCon);

                    ?>

                </div>
            </div>

            <div class="col-md-9">

                <div class="row carousel-holder">

                    <div class="col-md-12">
                        <img src="images/logo.jpg">
                    </div>

                </div>

                <div class="row">
                    <h2>Orders</h2>
                    <table class="table table-striped table-hover ">
                      <thead>
                        <tr>
                          <th>orderID</th>
                          <th>Game Title</th>
                          <th>Price</th>
                          <th>gameID</th>
                          <th>Status</th>
                          <th>empID Assigned</th>
                      </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>Column content</td>
                      <td>Column content</td>
                      <td>Column content</td>
                      <td>Column content</td>
                      <td>Column content</td>

                  </tr>
                  <tr>
                      <td>1</td>
                      <td>Column content</td>
                      <td>Column content</td>
                      <td>Column content</td>
                      <td>Column content</td>
                      <td>Column content</td>

                  </tr>
                  <tr>
                      <td>1</td>
                      <td>Column content</td>
                      <td>Column content</td>
                      <td>Column content</td>
                      <td>Column content</td>
                      <td>Column content</td>

                  </tr>
                  
              </tbody>
          </table> 

                    <?php
                    /*
                    //Connect to DB
                    $con = mysqli_connect($db_location,$db_user,$db_password,$db_dbname);

                    if (mysqli_connect_errno()) {
                        printf("Connect failed: %s\n", mysqli_connect_error());
                        exit();  
                    }

                    $result = mysqli_query($con,"SELECT * FROM Game");

                    while($row = mysqli_fetch_array($result)) {
                        echo '<div class="col-sm-4 col-lg-4 col-md-4">';
                        echo '<div class="thumbnail">';
                        echo '<img src="images/'.$row['gameID'].'.jpg" width="320" alt="">';
                        echo '<div class="caption">';
                        echo '<h4 class="pull-right">'.$row['price'].'</h4>';
                        echo '<h5><a href="#">'.$row['title'].'</a></h5>';
                        echo '<p><a href="#">Order this game</a></p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    mysqli_close($con);
                    */
                    ?>

                </div>

            </div>

        </div>

    </div>
    <!-- /.container -->

    <div class="container">

        <hr>

        <footer>
            <div class="row">
                <div class="col-lg-12">

                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- JavaScript -->
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.js"></script>

</body>

</html>
