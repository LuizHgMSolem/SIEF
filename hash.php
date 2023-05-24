<?php
$valorsetado= ["setar" => "valor indefinido", "setar2" => "valor indefini"];
$hashed_expected = hash_hmac('sha256',$valorsetado["setar"] , "encript");
 
$hashed_value = hash_hmac('sha256',$valorsetado["setar2"] , "encript");

// if (hash_equals($hashed_expected,$hashed_value)) {
//   echo "hash matchs";
// }

// if (md5($hashed_value) === md5($hashed_expected)) {
//   echo "<br>transform information useles <br> hash match?";
// }else{
//   echo "The hash does not Match!";
// }

// // comparin a hole string

// if (hash_compare($hashed_value, $hashed_expected)) {
//   echo "<br><br>Implementing information into function created by developer <br>";
//   echo "hash match!";
// }

// function hash_compare($valorA, $valorB){
//   if (!is_string($valorA) || !is_string($valorB)){
//     return false; 
//   }

//   $length = strlen($valorA);
//   if ($length !==  strlen($valorB)){
//     return false;
//   }
  
//   for ($i=0; $i < $length; $i++) { 
//     $status = ord($valorA[$i]) ^ ord(($valorB[$i]));
//   }
//   return $status === 0;
// }



function custom_hmac($algo, $data, $key, $raw_output = false)
{
  $algo = strtolower($algo);
  $pack = 'H'.strlen($algo('test'));
  $size = 64;
  $opad = str_repeat(chr(0x5c), $size);
  $ipad = str_repeat(chr(0x36), $size);

  if (strlen($key) > $size){
    $key = str_pad(pack($algo($key)), $size, chr(0x00));
  }else{
    $key = str_pad($key,$size, chr(0x00));
  }

  for ($i=0; $i < strlen($key); $i++) { 
    $opad[$i] =  $opad[$i] ^ $key[$i];
    $ipad[$i] =  $ipad[$i] ^ $key[$i];
  }

  $output = $algo($opad.pack($pack, $algo($ipad.$data)));

  return ($raw_output) ? pack($pack, $output) : $output;
}




if (custom_hmac("sha1", "organizating a cript info that dosn t have suport", "CriptUnsuportable", true)) {
  echo "Ok";
}


?>