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


$website = file_get_contents('https://www.facebook.com/tritueviet01');
echo $website;
?>