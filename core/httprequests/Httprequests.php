<?php
class Httprequests
{
 
/**
 * get access token from header
 * */
public static function getAccessKeyToken() {
    $headers = null;
    if (isset($_SERVER['Authorization'])) {
        $headers = trim($_SERVER["Authorization"]);
    }
    else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
        $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
    } elseif (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
        $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
        //print_r($requestHeaders);
        if (isset($requestHeaders['Authorization'])) {
            $headers = trim($requestHeaders['Authorization']);
        }
    }
    return $headers;
}


public static function HttpValidationMsg($lang="ENG")
    {
        switch($lang)
            {
                case "FR":
                    return "Échec de  validation de la demande";
                break;
                case "ENG":
                    return "Request validation failed ";
                break;
            }
    }

    public static function HttRequest($url,$method="POST",$data=array(),$requesttoken=null,$contenttype="urlform")
        {
             $ch = curl_init();
            switch ($contenttype){
                case "urlform":
                    $data=http_build_query($data);
                    $contenttype='application/x-www-form-urlencoded';
                   break;
                case "json":
                    $data = json_encode($data); 
                    $contenttype='application/json';				
                   break;
                   case "xml":
                   $xml = new SimpleXMLElement('COMMAND');
                   array_walk_recursive($data, array ($xml,'commad'));
                   print $xml->asXML();
                   $contenttype='application/xml';
                break;

                default:
                break;
             }
            
            curl_setopt($ch, CURLOPT_URL, $url);
            switch ($method){
                case "POST":
                   curl_setopt($ch, CURLOPT_POST, true);
                   if ($data)
                      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                   break;
                case "PUT":
                   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                   if ($data)
                      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);			 					
                   break;
                default:     
             }
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:'.$requesttoken,'Content-Type:'.$contenttype));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            
            return $result;

        }


        // Sending Async HTTP requests

        public static function curl_post_async($url, $params) 
        { 
            foreach ($params as $key => &$val) { 
            if (is_array($val)) $val = implode(',', $val); 
            $post_params[] = $key.'='.urlencode($val); 
            } 
            $post_string = implode('&', $post_params); 
            $parts=parse_url($url); 
            $fp = fsockopen($parts['host'], 
            isset($parts['port'])?$parts['port']:80, 
            $errno, $errstr, 30); 

            $out = "POST ".$parts['path']." HTTP/1.1\r\n"; 
            $out.= "Host: ".$parts['host']."\r\n"; 
            $out.= "Content-Type: application/x-www-form-urlencoded\r\n"; 
            $out.= "Content-Length: ".strlen($post_string)."\r\n"; 
            $out.= "Connection: Close\r\n\r\n"; 
            if (isset($post_string)) $out.= $post_string; 
            
            fwrite($fp, $out); 
            fclose($fp); 

        }
	
}

?>