



<?php
  //Get Facebook SDK Object
  $config = array(
    'appId'  => '478174598904856',
    'secret' => 'e7a9947ac59f9c5a264cd83f68689d80',
    'cookie' => true,
  );

  $facebook = new Facebook($config);

  //Create Query
  $params = array(
      'method' => 'fql.query',
      'query' => "SELECT uid, pic, pic_square, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = me())",
  );

  //Run Query
  $result = $facebook->api($params);
  print_r($result);
?>