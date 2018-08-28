<?php

$backend = 'http://127.0.0.1:8586/svg;
function encodep($text){
    $data       = utf8_encode($text);
    $compressed = gzdeflate($data, 9);
    return encode64($compressed);
}

function encode6bit($b){
    if ($b < 10) {
        return chr(48 + $b);
    }
    $b -= 10;
    if ($b < 26) {
        return chr(65 + $b);
    }
    $b -= 26;
    if ($b < 26) {
        return chr(97 + $b);
    }
    $b -= 26;
    if ($b == 0) {
        return '-';
    }
    if ($b == 1) {
        return '_';
    }
    return '?';
}

function append3bytes($b1, $b2, $b3){
    $c1 = $b1 >> 2;
    $c2 = (($b1 & 0x3) << 4) | ($b2 >> 4);
    $c3 = (($b2 & 0xF) << 2) | ($b3 >> 6);
    $c4 = $b3 & 0x3F;
    $r  = "";
    $r .= encode6bit($c1 & 0x3F);
    $r .= encode6bit($c2 & 0x3F);
    $r .= encode6bit($c3 & 0x3F);
    $r .= encode6bit($c4 & 0x3F);
    return $r;
}

function encode64($c){
    $str = "";
    $len = strlen($c);
    for ($i = 0; $i < $len; $i += 3) {
        if ($i + 2 == $len) {
            $str .= append3bytes(ord(substr($c, $i, 1)), ord(substr($c, $i + 1, 1)), 0);
        } else if ($i + 1 == $len) {
            $str .= append3bytes(ord(substr($c, $i, 1)), 0, 0);
        } else {
            $str .= append3bytes(ord(substr($c, $i, 1)), ord(substr($c, $i + 1, 1)), ord(substr($c, $i + 2, 1)));
        }
    }
    return $str;
}

function base64url_encode($data){
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data){
    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

//Ugly yes but showing the process here what needs to be done (should use map replace like vowels)

$plantuml_request = rawurldecode($_SERVER['QUERY_STRING']);
$plantuml_request = str_replace("@startuml", "", $plantuml_request);
$plantuml_request = str_replace(";", "\n", $plantuml_request);
$plantuml_request = str_replace("@enduml", "", $plantuml_request);

header('Content-type: image/svg+xml');

// add caching here save in $picture
// code not send to repo

if (!$picture) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $backend.'/'.encodep($plantuml_request));
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $picture = curl_exec($ch);
    curl_close($ch);
    // Save to cache here
    // code not send to repo
    header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + (60 * 60)));
}
echo $picture;
?>
