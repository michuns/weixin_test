<?php
/**
 * User: yuan
 * Date: 2018/3/19
 * Time: 15:08
 */

namespace wxchat;


class HttpCurl
{

    // post 请求
    public function post( $url, $param , $type = 'text')
    {
        $cl = curl_init();
        if(stripos($url, 'https://') !== FALSE) {
            curl_setopt($cl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($cl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($cl, CURLOPT_SSLVERSION, 1);
        }
        curl_setopt($cl, CURLOPT_URL, $url);
        curl_setopt($cl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($cl, CURLOPT_POST, true);
        curl_setopt($cl, CURLOPT_POSTFIELDS, $param);
        $data = curl_exec($cl);
        $status = curl_getinfo($cl);
        curl_close($cl);
        if (isset($status['http_code']) && $status['http_code'] == 200) {
            if ($type == 'json') {
                $data = json_decode($data);
            }
            return $data;
        } else {
            return false;
        }
    }

    // get 请求
    public function get( $url, $type = 'text')
    {
        $cl = curl_init();
        if(stripos($url, 'https://') !== FALSE) {
            curl_setopt($cl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($cl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($cl, CURLOPT_SSLVERSION, 1);
        }
        curl_setopt($cl, CURLOPT_URL, $url);
        curl_setopt($cl, CURLOPT_RETURNTRANSFER, 1 );
        $data = curl_exec($cl);
        $status = curl_getinfo($cl);
        curl_close($cl);

        if (isset($status['http_code']) && $status['http_code'] == 200) {
            if ($type == 'json') {
                $data = json_decode($data);
            }
            return $data;
        } else {
            return false;
        }
    }


}