<?php

class Facebook extends CI_Model
{
    public function like($mac, $url)
    {
        $flag = $this->db->where('page_url', $url)->where('mac_address', $mac)->get('facebook')->row_array();

        // Such user already exists
        if (count($flag)) {

            $like_count = $flag['like'];

            $this->db->where('page_url', $url)->where('mac_address', $mac)->update([
                'mac_address' => $mac,
                'page_url'    => $url,
                'like'        => $like_count + 1
            ]);
        } else {
            $this->db->insert('facebook', [
                'mac_address' => $mac,
                'page_url'    => $url,
                'like'        => 1,
                'dislike'     => 0,
            ]);
        }
    }

    public function unlike($mac, $url)
    {
        $flag = $this->db->where('page_url', $url)->where('mac_address', $mac)->get('facebook')->row_array();

        // Such user already exists
        if (count($flag)) {

            $dislike_count = $flag['dislike'];

            $this->db->where('page_url', $url)->where('mac_address', $mac)->update([
                'mac_address' => $mac,
                'page_url'    => $url,
                'dislike'      => $dislike_count + 1
            ]);
        } else {
            $this->db->insert('facebook', [
                'mac_address' => $mac,
                'page_url'    => $url,
                'like'        => 0,
                'dislike'        => 1
            ]);
        }
    }
}