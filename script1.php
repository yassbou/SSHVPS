<?php

function generateString($strength = 10) {
    $input = '@0123456789abcdefghijklmnopqrstuvwxyz@ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
    return $random_string;
}

?>
<?php
$panel_url = 'http://93.114.128.118:25461/';
$username = generateString(10);
$password = generateString(10);
$max_connections = 1; 
$restreamer = 0; //allow restream 0 no 1 yes
$reseller = 2; //set with reseller id
$is_trial = 0; //set 0 or 1 

$bouquet_ids = array(1,2,3,4 );//add bouquet id 
$expire_date = strtotime( "+24 hour" );

###############################################################################
$post_data = array( 'user_data' => array(
'username' => $username,
'password' => $password,
'max_connections' => $max_connections,
'is_restreamer' => $restreamer,
'member_id' => $reseller,
'created_by' => $reseller,
'is_trial' => $is_trial,
'exp_date' => $expire_date,
'bouquet' => json_encode( $bouquet_ids ) ) );

$opts = array( 'http' => array(
'method' => 'POST',
'header' => 'Content-type: application/x-www-form-urlencoded',
'content' => http_build_query( $post_data ) ) );

$context = stream_context_create( $opts );
$api_result = json_decode( file_get_contents( $panel_url . "api.php?action=user&sub=create", false, $context ) );
$obj = $api_result;
$name = $obj->{'username'};
$pass = $obj->{'password'};

echo $panel_url . "get.php?username=".$name."&password=".$pass."&type=m3u_plus&output=mpegts";
?>