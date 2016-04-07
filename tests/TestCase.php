<?php

class TestCase extends PHPUnit_Framework_TestCase
{

    /**
    *Check if the given extension is loaded.
    *
    *@param String $ext_name is the name of the extension that you want to check is installed or not.
    *
    *@return bool if entension is installed, then return true. Return false Otherwise.
    */
    public function isExtensionLoaded($ext_name)
    {
        return extension_loaded($ext_name);
    }

    /**
    *Get response at given url
    *
    *Get header and body at given URL
    *<code>
    * //extends this class
    *$this->testHttpRedirectToHttps('http://nginxhttp/');
    *</code>
    *
    *@param string $url is the URL from which to fetch response
    *
    *@return bool|string If request is successful, them return header and body. Otherwise return false.
    */
    protected function getFullResponseFromURL($url)
    {
        if (!$this->isExtensionLoaded('curl')) {
            $this->markTestSkipped('Curl extension is not available.');
        }

        ///start initialize curl
        $ch = curl_init();
        ///end initialize curl

        ///start set curl options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        ///end set curl options

        ///start if request is https, then don't verify certificate
        if (substr($url, 0, 8) == 'https://') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        ///end if request is https, then don't verify certificate

        ///start get response from URL and print errors if errors are found
        $response = curl_exec($ch);
        if (curl_error($ch)) {
            echo 'error:' . curl_error($ch);
        }
        ///end get response from URL and print errors if errors are found

        ///start return respose
        return $response;
        ///end return respose
    }
}
