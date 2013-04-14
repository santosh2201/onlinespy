
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
  
  /*  
  $fql = 'SELECT uid, name, online_presence, status FROM user WHERE uid IN ( SELECT uid2 FROM friend WHERE uid1 ='.$user_id.' )' ;
$active = $this->facebook->api(array(
  'method' => 'fql.query',
  'query' =>$fql
));
  $fql_query_result = file_get_contents($active);
  $fql_query_obj = json_decode($fql_query_result, true);
    echo '<pre>';
  print_r("query results:");
  print_r($fql_query_obj);
  echo '</pre>';
  */  
  $params = array(
        'method' => 'fql.query',
        'query' => "SELECT uid, name, online_presence, status FROM user WHERE uid IN ( SELECT uid2 FROM friend WHERE uid1 ='.$user_id.' )",
    );
    //Run Query
    $result = $facebook->api($params);
    print_r("query results:");
    print_r($result);

?>

  
  
  /* 
  $fql_query_url = 'https://graph.facebook.com/'
    . 'fql?q=SELECT uid, name, online_presence FROM user WHERE uid='.$user_id.' )'
    . '&access_token=' . $access_token;
  $fql_query_result = file_get_contents($fql_query_url);
  $fql_query_obj = json_decode($fql_query_result, true);

  // display results of fql query
  echo '<pre>';
  print_r("query results:");
  print_r($fql_query_obj);
  echo '</pre>';
  */
  
  
?>


