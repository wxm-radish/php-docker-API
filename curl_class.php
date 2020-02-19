<?php
/*author:萝卜*/

class my_request{
    private $curl;//请求连接
    public $return_data;//网页返回数据（html）
    public function __construct()
    {
        $this->curl = curl_init();
        // echo "初始化";
    }
    public function get_request($url)
    {
        // echo $url;
        // $headerArray =array("Content-type:application/json;","Accept:application/json");
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($this->curl,CURLOPT_HTTPHEADER,$headerArray);
        $this->return_data = curl_exec($this->curl);
        return $this->return_data;
    }
    public function post_request($url,$post_data)
    {
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($this->curl, CURLINFO_HEADER_OUT, true);
        $this->return_data = curl_exec($this->curl);
        return $this->return_data;
    }

    public function delete_request($url)
    {
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($this->curl, CURLINFO_HEADER_OUT, true);
        curl_exec($this->curl);
    }
    public function getinfo()
    {
        var_dump(curl_getinfo($this->curl,CURLINFO_HEADER_OUT));
    }
    function __destruct()
    {
        curl_close($this->curl);
        // echo "请求结束";

    }
}

/*
$test = new my_request;
// var_dump($test);
// $test->get_request("http://192.168.1.122:9999/images/json");

$post_data = array("a"=>"a","b"=>"b");
$test->delete_request("http://192.168.1.122:9999/containers/a3bf0586ddeb");
// print_r(json_decode($test->return_data));
$test->getinfo();
*/

?>