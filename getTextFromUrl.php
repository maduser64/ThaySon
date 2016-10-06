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

//$url="https://www.facebook.com/1185459388186688";
$url = 'http://google.com';

echo "->".(new curl())->get($url);


?>


<?php

class curl {

  static private $cookie_file            = '';
  static private $user_agent             = '';  
  static private $max_redirects          = 10;  
  static private $followlocation_allowed = true;

  function __construct()
  {
    // set a file to store cookies
    self::$cookie_file = 'cookies.txt';

    // set some general User Agent
    self::$user_agent = 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)';

    if ( ! file_exists(self::$cookie_file) || ! is_writable(self::$cookie_file))
    {
      throw new Exception('Cookie file missing or not writable.');
    }

    // check for PHP settings that unfits
    // correct functioning of CURLOPT_FOLLOWLOCATION 
    if (ini_get('open_basedir') != '' || ini_get('safe_mode') == 'On')
    {
      self::$followlocation_allowed = false;
    }    
  }

  /**
   * Main method for GET requests
   * @param  string $url URI to get
   * @return string      request's body
   */
  static public function get($url)
  {
    $process = curl_init($url);    

    self::_set_basic_options($process);

    // this function is in charge of output request's body
    // so DO NOT include HTTP headers
    curl_setopt($process, CURLOPT_HEADER, 0);

    if (self::$followlocation_allowed)
    {
      // if PHP settings allow it use AUTOMATIC REDIRECTION
      curl_setopt($process, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($process, CURLOPT_MAXREDIRS, self::$max_redirects); 
    }
    else
    {
      curl_setopt($process, CURLOPT_FOLLOWLOCATION, false);
    }

    $return = curl_exec($process);

    if ($return === false)
    {
      throw new Exception('Curl error: ' . curl_error($process));
    }

    // test for redirection HTTP codes
    $code = curl_getinfo($process, CURLINFO_HTTP_CODE);
    if ($code == 301 || $code == 302)
    {
      curl_close($process);

      try
      {
        // go to extract new Location URI
        $location = self::_parse_redirection_header($url);
      }
      catch (Exception $e)
      {
        throw $e;
      }

      // IMPORTANT return 
      return self::get($location);
    }

    curl_close($process);

    return $return;
  }

  static function _set_basic_options($process)
  {

    curl_setopt($process, CURLOPT_USERAGENT, self::$user_agent);
    curl_setopt($process, CURLOPT_COOKIEFILE, self::$cookie_file);
    curl_setopt($process, CURLOPT_COOKIEJAR, self::$cookie_file);
    curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
    // curl_setopt($process, CURLOPT_VERBOSE, 1);
    // curl_setopt($process, CURLOPT_SSL_VERIFYHOST, false);
    // curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
  }

  static function _parse_redirection_header($url)
  {
    $process = curl_init($url);    

    self::_set_basic_options($process);

    // NOW we need to parse HTTP headers
    curl_setopt($process, CURLOPT_HEADER, 1);

    $return = curl_exec($process);

    if ($return === false)
    {
      throw new Exception('Curl error: ' . curl_error($process));
    }

    curl_close($process);

    if ( ! preg_match('#Location: (.*)#', $return, $location))
    {
      throw new Exception('No Location found');
    }

    if (self::$max_redirects-- <= 0)
    {
      throw new Exception('Max redirections reached trying to get: ' . $url);
    }

    return trim($location[1]);
  }

}