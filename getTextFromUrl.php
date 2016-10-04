<?php
//$doc = new DOMDocument;
//$doc->load("https://www.facebook.com/tritueviet01");
//$xpath = new DOMXpath($doc);
////$elements = $xpath->query("*/meta[@id='yourTagIdHere']");
//$elements = $xpath->query("*/meta");
////echo $elements;
//echo $xpath;



//$ch = curl_init('https://www.facebook.com/tritueviet01');
//curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7) AppleWebKit/534.48.3 (KHTML, like Gecko) Version/5.1 Safari/534.48.3');
//
//$content = curl_exec($ch);
//echo $content;
//curl_close($ch);


//$website = file_get_contents('https://www.facebook.com/tritueviet01');
//echo $website;


$name="19875379";
$url = "http://www.ikea.co.il/default.asp?strSearch=".$name;

$ch = curl_init();
$timeout = 0;
curl_setopt ($ch, CURLOPT_URL, $url);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_HEADER, TRUE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$header = curl_exec($ch);
$redir = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
//print_r($redir);
//
$x = preg_match("/<script>location.href=(.|\n)*?<\/script>/", $header, $matches);
$script = $matches[0];
$redirect = str_replace("<script>location.href='", "", $script);
$redirect = "http://www.ikea.co.il" . str_replace("';</script>", "", $redirect);
//
echo $redirect; 


//$name="19875379";
//$url = "http://www.ikea.co.il/default.asp?strSearch=".$name;
//$ch = curl_init($url);
//$last_url = curl_getinfo($ch, CURLOPT_ );
//echo $last_url;
?>