<?php
  $backend = "http://127.0.0.1:8585/svg"; //config yourself
  $dot_request = rawurldecode($_SERVER['QUERY_STRING']);
  // Add filtering here

  header('Content-type: image/svg+xml');
  
  // Check if picture exist in cache and return it if so else:
  //code not submitted to repo
  
  if (!$picture){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $backend);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dot_request);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $picture = curl_exec($ch);
    curl_close($ch);
    
    //save picture to cache
    //code not submitted to repo

    header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + (60 * 60)));
  }

  echo $picture;
?>
