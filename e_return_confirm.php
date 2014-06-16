<?php
session_start();
require("connect.php");
if (!$_SESSION['e_auth'] == 1) {
    // check if authentication was performed

    header( 'Location: employee_login.php?message=2' );
}
if(empty($_GET['returnID'])){
    header( 'Location: employee_management.php' );
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Employee Confirm Return</title>

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
                    <li><a href="employee_logout.php">Not <?php echo $_SESSION['e_name'] ?>? Logout</a>
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
                    $yourEmpId;

                    $empRes = mysqli_query($empCon,"SELECT * FROM Employee WHERE username = '".$_SESSION['e_name']."'");
                    //Employee Info
                    while($emprow = mysqli_fetch_array($empRes)) {
                        echo '<span class="list-group-item">ID: '.$emprow['empID'].'</span>';
                        echo '<span class="list-group-item">username: '.$emprow['username'].'</span>';
                        echo '<span class="list-group-item">Full Name: '.$emprow['name'].'</span>';
                        echo '<span class="list-group-item">DOB: '.$emprow['dateOfBirth'].'</span>';
                        $yourEmpId = $emprow['empID'];
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
                <h1>Confirm Return</h1>


                <div class="row">

                    <?php
                    


                    //Connect to DB
                    $con = mysqli_connect($db_location,$db_user,$db_password,$db_dbname);

                    if (mysqli_connect_errno()) {
                        printf("Connect failed: %s\n", mysqli_connect_error());
                        exit();  
                    }
                    $returnID = mysqli_real_escape_string($con, $_GET['returnID']);

                    $returnQ = mysqli_query($con,"SELECT * FROM Returns where returnID = '".$returnID."'");
                    $returnRes = mysqli_fetch_array($returnQ);



                    //Make List
                    echo '<div class="list-group">';

                    echo '<div class="list-group-item">';
                    echo '<h4 class="list-group-item-heading">returnID</h4>';
                    echo '<p class="list-group-item-text">'.$returnRes['returnID'].'</p>';
                    echo '</div>';

                    //
                    echo '<div class="list-group-item">';
                    echo '<h4 class="list-group-item-heading">gameID</h4>';
                    echo '<p class="list-group-item-text">'.$returnRes['gameID'].'</p>';
                    echo '</div>';

                    //
                    echo '<div class="list-group-item">';
                    echo '<h4 class="list-group-item-heading">cusID</h4>';
                    echo '<p class="list-group-item-text">'.$returnRes['cusID'].'</p>';
                    echo '</div>';

                    echo '</div>';

                    
                    mysqli_close($con);

                    ?>

                    <form class="form col-md-12 center-block" action="e_remove_return.php" method="post">
                        <div class="form-group">
                            <h3>Game Condition</h3>
                            <input type="radio" name="status" value="excellent" checked> excellent<br>
                            <input type="radio" name="status" value="good" > good<br>
                            <input type="radio" name="status" value="fair" > fair<br>
                            <input type="radio" name="status" value="poor" > poor<br>
                            <input type="radio" name="status" value="disposed" > dispose game<br>

                        </div>
                        <div class="form-group">
                            <?php
                            echo '<input type="hidden" name="returnID" value="'.$returnRes['returnID'].'" >';
                            echo '<input type="hidden" name="gameID" value="'.$returnRes['gameID'].'" >';
                            echo '<input type="hidden" name="cusID" value="'.$returnRes['cusID'].'" >';
                            ?>
                        </div>
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary btn-lg btn-block">Confirm Return</button>
                          <span class="pull-right"><a href="employee_management.php">Cancel</a></span><span></span>
                      </div>
                  </form>



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
