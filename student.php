<?php include_once 'action/db_connect.php'  ?>

<?php

function get_transcript($cwid, $conn)
  {
  $output = '';
  $sql = "SELECT
    coursetitle,
    sectionnum,
    grade
FROM
    courses c
JOIN sections s ON
    s.course = c.coursenum
JOIN enrolled_in e ON
    e.section_num = s.sectionnum
JOIN students d ON
    d.CWID = e.student_id AND CWID = '$cwid'";
  $query = mysqli_query($conn, $sql) or die("Could not search");;
  $count = mysqli_num_rows($query);
  if($count == 0)
  {
    $output = "No transcript found.";
  }
  else
  {
    $output .=
    '<div> Transcript: </div>
    <table>
    <thead>
    <th>Course Number</th>
    <th>Section Number</th>
    <th>Grade</th>
    </thead> <tbody>';

    while($row = mysqli_fetch_array($query))
    {
      $course_num = $row['coursetitle'];
      $section_num = $row['sectionnum'];
      $grade = $row['grade'];

      $output .= '<tr><td>' .$course_num. '</td><td>' .$section_num. '</td><td>' .$grade.
      '</td></tr>';
    }
    $output .= '</tbody>';
  }
  return $output;
}

function get_sections($course, $conn)
  {
  $output = '';
  $sql = "SELECT
    sectionnum,
    classroom,
    meetingdays,
    starttime,
    endtime,
    COUNT(student_id) AS num_enrolled
FROM
    sections
JOIN enrolled_in ON sections.sectionnum = enrolled_in.section_num
WHERE
    course = '$course'
GROUP BY
    sectionnum";
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
    <th>Course Number</th>
    <th>Section Number</th>
    <th>Classroom</th>
    <th>Meeting Days</th>
    <th>Start Time</th>
    <th>End Time</th>
    <th># Enrolled</th>
    </thead> <tbody>';

    while($row = mysqli_fetch_array($query))
    {
      $course_num = $course;
      $section_num = $row['sectionnum'];
      $classroom = $row['classroom'];
      $meetingdays = $row['meetingdays'];
      $starttime = $row['starttime'];
      $endtime = $row['endtime'];
      $num_enrolled = $row['num_enrolled'];

      $output .= '<tr><td>' .$course_num. '</td><td>' .$section_num. '</td><td>' .$classroom.
      '</td><td>' .$meetingdays. '</td><td>' .$starttime. '</td><td>' .$endtime.
      '</td><td>' .$num_enrolled. '</td></tr>';
    }
    $output .= '</tbody>';
  }
  return $output;
}

if(isset($_POST['search_class']))
{
  if(isset($_POST['course_num']))
  {
    $output_string = get_sections($_POST['course_num'], $db_conn);
  }

}
else if(isset($_POST['transcript']))
{
  if(isset($_POST['cwid']) )
  {
    $output_string = get_transcript($_POST['cwid'], $db_conn);
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
<h3><u> Student </u></h3>
<fieldset>
  <legend>  Search Classes:  </legend>
  <form action="<?php echo($_SERVER['PHP_SELF']) ?>" method="post">
    Course #:
  <input type="text" name="course_num">
  <input type="submit" value="Search" name="search_class">
  </form>
</fieldset>
<fieldset>
  <legend>  My Transcript:  </legend>
  <form action="<?php echo($_SERVER['PHP_SELF']) ?>" method="post">
    CWID:
  <input type="text" name="cwid">
  <input type="submit" value="Search" name="transcript">
  </form>
</fieldset>
<br><br>
<div><?php print("$output_string"); ?></div>
</body>
</html>

  <?php include_once 'action/db_disconnect.php'; ?>
