<?php

echo @mysql_escape_string("?abc") . '<br>';
echo "0bc?   " . check_Pass("0bc?") . '<br>';
echo "abcd   " . check_Pass("abcd") . '<br>';
echo "ab   " . check_Pass("ab") . '<br>';

function check_Pass($passTmp) {

    $r3 = "/^[a-zA-Z0-9]{3,}$/";
    $symbol = preg_match($r3, $passTmp);
    if ($symbol)
        return 'true';
    return 'false';
}

?>