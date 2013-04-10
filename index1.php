<?php
  // Remember to copy files from the SDK's src/ directory to a
  // directory in your application on the server, such as php-sdk/
  require_once('php-sdk/src/facebook.php');

  $config = array(
    'appId' => '478174598904856',
    'secret' => 'e7a9947ac59f9c5a264cd83f68689d80',
  'sharedSession' => true,
  'trustForwarded' => true,
  );

  $facebook = new Facebook($config);
  $user_id = $facebook->getUser();


 
//get the user's access token
$access_token = $facebook->getAccessToken();
 /*
//check permissions list
$permissions_list = $facebook->api(
   '/me/permissions',
   'GET',
   array(
      'access_token' => $access_token
   )
);
print_r($permissions_list);
*/
?>
<html>
  <head></head>
  <body>

  <?php
    if($user_id) {
  $friends = $facebook->api('/me/friends', 'GET', array('access_token' => $access_token));
echo $friends['id'];
      // We have a user ID, so probably a logged in user.
      // If not, we'll get an exception, which we handle below.
      try {

        $user_profile = $facebook->api('/me','GET',array(
      'access_token' => $access_token,
      'scope' => 'email,offline_access,publish_stream,user_birthday,user_location,user_work_history,user_about_me,user_hometown'
   ));
        echo "Name: " . $user_profile['name'];
    echo "Name: " . $user_profile['birthday'];
echo "Name: " . $user_profile['id'];
  } catch(FacebookApiException $e) {
        // If the user is logged out, you can have a 
        // user ID even though the access token is invalid.
        // In this case, we'll get an exception, so we'll
        // just ask the user to login again here.
        $login_url = $facebook->getLoginUrl(); 
        echo 'Please <a href="' . $login_url . '">login.</a>';
        error_log($e->getType());
        error_log($e->getMessage());
      }   
    } else {

      // No user, print a link for the user to login
      $login_url = $facebook->getLoginUrl();
      echo 'Please <a href="' . $login_url . '">login.</a>';

    }

  ?>

  </body>
</html>
