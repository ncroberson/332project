<html>
<head></head>
<body>
  <form action="professor.php">
  <input type="submit" value="Professor">
  </form>
  <form action="student.php">
  <input type="submit" value="Student">
  </form>
 <?php
  $db_server = "localhost";
  $db_user_name = "cs332a37";
  $db_pass = "shoonang";
  $db_name = "cs332a37";

  $db_conn = new mysqli($db_server_name, $db_user_name, $db_pass, $db_name);

if($db_conn->connect_error)
{
  die("Failed to connect to database: " . $db_conn->connect_error);
}
else
{
  echo "<div> connection successful </div>";
}
 ?>
  test </body>

</html>
