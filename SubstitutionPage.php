<?php
//start session
session_start();


require_once 'login.php';
require_once 'substitution.php';


function destroy_session_and_data() {
    $_SESSION = array();
    setcookie(session_name(), '', time() - 2592000, '/');
    session_destroy();
}

function sanitizeMySQL($connection, $var)
{
    $var = $connection->real_escape_string($var);
    $var = stripslashes($var);
    $var = strip_tags($var);
    $var = htmlentities($var, ENT_QUOTES);
    return $var;
}







if(isset($_SESSION['username'])) {

    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $email = $_SESSION['email'];

    $my_result = "";

    echo <<<_END
    
    <html>
    <style>
    
    body {font-family: Arial, Helvetica, sans-serif;}
    * {box-sizing: border-box}
    
    /* Full-width input fields */
    input[type=number], input[type=text]  {
      width: 100%;
      padding: 15px;
      margin: 5px 0 22px 0;
      display: inline-block;
      background: #f1f1f1;
    }
    
    input[type=text]:focus, input[type=password]:focus {
      background-color: #ddd;
      outline: none;
    }
    
    button:hover {
      opacity:1;
      background-color: red;
    }
    
    h3{
    color: rgb(0, 204, 255);
    }
    
    button{
      background-color:black;
      font-size: 15px;
      width: 23%;
      color: white;
      padding: 14px 20px; 
      border: none;
      cursor: pointer;
      opacity: 0.9;
    }
    
    a{
        color: white;
    }
    /* Add padding to container elements */
    .container {
      padding: 16px;
    }
    
    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }
    
    td, th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
     
     
    }
    
    tr:nth-child(even) {
      background-color: #dddddd;
    }
    
    .active { 
      background-color: #3498db;
      color: white;
      text-decoration: underline;
     
    }
    a:link {
      text-decoration: none;
    }
    </style>
    
    
    <script>
    function validate_encryption() {
        let plain = document.forms["fEncryption"]["etext"];
         
        //accept space and alphabets 
        let reg_plain = /^[a-zA-Z ]+$/;
        let reg_marker = /^\*$/;
         
        if (!reg_marker.test(plain.value) && !reg_plain.test(plain.value)) {
            window.alert("Only space and alphabets are allow for substitution cipher");
            return false;
        }
        return true;
    
    }
    function validate_decryption() {
        let cipher = document.forms["fDecryption"]["dtext"];
         
        //accept space and alphabets 
        let reg_cipher = /^[a-zA-Z ]+$/;
        let reg_marker = /^\*$/;
         
        if (!reg_marker.test(cipher.value) && !reg_cipher.test(cipher.value)) {
            window.alert("Only space and alphabets are allow for substitution cipher");
            return false;
        }
        return true;
    
    }
    </script>
    
    
    
    <body>
    <h2>Decryptoid</h2>
    Select cipher:
    <div class="tab">
        <button class="SubstitutionPage active" onclick="window.location.href = 'SubstitutionPage.php';"> <a href="SubstitutionPage.php"  >Substitution</a></button>
        <button class="DoubleTranspositionPage" onclick="window.location.href = 'DoubleTranspositionPage.php';"> <a href="DoubleTranspositionPage.php" >Double Transposition</a></button>
        <button class="RC4Page" onclick="window.location.href = 'RC4Page.php';"> <a href="RC4Page.php" >RC4</a></button>
        <button class="A51Page " onclick="window.location.href = 'A5_1Page.php';"> <a href="A5_1Page.php" >A5/1</a></button>
    <table>
      <tr>
        <td width="400">
        <h3>&nbsp&nbsp&nbsp Encryption</h3>
        <form name="fEncryption" action="SubstitutionPage.php" style="border:1px solid #ccc" method="post" enctype="multipart/form-data" onsubmit="return validate_encryption();" >
              <div class="container">
    
                <label for="plaintext"><b>Enter a plain text:</b></label><br>
                <input type="text" name="etext" placeholder="Plaintext (put * in this field if want to use upload file else this field will be choose as encrypt file)" name="plaintext" required>
                or
               <input type="file" name="eimage" accept=".txt" />
    
    
                <br><br>
                            <label for="shift"><b>Enter a shift value:</b></label><br>
                <input type="number" placeholder="0" name="eshift" min = "0" required><br><br>
    
                <button type="submit" class="encryptbtn" name="encryptbtn">Encrypt</button>
              <!--                <br><br>-->
