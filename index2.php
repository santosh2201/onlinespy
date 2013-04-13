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


<?php
  $app_id = '478174598904856';
  $app_secret = 'e7a9947ac59f9c5a264cd83f68689d80';
  $my_url = 'https://rocky-woodland-3057.herokuapp.com/';

  $code = $_REQUEST["code"];


  require_once('php-sdk/src/facebook.php');

  $config = array(
    'appId' => '478174598904856',
    'secret' => 'e7a9947ac59f9c5a264cd83f68689d80',
  'sharedSession' => true,
  'trustForwarded' => true,
  );

  $facebook = new Facebook($config);
  $user_id = $facebook->getUser();



 // auth user
 if(empty($code)) {
    $dialog_url = 'https://www.facebook.com/dialog/oauth?client_id=' 
    . $app_id . '&redirect_uri=' . urlencode($my_url) ;
    echo("<script>top.location.href='" . $dialog_url . "'</script>");
  }

  // get user access_token
  $token_url = 'https://graph.facebook.com/oauth/access_token?client_id='
    . $app_id . '&redirect_uri=' . urlencode($my_url) 
    . '&client_secret=' . $app_secret 
    . '&code=' . $code
    .'&scope=friends_birthday,user_birthday,read_mailbox';

  // response is of the format "access_token=AAAC..."
  $access_token = substr(file_get_contents($token_url), 13);




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
      
      $friendsbday = $facebook->api('/'.$user_id.'?fields=friends.fields(birthday)?access_token='.$access_token); 
       echo $friendsbday;

      // https://graph.facebook.com/oauth/authorize?type=user_agent&client_id=123456789123456&redirect_uri=http%3A%2F%2Fwww.example.com&scope=read_stream,manage_pages,offline_access,user_photos
      
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
