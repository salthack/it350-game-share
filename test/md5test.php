<?php
  if( $_GET["name"] )
  {
     echo "Welcome ". $_GET['name']. "<br />";
     echo md5($_GET['name']);
     echo "<br />";
     echo uniqid('cusID_', true);
     echo "<br />";
     echo uniqid('gameID_', false);
     echo "<br />";

    echo uniqid('empID_', true);

    echo "<br />";

    echo uniqid('orderID_', false);
     exit();
  }
?>
<html>
<body>
  <form action="<?php $_PHP_SELF ?>" method="GET">
  Name: <input type="text" name="name" />
  <input type="submit" />
  </form>
</body>
</html>
