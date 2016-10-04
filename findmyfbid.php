<?php

    function getData($data) {
        $dom = new DOMDocument;
        $dom->loadHTML($data);
        $divs = $dom->getElementsByTagName('code');
        foreach ($divs as $div) {
            return $div->nodeValue;
        }
    }

    function getFacebookIdProfile($profile_url) {
        $url = 'http://findmyfbid.com';
        $data = array('url' => $profile_url);

// use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return getData($result);
    }
?>