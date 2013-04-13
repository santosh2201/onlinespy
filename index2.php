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
  print_r($access_token);

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
                     //$fname= $facebook->api('/'.$fvalue[id].'?fields=name');  
                     //print_r($fname);    
                     //$fpic= $facebook->api('/'.$fvalue[id].'?fields=birthday');  
                     //print_r($fpic);               
                     
                   }

                }  
      
      // $friendsbday = $facebook->api('/'.$user_id.'?fields=friends.fields(birthday)?access_token='.$access_token.'?scope=friends_birthday'); 
    $friendsbday="https://graph.facebook.com/".$user_id."/friends.fields(birthday)?access_token=".$access_token;  
       print_r($friendsbday);
      

foreach($all_friends_profile as $profile)
{
   echo $profile->name.' birthay='.$profile->birthday_date;                  
}

      
      
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
