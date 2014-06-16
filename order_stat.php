<?php
session_start();
require("connect.php");
if (!$_SESSION['auth'] == 1) {
    // check if authentication was performed

    header( 'Location: login.php?message=2' );
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

    <title>Game Share Order Stat</title>

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
                    //Show your orders
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
                    //If order has been sent, allow return
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
