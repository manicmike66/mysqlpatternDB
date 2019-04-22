<?php
$config = parse_ini_file('../includes/creds.ini');
$conn = new mysqli($config['DBServer'], $config['DBUser'], $config['DBPass'], $config['DBName']);
// check connection
if ($conn->connect_error) {
  trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
}
echo "<html>\n";
echo "<head>\n";
echo "<title>Add New Pattern</title>\n";
echo '<link rel="stylesheet" type="text/css" href="../styles/basic.css" />';
echo "</head>\n";
echo "<body style='background: url(../images/butterickL.jpg);'>\n";
echo "<h2>Add new pattern</h2>\n";
echo "<p>or <a href=\"../index.php\">go back</a>\n";
echo "<p>Fill in the pattern information and click the update button to add it to the database.<br />This directly changes the information and there is no undo";
if(1 == $_GET['add']){
$updateSQL = "INSERT INTO pattern (patternPublisher,patternNum,patternSize,patternBust,patternWaist,patternHips,patternEra,patternGender,patternDesc,patternOrigPrice,patternNotes) VALUES (".$_GET['publisher'].",\"".$_GET['patternNum']."\",\"".$_GET['size']."\",\"".$_GET['bust']."\",\"".$_GET['waist']."\",\"".$_GET['hips']."\",\"".$_GET['era']."\",\"".$_GET['Gender']."\",\"".$_GET['desc']."\",\"".$_GET['op']."\",\"".$_GET['notes']."\");";
$rs=$conn->query($updateSQL);
#echo $updateSQL;
echo "pattern entry updated, with this SQL command:<br /> $updateSQL\n";
}
$Sql2="SELECT * FROM publisher";
$thisID="new.php";
echo '<form action="'.$thisID.'" method="get">';
echo "<table border width=\"100%\">\n";
echo "<tr><!--<th>DB ID</th>--><th>Publisher</th><th>Number<br />(image)</th><th>Size</th><th>Bust</th><th>Waist</th><th>Hips</th><th>Era</th><th>Gender</th><th>Description</th><th>Orig Price</th><th>Notes</th>\n";
$rr=$conn->query($Sql2);
$selectPub = '<select name="publisher">';
  while($aRow = $rr->fetch_assoc()){
    $selectPub .= $aRow['idpublisher']."<option ";
    if($aRow["idpublisher"] == 11) {$selectPub .= "SELECTED ";}
    $selectPub .= "value=".$aRow['idpublisher'].">".$aRow['publisherName']."</option>";
    }
$selectPub .= "</select>";
    echo "<tr><td>".$selectPub . '</td>';
    echo "<td><input type=\"text\" size=\"4\" name=\"patternNum\" /></td>" ;
    echo "<td><input type=\"text\" size=\"4\" name=\"size\" /></td>";
    echo "<td><input type=\"text\" size=\"4\" name=\"bust\" /></td>";
    echo "<td><input type=\"text\" size=\"4\" name=\"waist\" /></td>";
    echo "<td><input type=\"text\" size=\"4\" name=\"hips\" /></td>";
    echo "<td><input type=\"text\" name=\"era\" /></td>";
    echo "<td><input type=\"text\" size=\"8\" name=\"Gender\" /></td>";
    echo "<td><input type=\"text\" name=\"desc\" /></td>";
    echo "<td><input type=\"text\" size=\"6\" name=\"op\" /></td>";
    echo "<td><input type=\"text\" name=\"notes\" /></td>";
    echo "</tr>\n";
#}
echo "</table>\n";
echo "<input type='hidden' name='add' value='1'></input>";
echo '<input type="submit" Value="Add pattern" />';
echo "</form>\n";
#}
echo "</body>\n";
echo "</html>";
$conn->close();
?>
