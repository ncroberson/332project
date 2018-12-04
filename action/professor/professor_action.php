<?php
$sql = "SELECT * FROM  courses";
$output_string = generate_results($sql, $db_conn);
 ?>

 <html>
  <body>
    <div> <?php $output_string ?> </div>
   </body>


  </html>

  <?php include_once 'db_disconnect.php'; ?>