<!--               <label for="result"><b>Result</b></label><br>-->
<!--                <textarea name="eresult" row= "4" cols= "60" >-->
<!--                $my_result-->
<!--               </textarea>-->
              </div>
        </form>
       </td>
         <td width="400">
        <h3>&nbsp&nbsp&nbsp Decryption</h3>
        <form name="fDecryption" action="SubstitutionPage.php" style="border:1px solid #ccc" method="post"  enctype="multipart/form-data" onsubmit="return validate_decryption();" >
              <div class="container">
    
                <label for="ciphertext"><b>Enter a cipher text:</b></label><br>
                <input type="text" name="dtext" placeholder="Cipher text (put * in this field if want to use upload file else this field will be choose as decrypt file)" name="ciphertext" required>
                or
                <input type="file" name="dimage" accept=".txt" />
    
    
                <br><br>
                           <label for="shift"><b>Enter a shift value:</b></label><br>
                <input type="number" placeholder="0" name="dshift" min = "0" required><br><br>
    
                <button type="submit" class="decryptbtn" name="decryptbtn">Decrypt</button>

              </div>
        </form>
       </td>
    </tr>
      
    </table>
   
    </div>
    
    
    </body>
    </html>
_END;



    //connect to mysql
    $conn = new mysqli($hn, $un, $pw, $db);
    if($conn->connect_error) die($conn->connect_error);

    $query = "SELECT * FROM A5Table_contents";
    $result = $conn->query($query);


    //if encryption button is clicked
    if (isset($_POST['encryptbtn'])) {

        //server side check
        if( preg_match("/^\*$/", $_POST['etext']) or preg_match("/^[a-zA-Z ]+$/", $_POST['etext'])) {

            $ciper_type = "Substitution Cipher Encryption";
            $sub_e_text = sanitizeMySQL($conn, $_POST['etext']);
            $sub_e_shift = sanitizeMySQL($conn, $_POST['eshift']);

            //Upload file is selected, if upload file exist and text field is *
            if ($_FILES and $_POST['etext'] == "*") {
                //open file
                $f_name = $_FILES['eimage']['name'];
                move_uploaded_file($_FILES['eimage']['tmp_name'], $f_name);

                if (!file_exists($f_name)){
                    echo "<script type='text/javascript'>alert('No upload file is selected');</script>";
                    die("File does not exist");
                }

                //check upload file
                if(!preg_match("/^[a-zA-Z ]+$/", file_get_contents($f_name)))
                    die("<script type='text/javascript'>alert('Upload file: Only space and alphabets are allow for substitution cipher');</script>");

                //sanitized the file content
                //replace the content with upload content
                $sub_e_text = sanitizeMySQL($conn, file_get_contents($f_name));
            }



            //echo $sub_e_text;
            $my_result =$sub_e_text;

            $my_result_converted = sub_cipher_encryption($sub_e_text, $sub_e_shift);

            //print result
            print"<lable>";
            echo "<span style='margin-left: 2%'><strong><span style='color:rgb(0, 204, 255);'>Result</span></span></strong>";
            // echo "&nbsp&nbsp&nbsp&nbsp&nbsp<strong>Result</strong>";
            echo"<br>";
            print"</lable>";
            print"&nbsp&nbsp&nbsp&nbsp&nbsp<textarea name = 'eresult' row = '4' cols = '77' style='font-size: 15px'>";
            echo $my_result_converted;
            print"</textarea>";
            echo "<br><br>";

            if ($result) {
                //INSERT STEP
                $query = "INSERT INTO A5Table_contents VALUES(NULL, '$ciper_type', '$sub_e_text', '$email', NULL)";
                $result = $conn->query($query);
                if (!$result) die("Database access failed:" . $conn->error);
            } else { //if table not exist, create the table
                $query = "CREATE TABLE A5Table_contents(
                          id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT KEY,
                          ciper VARCHAR(32) NOT NULL,
                          content LONGTEXT NOT NULL,
                          email VARCHAR (32) NOT NULL,
                          timesp TIMESTAMP NOT NULL
                          )";

                $result = $conn->query($query);
                if (!$result){
                    echo "<script type='text/javascript'>alert('No upload file is selected');</script>";
                    die("File does not exist");
                }

                //INSERT STEP
                $query = "INSERT INTO A5Table_contents VALUES(NULL, '$ciper_type', '$sub_e_text', '$email', NULL)";
                $result = $conn->query($query);
                if (!$result) die("Database access failed:" . $conn->error);
            }

        }//server side encryptinon validate input end
        else
            echo "<script type='text/javascript'>alert('Only space and alphabets are allow for substitution cipher');</script>";


