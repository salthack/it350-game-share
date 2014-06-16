<?php
session_start();
require("connect.php");
if (!$_SESSION['e_auth'] == 1) {
    // check if authentication was performed

    header( 'Location: employee_login.php?message=2' );
}
if(empty($_GET['orderID'])){
    header( 'Location: index.php' );
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Employee Order Stat</title>

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
                <h1>Order Status</h1>


                <div class="row">

                    <?php
                    


                    //Connect to DB
                    $con = mysqli_connect($db_location,$db_user,$db_password,$db_dbname);

                    if (mysqli_connect_errno()) {
                        printf("Connect failed: %s\n", mysqli_connect_error());
                        exit();  
                    }
                    $getid = mysqli_real_escape_string($con, $_GET['orderID']);

                    $orderQ = mysqli_query($con,"SELECT * FROM Orders where orderID = '".$getid."'");
                    $orderRes = mysqli_fetch_array($orderQ);



                    //Make List
                    echo '<div class="list-group">';

                    echo '<div class="list-group-item">';
                    echo '<h4 class="list-group-item-heading">orderID</h4>';
                    echo '<p class="list-group-item-text">'.$orderRes['orderID'].'</p>';
                    echo '</div>';

                    //
                    echo '<div class="list-group-item">';
                    echo '<h4 class="list-group-item-heading">Title</h4>';
                    echo '<p class="list-group-item-text">'.$orderRes['title'].'</p>';
                    echo '</div>';

                    //
                    echo '<div class="list-group-item">';
                    echo '<h4 class="list-group-item-heading">Price</h4>';
                    echo '<p class="list-group-item-text">'.$orderRes['price'].'</p>';
                    echo '</div>';

                    echo '<div class="list-group-item">';
                    echo '<h4 class="list-group-item-heading">gameID</h4>';
                    echo '<p class="list-group-item-text">'.$orderRes['gameID'].'</p>';
                    echo '</div>'; 

                    echo '<div class="list-group-item">';
                    echo '<h4 class="list-group-item-heading">Order Status</h4>';
                    echo '<p class="list-group-item-text">'.$orderRes['status'].'</p>';
                    echo '</div>';            

                    echo '<div class="list-group-item">';
                    echo '<h4 class="list-group-item-heading">Your cusID</h4>';
                    echo '<p class="list-group-item-text">'.$orderRes['cusID'].'</p>';
                    echo '</div>';

                    echo '<div class="list-group-item">';
                    echo '<h4 class="list-group-item-heading">Assigned Employee</h4>';
                    echo '<p class="list-group-item-text">'.$orderRes['empID'].'</p>';
                    echo '</div>';




                    echo '</div>';

 
                    mysqli_close($con);

                    if($orderRes['status'] == 'Sent'){
                        echo '<form class="form col-md-12 center-block" action="send_return.php" method="post">';
                        echo '<div class="form-group">';
                        echo '<input type="hidden" name="orderID" value="'.$orderRes['orderID'].'" >';
                        echo '<input type="hidden" name="gameID" value="'.$orderRes['gameID'].'" >';
                        echo '<input type="hidden" name="cusID" value="'.$orderRes['cusID'].'" >';
                        echo '</div>';
                        echo '<div class="form-group">';
                        echo '<button type="submit" class="btn btn-primary btn-lg btn-block">Return Order</button>';
                        echo '</div>';
                        echo '</form>';

                    }
                    ?>

                    <form class="form col-md-12 center-block" action="e_send_game.php" method="post">
                        <div class="form-group">
                        <?php
                        $shipCon = mysqli_connect($db_location,$db_user,$db_password,$db_dbname);
                        if (mysqli_connect_errno()) {
                            printf("Connect failed: %s\n", mysqli_connect_error());
                            exit();  
                        }
                        $shipQ = mysqli_query($shipCon,"SELECT * FROM Shipping_Company");

                        while($shipRow = mysqli_fetch_array($shipQ)) {
                            echo '<input type="radio" name="compID" value="'.$shipRow['compID'].'"> '.$shipRow['name'].' : '.$shipRow['cost_to_ship'].' : '.$shipRow['days_to_ship'].' Days<br>';
                        }
                        mysqli_close($shipCon);
                        ?>

                      </div>
                      <div class="form-group">
                        <?php
                        echo '<input type="hidden" name="orderID" value="'.$orderRes['orderID'].'" >';
                        echo '<input type="hidden" name="gameID" value="'.$orderRes['gameID'].'" >';
                        echo '<input type="hidden" name="empID" value="'.$orderRes['empID'].'" >';
                        ?>
                      </div>
                      <div class="form-group">
                          <button type="submit" class="btn btn-primary btn-lg btn-block">Send Game</button>
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
