<?php
$config = parse_ini_file('includes/creds.ini');
$conn = new mysqli($config['DBServer'], $config['DBUser'], $config['DBPass'], $config['DBName']);
// check connection
if ($conn->connect_error) {
  trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
}
    $Sql='SELECT idpattern,patternPublisher,publisherName,patternNum,patternSize,patternBust,patternWaist,patternHips,patternEra,patternGender,patternDesc,patternNotes,patternPicture IS NULL AS X
    FROM pattern,publisher
    WHERE patternPublisher=idpublisher ';
if(isset($_GET['pubID'])>0){
    $Sql .= 'AND patternPublisher='.$_GET['pubID'];
    }
if(isset($_GET['bust'])>0){
    $Sql .= ' AND patternBust='.$_GET['bust'];
    }
if(isset($_GET['waist'])>0){
    $Sql .= ' AND patternWaist='.$_GET['waist'];
    }
if(isset($_GET['hips'])>0){
    $Sql .= '
	    AND patternHips='.$_GET['hips'];
    }
if(isset($_GET['desc']) != '' ){
    $Sql .= ' AND patternDesc LIKE "%'.$_GET['desc'].'%"
    AND patternNotes LIKE "%'.$_GET['notes'].'%"';
//    echo $Sql;
    }
if(isset($_GET['gender']) != '' ){
    $Sql .= ' AND patternGender="'.$_GET['gender'].'"';
    }
if(isset($_GET['era']) != '' ){
    $Sql .= ' AND patternEra="'.$_GET['era'].'"';
    }
if(isset($_GET['size'])>0){
    $Sql .= ' AND patternSize="'.$_GET['size'].'"';
    }
 
$Sql .= '
    ORDER BY patternPublisher,patternNum';
$rs=$conn->query($Sql);
 
if($rs == false) {
  trigger_error('Wrong SQL: ' . $Sql . ' Error: ' . $conn->error, E_USER_ERROR);
} else {
  $rows_returned = $rs->num_rows;
}
$rs->data_seek(0);
echo "<html>\n";
echo "<head>\n";
echo "<title>All Patterns</title>\n";
echo '<link rel="stylesheet" type="text/css" href="styles/basic.css" />';
echo "</head>\n";
echo "<body style='background: url(images/butterickL.jpg);'>\n";
echo "<h2>Results from the database: $rows_returned </h2>";
echo '<h3><a href="index.php">Display all results</a> or <a href="protected/new.php">add a new pattern</a></h3>';
echo '<form action="'.$_SERVER['PHP_SELF'].'" method="get">
  Search word/s in description: <input type="text" name="desc"><br />
  Search word/s in notes: <input type="text" name="notes"><br />
  <input type="submit" value="Submit">
</form>';
echo "<table border width=\"100%\">\n";
echo "<tr><th>DB ID</th><th>Publisher</th><th>Number<br />(image)</th><th>Size</th><th>Bust</th><th>Waist</th><th>Hips</th><th>Era</th><th>Gender</th><th>Description</th><th>Notes</th>\n";
while($row = $rs->fetch_assoc()){
//    print_r($row);
	$X=$row['X'];
//echo "X = ".$X;
    echo "<tr><td><a href='protected/edit.php?ID=" . $row['idpattern'] . "'>".$row['idpattern'].'</a></td>';
    echo "<td><a href='".$_SERVER['PHP_SELF']."?pubID=" . $row['patternPublisher'] ."'>" . $row['publisherName'] . '</a></td>';
    if ($X) echo "<td><a href=\"protected/file_insert.php?ID=".$row['idpattern']."\">upload</a>".$row['patternNum'].'</td>' ;
    else echo "<td><a href='display_image.php?id=" . $row['idpattern'] ."'>" . $row['patternNum'] .'</a></td>';
    echo "<td><a href='".$_SERVER['PHP_SELF']."?size=" . $row['patternSize'] ."'>" . $row['patternSize'] . '</td>';
    echo "<td><a href='".$_SERVER['PHP_SELF']."?bust=" . $row['patternBust'] ."'>" . $row['patternBust'] . '</a></td>';
    echo "<td><a href='".$_SERVER['PHP_SELF']."?waist=" . $row['patternWaist'] ."'>" . $row['patternWaist'] . '</a></td>';
    echo "<td><a href='".$_SERVER['PHP_SELF']."?hips=" . $row['patternHips'] ."'>" . $row['patternHips'] . '</a></td>';
    echo "<td><a href='".$_SERVER['PHP_SELF']."?era=" . $row['patternEra'] ."'>" . $row['patternEra'] . '</td>';
    echo "<td><a href='".$_SERVER['PHP_SELF']."?gender=" . $row['patternGender'] ."'>" . $row['patternGender'] . '</a></td>';
    echo "<td>" . $row['patternDesc'] . '</td>';
    echo "<td>" . $row['patternNotes'] . "</td></tr>\n";
}
echo "</table>";
echo "</body>";
echo "</html>";
$conn->close();
?>
