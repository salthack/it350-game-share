<?php
session_start();
require("connect.php");
if (!$_SESSION['auth'] == 1) {
    // check if authentication was performed

    header( 'Location: login.php?message=2' );
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

                <div class="row carousel-holder">

                    <div class="col-md-12">
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img class="slide-image" src="images/slide1.jpg" alt="">
                                </div>
                                <div class="item">
                                    <img class="slide-image" src="images/slide2.jpg" alt="">
                                </div>
                                <div class="item">
                                    <img class="slide-image" src="images/slide3.jpg" alt="">
                                </div>
                            </div>
                            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <?php


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
                        echo '<p><a href="order_confirm.php?id='.$row['gameID'].'">Order this game</a></p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    mysqli_close($con);

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
