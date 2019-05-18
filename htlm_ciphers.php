<?php
/**
 * Created by PhpStorm.
 * User: andyt
 * Date: 5/9/2019
 * Time: 5:02 PM
 */

echo <<<_END
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {font-family: Arial;}

        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        }

        /* Style the buttons inside the tab */
        .tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            font-size: 17px;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current tablink class */
        .tab button.active {
            background-color: #ccc;
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
        }
        /*for substitution*/
        /* Full-width input fields */
        input[type=number], input[type=text]  {
            width:90%;
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
        }
        h3{
            color: rgb(0, 204, 255);
        }

        .container #input[type =submit]{
            width: 50%;
            background-image: linear-gradient(to right, rgba(102, 224, 255), rgba(0, 184, 230));
            color: white;
            padding: 14px 20px;
            border: none;
            cursor: pointer;
            opacity: 0.9;

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
    </style>
</head>
<body>

<h2>Decryptoid</h2>
Select cipher:
<div class="tab">
    <button class="tablinks" onclick="openCity(event, 'Substitution')">Substitution</button>
    <button class="tablinks" onclick="openCity(event, 'Double Transposition')">Double Transposition</button>
    <button class="tablinks" onclick="openCity(event, 'RC4')">RC4</button>
    <button class="tablinks" onclick="openCity(event, 'A5/1')">A5/1</button>
</div>

<div id="Substitution" class="tabcontent">
    <table>
        <tr>
            <td width="400">
                <h3>Encryption</h3>
                <form action="htlm_ciphers.php" style="border:1px solid #ccc" >
                    <div class="container">

                        <label for="plaintext"><b>Enter a plain text:</b></label><br>
                        <input type="text" placeholder="Plain text" name="sub_encrypt_plaintext" required>
                        or
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="file" name="image" accept=".txt" />

                        </form>
                        <br><br>
                        <label for="shift"><b>Enter a shift value:</b></label><br>
                        <input type="number" placeholder="0" name="sub_encrypt_shift" min = "0" required><br><br>

                        <button type="submit" class="encryptbtn">Encrypt</button>
                        <br><br>
                        <label for="result"><b>Result</b></label><br>
                        <textarea row= "4" cols= "54" >

			</textarea>
                    </div>
                </form>
            </td>
            <td width="400">
                <h3>Decryption</h3>
                <form action="substitution.php" style="border:1px solid #ccc" >
                    <div class="container">

                        <label for="ciphertext"><b>Enter a cipher text:</b></label><br>
                        <input type="text" placeholder="Cipher text" name="sub_decrypt_plaintext" required>
                        or
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="file" name="image" accept=".txt"/>

                        </form>
                        <br><br>
                        <label for="shift"><b>Enter a shift value:</b></label><br>
                        <input type="number" placeholder="0" name="sub_decrypt_shift" min = "0" required><br><br>

                        <button type="submit" class="decryptbtn">Decrypt</button>
                        <br><br>
                        <label for="result"><b>Result</b></label><br>
                        <textarea row= "4" cols= "54" >

			</textarea>
                    </div>
                </form>
            </td>
        </tr>

    </table>
</div>

<div id="Double Transposition" class="tabcontent">
    <table>
        <tr>
            <td width="400">
                <h3>Encryption</h3>
                <form action="DoubleTransposition.php" style="border:1px solid #ccc" >
                    <div class="container">
                        <label for="column"><b>Enter number of Columns:</b></label><br>
                        <input type="number" placeholder="Number of Column" name="column" min = "0" required>
                        <br>
                        <label for="plaintext"><b>Enter a plain text:</b></label><br>
                        <input type="text" placeholder="Plain text" name="plaintext" required>
                        or
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="file" name="image" accept=".txt"/>

                        </form>
                        <br><br>

                        <button type="submit" class="encryptbtn">Encrypt</button>
                        <br><br>
                        <label for="result"><b>Result</b></label><br>
                        <textarea row= "4" cols= "54" >
			</textarea>
                    </div>
                </form>
            </td>
            <td width="400">
                <h3>Decryption</h3>
                <form action="DoubleTransposition.php" style="border:1px solid #ccc" >
                    <div class="container">
                        <label for="column"><b>Enter number of Columns:</b></label><br>
                        <input type="number" placeholder="Number of Column" name="column" min = "0" required>
                        <br>
                        <label for="ciphertext"><b>Enter a cipher text:</b></label><br>
                        <input type="text" placeholder="Cipher text" name="ciphertext" required>
                        or
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="file" name="image" accept=".txt" />

                        </form>
                        <br><br>
                        <button type="submit" class="decryptbtn">Decrypt</button>
                        <br><br>
                        <label for="result"><b>Result</b></label><br>
                        <textarea row= "4" cols= "54" >

			</textarea>
                    </div>
                </form>
            </td>
        </tr>

    </table>

