<?php
//###Define Facebook Application ID and Secret; then get cookie
define('FACEBOOK_APP_ID', '478174598904856');
define('FACEBOOK_SECRET', 'e7a9947ac59f9c5a264cd83f68689d80');
function get_facebook_cookie($app_id, $application_secret) {
  $args = array();
  parse_str(trim($_COOKIE['fbs_' . $app_id], '"'), $args);
  ksort($args);
  $payload = '';
  foreach ($args as $key => $value) {
    if ($key != 'sig') {
      $payload .= $key . '=' . $value;
    }
  }
  if (md5($payload . $application_secret) != $args['sig']) {
    return null;
  }
  return $args;
}
$cookie = get_facebook_cookie(FACEBOOK_APP_ID, FACEBOOK_SECRET);
echo $cookie;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:fb="http://www.facebook.com/2008/fbml">
<body>
<?php if ($cookie) {
//###cookie is set, user is logged in
$user = json_decode(file_get_contents('https://graph.facebook.com/me?access_token='.$cookie['access_token']));
//###display the user profile photo
echo '<img src="http://graph.facebook.com/'.$user->{'id'}.'/picture" alt="'.$user->{'name'}.'"/>';
echo '<br />';
//###display the user Facebook ID
echo '<b>Your Facebook ID:</b> '.$user->{'id'};
echo '<br />';
//###display the user Facebook name
echo '<b>Your name:</b> '.$user->{'name'};
echo '<br />';
//###display the user Facebook URL
echo '<b>Your Facebook URL:</b> '.$user->{'link'};
echo '<br />';
//###display the user Facebook about information
echo '<b>Your Facebook about information:</b> '.$user->{'about'};
echo '<br />';
//###display the user birthday
echo '<b>Your birthday:</b> '.$user->{'about'};
echo '<br />';
//###display the user bio in Facebook
echo '<b>Your bio in Facebook:</b> '.$user->{'bio'};
echo '<br />';
//###display the user gender
echo '<b>Your gender in Facebook:</b> '.$user->{'gender'};
echo '<br />';
//###display the user email address used in Facebook
echo '<b>Your email address used in Facebook:</b> '.$user->{'email'};
echo '<br />';
echo '<br />';
echo '<fb:login-button perms="email,user_birthday" onlogin="window.location.reload(true);" autologoutlink="true"></fb:login-button>';
}
else
{
//###user is not logged in, display the Facebook login button
echo '<h2>Facebook Application using Access token Key</h2>';
echo '<br />';
echo 'This is a more important script that will be able to grab the user email address, birthday and other information, such as profile photos.';
echo '<br />This information will be displayed in the web browser once the user has successfully logged in';
echo '<br /><br />';
echo '<fb:login-button perms="email,user_birthday" autologoutlink="true"></fb:login-button>';
}
?>
<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script>
FB.init({appId: '<?= FACEBOOK_APP_ID ?>', status: true,
cookie: true, xfbml: true});
FB.Event.subscribe('auth.login', function(response) {
window.location.reload();
});
</script>
</body>
</html>


Read more at http://www.devshed.com/c/a/PHP/Facebook-PHP-API-Applications-Working-with-User-Data/1/#gbhy1IyBcvhxbtYR.99 
