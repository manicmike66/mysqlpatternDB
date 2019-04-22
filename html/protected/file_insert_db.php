<html>
<head><title>File Insert</title></head>
<body>
<h3>Please Choose a File and click Submit</h3>

<h2><a href="../index2.php">Return to index</a></h2>
<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']."?id=".$_GET['ID']?>" method="post">
<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
<input name="userfile" type="file" />
<input type="submit" value="Submit" />
</form>

<?php
// check if a file was submitted
if(!isset($_FILES['userfile']))
{
    echo '<p>Please select a file</p>';
}
else
{
    try {
    $msg= upload();  //this will upload your image
    echo $msg;  //Message showing success or failure.
    }
    catch(Exception $e) {
    echo $e->getMessage();
    echo 'Sorry, could not upload file';
    }
}

// the upload function

function upload() {
#    include "../file_constants.php";
    $maxsize = 10000000; //set to approx 10 MB

    //check associated error code
    if($_FILES['userfile']['error']==UPLOAD_ERR_OK) {

        //check whether file is uploaded with HTTP POST
        if(is_uploaded_file($_FILES['userfile']['tmp_name'])) {    

            //checks size of uploaded image on server side
            if( $_FILES['userfile']['size'] < $maxsize) {  
  
               //checks whether uploaded file is of image type
              //if(strpos(mime_content_type($_FILES['userfile']['tmp_name']),"image")===0) {
                 $finfo = finfo_open(FILEINFO_MIME_TYPE);
                if(strpos(finfo_file($finfo, $_FILES['userfile']['tmp_name']),"image")===0) {    

                    // prepare the image for insertion
                    $imgData = addslashes (file_get_contents($_FILES['userfile']['tmp_name']));
		    $es_data = pg_escape_bytea($imgData);

                    // put the image in the db...
                    // database connection
$config = parse_ini_file('../includes/creds2.ini');
$conn_string = "host=".$config['DBServer']." port=5432 dbname=".$config['DBName']." user=".$config['DBUser']." password=".$config['DBPass'];
$dbconn = pg_connect($conn_string);
if (!$dbconn) {
  trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
}

                    // our sql query
                    $sql = "UPDATE pattern
                    SET patternpicture=
                    ('{$es_data}')
		WHERE idpattern=".$_GET['id'].";";
                    // insert the image
$rs = pg_query($sql) or die('query failed: ' .pg_last_error());
#if($rs == false) {
#  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
#} 
$msg='<p>Image successfully saved in database. </p>';
                }
#                else
#                    $msg="<p>Uploaded file is not an image.</p>";
            }
             else {
                // if the file is not less than the maximum allowed, print an error
                $msg='<div>File exceeds the Maximum File limit</div>
                <div>Maximum File limit is '.$maxsize.' bytes</div>
                <div>File '.$_FILES['userfile']['name'].' is '.$_FILES['userfile']['size'].
                ' bytes</div><hr />';
                }
        }
        else
            $msg="File not uploaded successfully.";

    }
    return $msg;
    pg_close($dbconn);
}

?>
</body>
</html>