//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    }//if decrypt button is clicked
    else if (isset($_POST['decryptbtn'])) {

        //server side check
        if( preg_match("/^\*$/", $_POST['dtext']) or preg_match("/^[a-zA-Z ]+$/", $_POST['dtext'])) {

            $ciper_type = "substitution cipher Decryption";
            $sub_d_text = sanitizeMySQL($conn, $_POST['dtext']);
            $sub_d_shift = sanitizeMySQL($conn, $_POST['dshift']);

            //Upload file is selected, if upload file exist and text field is *
            if ($_FILES and $_POST['dtext'] == "*") {
                //open file
                $f_name = $_FILES['dimage']['name'];
                move_uploaded_file($_FILES['dimage']['tmp_name'], $f_name);

                if (!file_exists($f_name)) {
                    echo "<script type='text/javascript'>alert('No upload file is selected');</script>";
                    die("File does not exist");
                }

                //check upload file
                if(!preg_match("/^[a-zA-Z ]+$/", file_get_contents($f_name)))
                    die("<script type='text/javascript'>alert('Upload file: Only space and alphabets are allow for substitution cipher');</script>");

                //sanitized the file content
                //replace the content with upload content
                $sub_d_text = sanitizeMySQL($conn, file_get_contents($f_name));
            }



            //echo $sub_d_text;
            $my_result =$sub_d_text;

            $my_result_converted = sub_cipher_decryption($sub_d_text, $sub_d_shift);

            print"<lable>";
            echo "<span style='margin-left: 52%'><strong><span style='color:rgb(0, 204, 255);'>Result</span></span></strong>";
            echo"<br>";
            print"</lable>";

            print"<span style='margin-left: 52%' ><textarea name = 'dresult' row = '4' cols = '77' style='font-size: 15px'>";
            echo $my_result_converted;
            print"</textarea></span>";
            echo "<br><br>";

            //if table exist, add the content
            if ($result) {
                //INSERT STEP
                $query = "INSERT INTO A5Table_contents VALUES(NULL, '$ciper_type', '$sub_d_text', '$email', NULL)";
                $result = $conn->query($query);
                if (!$result) die("Database access failed:" . $conn->error);
            } else { //if table not exist, create the table
                $query = "CREATE TABLE A5Table_contents(
                          id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT KEY,
                          ciper VARCHAR(32) NOT NULL,
                          content LONGTEXT NOT NULL,
                          email VARCHAR (32) NOT NULL,
                          timesp TIMESTAMP NOT NULL
                          )";

                $result = $conn->query($query);
                if (!$result) die("Database access failed:" . $conn->error);

                //INSERT STEP
                $query = "INSERT INTO A5Table_contents VALUES(NULL, '$ciper_type', '$sub_d_text', '$email', NULL)";
                $result = $conn->query($query);
                if (!$result) die("Database access failed:" . $conn->error);
            }

        }//server side decryption validate input end
        else
            echo "<script type='text/javascript'>alert('Only space and alphabets are allow for substitution cipher');</script>";

    }
    echo<<<_logout
    <html>
    <body>
     <button style="width: 144px ; margin-left: 2%"> <a href="Logout.php" class="logout">Logout</a></button>
    </body>
    </html>
_logout;

}
else header("location: A5_authenticate1.php");




?>