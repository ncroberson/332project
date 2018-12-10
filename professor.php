<?php include_once 'action/db_connect.php'  ?>

<?php

function get_classes($ssn, $conn)
  {
  $output = '';
  $sql = "SELECT * FROM  sections WHERE professor = '$ssn'";
  $query = mysqli_query($conn, $sql) or die("Could not search");;
  $count = mysqli_num_rows($query);
  if($count == 0)
  {
    $output = "No sections found.";
  }
  else
  {
    $output .=
    '<div> Results</div>
    <table>
    <thead>
    <th>Course</th>
    <th>Section Number</th>
    <th>Classroom</th>
    <th>Meeting Days</th>
    <th>Start Time</th>
    <th>End Time</th>
    <th>Seats</th>
    </thead> <tbody>';

    while($row = mysqli_fetch_array($query))
    {
      $course = $row['course'];
      $section_num = $row['sectionnum'];
      $classroom = $row['classroom'];
      $meetingdays = $row['meetingdays'];
      $starttime = $row['starttime'];
      $endtime = $row['endtime'];
      $num_seats = $row['num_of_seats'];

      $output .= '<tr><td>' .$course. '</td><td>' .$section_num. '</td><td>' .$classroom.
      '</td><td>' .$meetingdays. '</td><td>' .$starttime. '</td><td>' .$endtime.
      '</td><td>' .$num_seats. '</td></tr>';
    }
    $output .= '</tbody>';
  }
  return $output;
}

function get_grades($course, $section, $conn)
  {
  $output = '';
  $sql = "Select grade, count(grade) AS gcount From enrolled_in INNER JOIN sections
  ON sections.sectionnum = enrolled_in.section_num WHERE sectionnum = '$section'
  AND course = '$course' GROUP BY grade;";
  $query = mysqli_query($conn, $sql) or die("Could not search");;
  $count = mysqli_num_rows($query);
  if($count == 0)
  {
    $output = "No sections found.";
  }
  else
  {
    $output .=
    '<h4> Grades for ' .$course. ', Section ' .$section. ': </h4>' .
    '<table>
    <thead>
    <th>Course</th>
    <th>Section Number</th>
    <th>Grade</th>
    <th>Count</th>
    </thead> <tbody>';

    while($row = mysqli_fetch_array($query))
    {
      $course_num = $course;
      $section_num = $section;
      $grade = $row['grade'];
      $gcount = $row['gcount'];

      $output .= '<tr><td>' .$course. '</td><td>' .$section_num. '</td><td>' .$grade.
      '</td><td>' .$gcount. '</td></tr>';
    }
    $output .= '</tbody>';
  }
  return $output;
}

if(isset($_POST['find_courses']))
{
  if(isset($_POST['ssn']))
  {
    $output_string = get_classes($_POST['ssn'], $db_conn);
  }

}
else if(isset($_POST['find_grades']))
{
  if(isset($_POST['course_num']) && isset($_POST['section_num']))
  {
    $output_string = get_grades($_POST['course_num'], $_POST['section_num'], $db_conn);
  }
}


 ?>

<html>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
  text-align: left;
}
</style>
<head></head>
<body>
<h3><u> Professor </u></h3>
<fieldset>
  <legend>  Find my classes:  </legend>
  <form action="<?php echo($_SERVER['PHP_SELF']) ?>" method="post">
    SSN:
  <input type="text" name="ssn">
  <input type="submit" value="Search" name="find_courses">
  </form>
</fieldset>
<fieldset>
  <legend>  Print Course Grades:  </legend>
  <form action="<?php echo($_SERVER['PHP_SELF']) ?>" method="post">
    Course #:
  <input type="text" name="course_num">
    Section #:
  <input type="text" name ="section_num">
  <input type="submit" value="Search" name="find_grades">
  </form>
</fieldset>
<br><br>
<div><?php print("$output_string"); ?></div>
</body>
</html>

  <?php include_once 'action/db_disconnect.php'; ?>
