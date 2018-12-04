<?php
$sql = "SELECT * FROM  courses";
$query = mysqli_query($db_conn, $sql) or die("Could not search");;
 ?>

 <html>
  <body>
    <div> <?php $query ?> </div>
   </body>


  </html>

  <?php include_once 'db_disconnect.php'; ?>