</div>


<div id="RC4" class="tabcontent">
    <table>
        <tr>
            <td width="400">
                <h3>Encryption</h3>
                <form action="RC4.php" style="border:1px solid #ccc" >
                    <div class="container">

                        <label for="plaintext"><b>Enter a plain text:</b></label><br>
                        <input type="text" placeholder="Plain text" name="plaintext" required>
                        or
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="file" name="image" accept=".txt"/>

                        </form>
                        <br><br>
                        <label for="shift"><b>Enter key:</b></label><br>
                        <input type="text" placeholder="Enter key" name="key" required>
                        or
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="file" name="image" accept=".txt" />

                        </form>
                        <br>
                        <button type="submit" class="encryptbtn">Encrypt</button>
                        <br><br>
                        <label for="result"><b>Result</b></label><br>
                        <textarea row= "4" cols= "54" >
			</textarea>
                    </div>
                </form>
            </td>
            <td width="400">
                <h3>Decryption</h3>
                <form action="RC4.php" style="border:1px solid #ccc" >
                    <div class="container">

                        <label for="ciphertext"><b>Enter a cipher text:</b></label><br>
                        <input type="text" placeholder="Cipher text" name="ciphertext" required>
                        or
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="file" name="image" accept=".txt" />

                        </form>
                        <br><br>
                        <label for="shift"><b>Enter key:</b></label><br>
                        <input type="text" placeholder="Enter key" name="key" required>
                        or
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="file" name="image" accept=".txt"/>

                        </form>  <br>
                        <button type="submit" class="decryptbtn">Decrypt</button>
                        <br><br>
                        <label for="result"><b>Result</b></label><br>
                        <textarea row= "4" cols= "54" >

			</textarea>
                    </div>
                </form>
            </td>
        </tr>

    </table>

</div>

<div id="A5/1" class="tabcontent">
    <table>
        <tr>
            <td width="400">
                <h3>Encryption</h3>
                <form action="A5/1.php" style="border:1px solid #ccc" >
                    <div class="container">

                        <label for="plaintext"><b>Enter a plain text:</b></label><br>
                        <input type="text" placeholder="Plain text" name="plaintext" required>
                        or
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="file" name="image" accept=".txt"/>

                        </form>
                        <br><br>

                        <button type="submit" class="encryptbtn">Encrypt</button>
                        <br><br>
                        <label for="result"><b>Result</b></label><br>
                        <textarea row= "4" cols= "54" >
			</textarea>
                    </div>
                </form>
            </td>
            <td width="400">
                <h3>Decryption</h3>
                <form action="A5/1.php" style="border:1px solid #ccc" >
                    <div class="container">

                        <label for="ciphertext"><b>Enter a cipher text:</b></label><br>
                        <input type="text" placeholder="Cipher text" name="ciphertext" required>
                        or
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="file" name="image" accept=".txt"/>

                        </form>
                        <br><br>
                        <button type="submit" class="decryptbtn">Decrypt</button>
                        <br><br>
                        <label for="result"><b>Result</b></label><br>
                        <textarea row= "4" cols= "54" >

			</textarea>
                    </div>
                </form>
            </td>
        </tr>
    </table>




</div>
    <br><br>
    <button type="submit" name="signout" value="signout">Sign Out</button>

<script>
    function openCity(evt, cipher) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cipher).style.display = "block";
        evt.currentTarget.className += " active";
    }
    


</script>

</body>
</html>
_END;


if (isset($_POST['encryptbtn']))
    echo "YEESS";

echo "hi";



?>
