<?php
$config = parse_ini_file('../includes/creds.ini');
$conn = new mysqli($config['DBServer'], $config['DBUser'], $config['DBPass'], $config['DBName']);
// check connection
if ($conn->connect_error) {
  trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
}
echo "<html>\n";
echo "<head>\n";
echo "<title>Pattern edit</title>\n";
echo '<link rel="stylesheet" type="text/css" href="../styles/basic.css" />';
echo "</head>\n";
echo "<body style='background: url(../images/butterickL.jpg);'>\n";
echo "<h2>Edit pattern entry</h2>\n";
echo "<p>Edit the pattern information and click the update button to change it in the database.<br />This directly changes the information and there is no undo";
if(1 == $_GET['update']){
$updateSQL = "UPDATE pattern SET patternPublisher=".$_GET['publisher'].",patternNum=\"".$_GET['patternNum']."\",patternSize=\"".$_GET['size']."\",patternBust=\"".$_GET['bust']."\",patternWaist=\"".$_GET['waist']."\",patternHips=\"".$_GET['hips']."\",patternEra=\"".$_GET['era']."\",patternGender=\"".$_GET['Gender']."\",patternDesc=\"".$_GET['desc']."\",patternNotes=\"".$_GET['notes']."\" WHERE idpattern=".$_GET['id'];
$rt=$conn->query($updateSQL);
echo "pattern entry updated, with this SQL command:<br /> $updateSQL\n";
}
else{
    $Sql='SELECT idpattern,patternPublisher,publisherName,patternNum,patternSize,patternBust,patternWaist,patternHips,patternEra,patternGender,patternDesc,patternNotes,patternPicture IS NULL AS X
    FROM pattern,publisher
    WHERE patternPublisher=idpublisher ';
if(isset($_GET['ID'])>0){
    $Sql .= 'AND idpattern='.$_GET['ID'];
    }
    $Sql2="SELECT * FROM publisher";
$rs=$conn->query($Sql);
 
if($rs == false) {
  trigger_error('Wrong SQL: ' . $Sql . ' Error: ' . $conn->error, E_USER_ERROR);
} else {
  $rows_returned = $rs->num_rows;
}
$rs->data_seek(0);
$thisID="edit.php?ID=".$_GET['ID'];
echo '<form action="'.$thisID.'" method="get">';
echo "<table border width=\"100%\">\n";
echo "<tr><th>DB ID</th><th>Publisher</th><th>Number<br />(image)</th><th>Size</th><th>Bust</th><th>Waist</th><th>Hips</th><th>Era</th><th>Gender</th><th>Description</th><th>Notes</th>\n";
while($row = $rs->fetch_assoc()){
$rr=$conn->query($Sql2);
$selectPub = '<select name="publisher">';
  while($aRow = $rr->fetch_assoc()){
    $selectPub .= $aRow['idpublisher']."<option ";
    if($aRow["idpublisher"] == $row["patternPublisher"]) {$selectPub .= "SELECTED ";}
    $selectPub .= "value=".$aRow['idpublisher'].">".$aRow['publisherName']."</option>";
    }
$selectPub .= "</select>";
	$X=$row['X'];
    echo "<tr><td><input type='hidden' name='id' value='".$row['idpattern']."'></input>" . $row['idpattern'] . '</td>';
    echo "<td>".$selectPub . '</td>';
    echo "<td><a href=\"file_insert.php?ID=".$row['idpattern']."\">upload</a>"."<input type='text' name=\"patternNum\" value=\"".$row['patternNum']. '" ></td>' ;
    echo "<td><input type='text' name=\"size\" value=\"".$row['patternSize'] . '" ></td>';
    echo "<td><input type='text' name=\"bust\" value=\"".$row['patternBust'] . '" ></td>';
    echo "<td><input type='text' name=\"waist\" value=\"".$row['patternWaist'] . '" ></td>';
    echo "<td><input type='text' name=\"hips\" value=\"".$row['patternHips'] . '" ></td>';
    echo "<td><input type='text' name=\"era\" value=\"".$row['patternEra'] . '" ></td>';
    echo "<td><input type='text' name=\"Gender\" value=\"".$row['patternGender'] . '" ></td>';
    echo "<td><input type='text' name=\"desc\" value=\"".$row['patternDesc'] . '" ></td>';
    echo "<td><input type='text' name=\"notes\" value=\"".$row['patternNotes'] . '" ></td>';
    echo "</tr>\n";
}
echo "</table>\n";
echo "<input type='hidden' name='update' value='1'></input>";
echo '<input type="submit" Value="Update" />';
echo "</form>\n";
}
echo "</body>\n";
echo "</html>";
$conn->close();
?>
