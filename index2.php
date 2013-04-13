<?php

  require_once('php-sdk/src/facebook.php');

  $config = array(
    'appId' => '478174598904856',
    'secret' => 'e7a9947ac59f9c5a264cd83f68689d80',
  'sharedSession' => true,
  'trustForwarded' => true,
  );

  $facebook = new Facebook($config);
  $user_id = $facebook->getUser();

print_r($user_id);
 
$access_token = $facebook->getAccessToken();

?>
<html>
  <head></head>
  <body>

  <?php
    if($user_id) {

$friends = $facebook->api('/'.$user_id.'/friends');
                $friendsList = array();
                foreach ($friends as $key=>$value) 
                {
                   foreach ($value as $fkey=>$fvalue) {

                       $friendsList[] = $fvalue[id];
//print_r($friendsList);
$fname= $facebook->api('/'.$fvalue[id].'?fields=name');  
print_r($fname);    
$fpic= $facebook->api('/'.$fvalue[id].'?fields=birthday');  
 print_r($fpic);               
                     
                   }

                }  
      
      
      
              


  //Create Query
  $params = array(
      'method' => 'fql.query',
      'query' => "SELECT uid, pic, pic_square, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = 111111111)",
  );

  //Run Query
  $result = $facebook->api($params);

      
      
    } else {

      // No user, print a link for the user to login
      $login_url = $facebook->getLoginUrl(array(
                'scope'         => 'email,offline_access,publish_stream,user_birthday,user_location,user_work_history,user_about_me,user_hometown'
            ));
       echo 'Please <a href="' . $login_url . '">login.</a>';

    }

  ?>

  </body>
</html>
