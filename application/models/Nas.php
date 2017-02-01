<?php


class Nas extends CI_Model
{
    public function getLastRouterIp()
    {
        return $this->db->select('nasname')
                        ->order_by('id', 'desc')
                        ->limit(1)
                        ->get('nas')
                        ->row_array()['nasname'];
    }

    public function getAllMac()
    {
        return $this->db->select('wanmac')
                        ->where('wanmac !=', 'null')
                        ->get('nas')
                        ->result_array();
    }
}