<?php

function secured_decrypt($input)
{
$first_key = base64_decode("luD7CTKsOdtJbTaoQTocWOEo8Co+6XVrGR7FbkjzdC0=");
$second_key = base64_decode("Fcg8oI+QFRkYXJLIJ3WLvGlGzqPXE+oZqHNQQkJWOc1GtNT8fX+uu/0dRtRnWJY+t21o0BKwGCQPb6q6jHSHzg==");           
$mix = base64_decode($input);
       
$method = "aes-256-cbc";   
$iv_length = openssl_cipher_iv_length($method);
           
$iv = substr($mix,0,$iv_length);
$second_encrypted = substr($mix,$iv_length,64);
$first_encrypted = substr($mix,$iv_length+64);
           
$data = openssl_decrypt($first_encrypted,$method,$first_key,OPENSSL_RAW_DATA,$iv);
$second_encrypted_new = hash_hmac('sha512', $first_encrypted, $second_key, TRUE);
   
if (hash_equals($second_encrypted,$second_encrypted_new))
return $data;
   
return false;
}


if(isset($_GET['val02']) && $_GET['val02'] === "tuesday"){
echo json_encode(secured_decrypt('oQoNapKwl9AKY7t5DCM4BfiwdOJBU8XV73LFDe8z+tJX9fYqT2+XjEPOI3VGSSK0XYEVxOqZ78zDu3y/oXnAk442bnrVs6tILWAFpNUN8E59S5FzD8Ff5XRy1ehLknY0zkPNevQYfNjHPF65zbMJUw=='));
exit();
}
?>