<?php
$id=$_GET['id'];
$config = parse_ini_file('includes/creds.ini');
$conn = new mysqli($config['DBServer'], $config['DBUser'], $config['DBPass'], $config['DBName']);
// check connection
if ($conn->connect_error) {
  trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
}

$sql="SELECT publisherName,patternPicture,patternPublisher,patternNum FROM pattern,publisher WHERE idpattern=$id AND idpublisher=patternPublisher";
if($rs === false) {
  trigger_error('Wrong SQL: ' . $selAll . ' Error: ' . $conn->error, E_USER_ERROR);
} else {
  $rows_returned = $rs->num_rows;
}
$thePic=$conn->query($sql);
$row = $thePic->fetch_assoc();
$img = $row['patternPicture']; 
$title=$row['publisherName']." ".$row['patternNum'];
echo '<html>
<head>
<title> '.$title.' </title>
</head>
<body background="images/sewingBG.jpg">';
echo '<h2 style="text-align:center">'.$title.'</h2><p style="text-align:center"><img src="data:image/jpeg;base64,'.base64_encode( $row['patternPicture'] ).'"/></p>';
echo '</body>
</html>';
?>
