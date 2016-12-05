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
    *@param bool $with_headers will define it the return value should include header value
    *
    *@return bool|string If request is successful, them return header and body. Otherwise return false.
    */
    protected function getFullResponseFromURL($url, $with_headers = true, $custom_http_headers = [])
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
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        ///end set curl options

        ///start also print header
        if ($with_headers) {
            curl_setopt($ch, CURLOPT_HEADER, true);
        }
        ///end also print header

        ///start if request is https, then don't verify certificate
        if (substr($url, 0, 8) == 'https://') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        ///end if request is https, then don't verify certificate

        ///start set custom http headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $custom_http_headers);
        ///end set custom http headers

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


    private $phpfpm_ini_setting_cache= null;
    /**
    *When we run 'ini_get' in phpunit, we don't get settings of php cli environment instead of phpfpm.
    *This function will load settings from 'https://nginxhttps/phpini_arr.php' file
    *
    *@return array Return an empty array if failed. Other decode json value at 'https://nginxhttps/phpini_arr.php' and return.
    */
    protected function getPhpfpmIniSettings()
    {
        if ($this->phpfpm_ini_setting_cache === null) {
            $data= $this->getFullResponseFromURL('https://nginxhttps/phpini_arr.php', false);
            $this->phpfpm_ini_setting_cache= json_decode($data, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->phpfpm_ini_setting_cache= [];
            }
        }

        return $this->phpfpm_ini_setting_cache;
    }
}
