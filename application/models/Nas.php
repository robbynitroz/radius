<?php


class Nas extends CI_Model
{
    public function getLastRouterIp()
    {
        $last_ip = $this->db->select('nasname')
                        ->order_by('id', 'desc')
                        ->limit(1)
                        ->get('nas')
                        ->row_array()['nasname'];

        if (is_null($last_ip)) {
            return '192.168.253.1';
        } else {
            return $last_ip;
        }
    }

    public function getAllMac()
    {
        return $this->db->select('wanmac')
                        ->where('wanmac !=', 'null')
                        ->get('nas')
                        ->result_array();
    }
}