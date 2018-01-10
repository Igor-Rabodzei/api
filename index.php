<?php

$apiKey = '';
$url = 'https://translation.googleapis.com/language/translate/v2?key=' .$apiKey . '&q=' .$_POST['q']. '&target=' . $_POST['target'];

$handle = curl_init($url);

curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($handle, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36
');
$response = curl_exec($handle);
curl_close($handle);

$responseDecoded = json_decode($response, 1);

//print_r(json_decode($response,1));
$string = $responseDecoded['data']['translations'][0]['translatedText'];

$uri = ($_SERVER['REQUEST_URI']);

if (preg_match('[api/sayHelloInLanguage]', $uri))
{
    if (preg_match("#(.)\\1{2,}#", $string) )
    {
        if (strlen($string) >= 4 && strlen($string) <=14)
        {
            echo 'Response:  ';
            print_r(['status' => 'Error', 'msq' => 'Name is invalid']);
        }
        elseif (strlen($string) <= 3)
        {
            echo 'Response:  ';
            print_r(['status' => 'Error', 'msq' => 'Name is too short, Please enter valid name']);
        }
        elseif (strlen($string) >= 15)
        {
            echo 'Response:  ';
            print_r(['status' => 'Error', 'msq' => 'Name is too long, Please enter valid name']);
        }

    }
    else{
        if (strlen($string) >= 3 && strlen($string) <=14)
        {
            echo 'Response: ' ;
            print_r(['status' => 'Success', 'msq' => $string]);
        }
        elseif (strlen($string) <= 2)
        {
            echo 'Response:  ';
            print_r(['status' => 'Error', 'msq' => 'Name is too short']);
        }
        elseif (strlen($string) >= 15)
        {
            echo 'Response:  ';
            print_r(['status' => 'Error', 'msq' => 'Name is too long']);
        }
    }

}











?>