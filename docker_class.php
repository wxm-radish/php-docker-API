<?php
/*author:萝卜*/

include 'curl_class.php';

class control_docker{
    public $curl_handle;
    public $remote_url;
/*
    config:ip port
*/
    function __construct($ip,$port)
    {
        $this->curl_handle = new my_request();
        $this->remote_url = "http://".$ip.":".$port."/";
    }
    public function show_images()
    {
        //docker images
        $url = $this->remote_url."images/json";
        $data = $this->curl_handle->get_request($url);
        $arr = json_decode($data);
        $images_data = array();
        for($i=0;$i<count($arr);$i++)
        {
            $images_data[$i]['ID'] = substr(explode(":",$arr[$i]->Id)[1],0,12);
            $images_data[$i]['name'] = $arr[$i]->RepoTags[0];
        }
        return $images_data;
    }
    public function show_containers()
    {
        //docker ps
        $url = $this->remote_url."containers/json";
        $data = $this->curl_handle->get_request($url);
        $arr = json_decode($data);
        $containers_data = array();
        for($i=0;$i<count($arr);$i++)
        {
            $containers_data[$i]['Id'] = substr($arr[$i]->Id,0,12);
            $containers_data[$i]['Name'] = substr($arr[$i]->Names[0],1,strlen($arr[$i]->Names[0]));
            $containers_data[$i]['Image'] = $arr[$i]->Image;
            $containers_data[$i]['Create_time'] = $arr[$i]->Created;
            for($j=0;$j<count($arr[$i]->Ports);$j++)
            {
                $containers_data[$i]['Port'][$j] = $arr[$i]->Ports[$j]->IP.":".$arr[$i]->Ports[$j]->PrivatePort."->".$arr[$i]->Ports[$j]->PublicPort.",".$arr[$i]->Ports[$j]->Type;
            }
        }
        return $containers_data;
    }
    public function stop_container($ID)
    {
        //docker stop ID
        $url = $this->remote_url."containers/".$ID."/stop";
        $this->curl_handle->post_request($url,array());
        // die($url);
    }
    public function start_container($ID)
    {
        //docker stop ID
        $url = $this->remote_url."containers/".$ID."/start";
        $a = $this->curl_handle->post_request($url,array());
        // var_dump($a);
        // die($url);
    }
    public function remove_container($ID)
    {
        //docker rm ID
        $url = $this->remote_url."containers/".$ID;
        $a = $this->curl_handle->delete_request($url);
        // var_dump($a);
        // die($url);
    }
    public function stop_and_remove($ID)
    {
        //docker stop && rm
        $this->stop_container($ID);
        $this->remove_container($ID); 
    }

}
$test = new control_docker("192.168.1.122","9999");
// print_r($test->show_containers());
// var_dump($test->show_images());
$test->start_container("4e75f7b52080");
?>

