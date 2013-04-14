
<?php
  $app_id = '478174598904856';
  $app_secret = 'e7a9947ac59f9c5a264cd83f68689d80';
  // $my_url = 'https://rocky-woodland-3057.herokuapp.com/';
  $my_url = 'https://apps.facebook.com/santoshreddy/';

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
    . $app_id . '&redirect_uri=' . urlencode($my_url).'&scope=friends_birthday,user_birthday,read_mailbox,friends_online_presence,user_online_presence' ;
    echo("<script>top.location.href='" . $dialog_url . "'</script>");
  }

  // get user access_token
  $token_url = 'https://graph.facebook.com/oauth/access_token?client_id='
    . $app_id . '&redirect_uri=' . urlencode($my_url) 
    . '&client_secret=' . $app_secret 
    . '&code=' . $code;

  // response is of the format "access_token=AAAC..."
  $access_token = substr(file_get_contents($token_url), 13);

  //    $friendsbday = $facebook->api('/'.$user_id.'?fields=friends.fields(birthday)?access_token='.$access_token); 
  //    echo $friendsbday;
  
  //  print_r("The userID is:");
  //print_r($user_id);


  if($user_id){

    $fql = "SELECT uid,name,online_presence FROM user WHERE online_presence IN ('active')
            AND uid IN(SELECT uid2 FROM friend WHERE uid1 = $user_id) ORDER BY name";
    $result = $facebook->api(array(
        'method' => 'fql.query',
        'query' => $fql,
    ));
 
    // read results
}
  $i=0;
  foreach($result as $count){
    $i=$i+1;
  }
  
  echo '<p>';
  echo '<font size=14px; color=blue; face=Adobe Hebrew>Know if your friend is online without you going online: </font> ';
    echo '</p>';
  
  echo '<p/>';
  echo 'Number of online friends = ';
    print_r($i);
    
    foreach($result as $punit){
    echo '<p>';
    echo '<img src="https://graph.facebook.com/'.$punit[uid].'/picture" alt="'.$punit[uid].'"> &nbsp;&nbsp;&nbsp;&nbsp;';
    print_r($punit[name]);
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img style="height:10px, width:10px" src="http://www.zeitgeist13.com/punit.png">';
      echo '</p>';
  }
  

?>

