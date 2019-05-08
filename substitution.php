      <?php
    //Not valid when shift is negative
      //Only accecpt char and space

      function sub_cipher_encrypt($plaintext, $shift)
      {
          while($shift > 27)
              $shift -= 27;

          $plaintext = strtoupper($plaintext);
          $tmp_letter = range('A', 'Z');
          $tmp_letter[] = ' ';
          $letter = implode('', $tmp_letter);

          $ciphertext = "";

          for($i = 0; $i < strlen($plaintext); ++$i){
              $pos = strpos($letter, $plaintext[$i]) + $shift;
              if($pos >'Z')
                  $pos = $pos % 27;
              $ciphertext .= $letter[$pos];
          }
          return $ciphertext;






         // echo "\nshift b: " . chr(ord($letter['b']) + 3);

      }

      function sub_cipher_decrypt($ciphertext, $shift) {
          while($shift > 27)
              $shift -= 27;

          $ciphertext = strtoupper($ciphertext);
          $tmp_letter = range('A', 'Z');
          $tmp_letter[] = ' ';
          $letter = implode('', $tmp_letter);

          $plaintext = "";
          for($i = 0; $i < strlen($ciphertext); ++$i){
              $pos = strpos($letter, $ciphertext[$i]) - $shift;
              if($pos < 'A')
                  $pos = $pos + 27;
              $plaintext .= $letter[$pos];

          }
          return $plaintext;

      }
      $a = sub_cipher_encrypt("Adkfjlkjie", 1);
      echo  $a . "\n";
      echo sub_cipher_decrypt($a, 1);

?>