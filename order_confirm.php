<?php
session_start();
require("connect.php");
if (!$_SESSION['auth'] == 1) {
    // check if authentication was performed

    header( 'Location: login.php?message=2' );
}
if(empty($_GET['id'])){
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

    <title>Game Share Order</title>

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
                <a class="navbar-brand" href="index.php">GameShare</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="logout.php">Not <?php echo $_SESSION['name'] ?>? Logout</a>
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
                <p class="lead">Your Orders</p>
                <div class="list-group">


                    <?php

                    $orderCon = mysqli_connect($db_location,$db_user,$db_password,$db_dbname);
                    if (mysqli_connect_errno()) {
                        printf("Connect failed: %s\n", mysqli_connect_error());
                        exit();  
                    }
                    $orderCusQ = mysqli_query($orderCon,"SELECT cusID FROM Customer where username = '".$_SESSION['name']."'");
                    $orderCusArray = mysqli_fetch_array($orderCusQ);
                    $orderCus = $orderCusArray['cusID'];

                    $ordersQ = mysqli_query($orderCon,"SELECT orderID, title FROM Orders where cusID = '".$orderCus."'");

                    while($orderRow = mysqli_fetch_array($ordersQ)) {
                        echo '<a href="order_stat.php?orderID='.$orderRow['orderID'].'" class="list-group-item">'.$orderRow['orderID'].' : '.$orderRow['title'].'</a>';
                    }



                    mysqli_close($orderCon);


                    ?>
                </div>
            </div>

            <div class="col-md-9">
                <h1>Order Confirmation</h1>


                <div class="row">

                    <?php
                    


                    //Connect to DB
                    $con = mysqli_connect($db_location,$db_user,$db_password,$db_dbname);

                    if (mysqli_connect_errno()) {
                        printf("Connect failed: %s\n", mysqli_connect_error());
                        exit();  
                    }
                    $getid = mysqli_real_escape_string($con, $_GET['id']);

                    $result = mysqli_query($con,"SELECT * FROM Game where gameID = '".$getid."'");
                    $empRes = mysqli_query($con,"SELECT empID FROM Employee");
                    $cusRes = mysqli_query($con,"SELECT cusID FROM Customer WHERE username = '".$_SESSION['name']."'");
                    $platformRes = mysqli_query($con,"SELECT * FROM Console where gameID = '".$getid."'");

                    //Random Employee Assigned
                    $IDs = array();
                    while ($row = mysqli_fetch_array($empRes)){
                        array_push($IDs, $row['empID']);
                    }
                    $randID = rand(0,sizeof($IDs)-1);
                    $assignedEmp = $IDs[$randID];
                    //echo $assignedEmp;
                    
                    $cusArray = mysqli_fetch_array($cusRes);
                    $cusOrderID = $cusArray['cusID'];
                    //echo $cusOrderID;

                    $gameArray = mysqli_fetch_array($result);
                    $platformArray = mysqli_fetch_array($platformRes);
                    $orderUID = uniqid('orderID_', false);


                    //Make List
                    echo '<div class="list-group">';

                    echo '<div class="list-group-item">';
                    echo '<h4 class="list-group-item-heading">orderID</h4>';
                    echo '<p class="list-group-item-text">'.$orderUID.'</p>';
                    echo '</div>';

                    //
                    echo '<div class="list-group-item">';
                    echo '<h4 class="list-group-item-heading">Title</h4>';
                    echo '<p class="list-group-item-text">'.$gameArray['title'].'</p>';
                    echo '</div>';

                    //
                    echo '<div class="list-group-item">';
                    echo '<h4 class="list-group-item-heading">Console</h4>';
                    echo '<p class="list-group-item-text">'.$platformArray['name'].' '.$platformArray['make'].'</p>';
                    echo '</div>';

                    echo '<div class="list-group-item">';
                    echo '<h4 class="list-group-item-heading">Price</h4>';
                    echo '<p class="list-group-item-text">'.$gameArray['price'].'</p>';
                    echo '</div>'; 

                    echo '<div class="list-group-item">';
                    echo '<h4 class="list-group-item-heading">gameID</h4>';
                    echo '<p class="list-group-item-text">'.$gameArray['gameID'].'</p>';
                    echo '</div>';            

                    echo '<div class="list-group-item">';
                    echo '<h4 class="list-group-item-heading">Order Status</h4>';
                    echo '<p class="list-group-item-text">Ordered</p>';
                    echo '</div>';

                    echo '<div class="list-group-item">';
                    echo '<h4 class="list-group-item-heading">Your cusID</h4>';
                    echo '<p class="list-group-item-text">'.$cusArray['cusID'].'</p>';
                    echo '</div>';

                    echo '<div class="list-group-item">';
                    echo '<h4 class="list-group-item-heading">Assigned Employee</h4>';
                    echo '<p class="list-group-item-text">'.$assignedEmp.'</p>';
                    echo '</div>';


                    echo '</div>';

 
                    mysqli_close($con);

                    ?>

                    <form class="form col-md-12 center-block" action="place_order.php" method="post">
                    <div class="form-group">
                        <input type="hidden" name="orderID" value=<?php echo '"'.$orderUID.'"'?> >
                        <input type="hidden" name="title" value=<?php echo '"'.$gameArray['title'].'"'?> >
                        <input type="hidden" name="price" value=<?php echo '"'.$gameArray['price'].'"'?> >
                        <input type="hidden" name="gameID" value=<?php echo '"'.$gameArray['gameID'].'"'?> >
                        <input type="hidden" name="status" value="Ordered" >
                        <input type="hidden" name="cusID" value=<?php echo '"'.$cusArray['cusID'].'"'?> >
                        <input type="hidden" name="empID" value=<?php echo '"'.$assignedEmp.'"'?> >
                    </div>
                      <div class="form-group">
                          <button type="submit" class="btn btn-primary btn-lg btn-block">Submit Order</button>
                          <span class="pull-right"><a href="index.php">Cancel</a></span><span></span>
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
