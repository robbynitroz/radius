<?php

use GuzzleHttp\Exception\BadResponseException;

/**
 * Created by PhpStorm.
 * User: Bagrat
 * Date: 6/14/2016
 * Time: 10:34 PM
 */
class Email extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function insertNewEmails($emails)
    {
        foreach($emails as $key => $value)
        {
            foreach($value as $key1 => $value1)
            $this->db->insert('emails', array(
                'email'       => $value1['email'],
                'email_type'  => 'left',
                'hotel_alias' => $value1['alias'],
                'router_ip'   => $value1['firstname'],
                'mac_address' => $value1['lastname'],
                'status'      => 'new',
                'created_at'  => $value1['attribute_1'],
                'updated_at'  => $value1['attribute_2']
            ));
        }
    }


    /**
     * Create list with left users emails
     *
     * @return int listID
     */
    public function createHotelList($alias, $name)
    {
        $list_name = $alias .'_'. $name;

        // get URL for the Elastic Email Add Contact into the contact list
        $add_list_url = "https://api.elasticemail.com/v2/list/add?".
                        "apikey=3306af7f-2cf6-4e19-8fcd-d10eb9fd26f0".
                        "&listName=". urlencode($list_name) .
                        "&createEmptyList=true";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $add_list_url);
        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close ($ch);

        $listID = json_decode($server_output, true)['data'];

        return $listID;
    }
    
    /**
     * Get emails with updated_at older than 3 days
     * 
     * @return mixed
     */
    public function getThreeDayEmails()
    {
//        $offset_start = date("Y-m-d 00:00:00", strtotime("-3 days"));

//        $offset_start = date("Y-m-d 00:00:00", time());
//        $offset_end= date("Y-m-d 23:59:59", time());

        $offset_start = '2016-06-23 00:00:00';
        $offset_end   = '2016-06-23 23:59:59';

        $emails_list = $this->db->select('*')
                                ->where('email_type', 'left')
                                ->where('updated_at >=', $offset_start)
                                ->where('updated_at <=', $offset_end)
                                ->get('emails')
                                ->result_array();

        $lists = [];

        foreach($emails_list as $key => $email) {
            $lists[$email['hotel_alias']][] = [
                'email' => $email['email'],
                'first_name' => $email['router_ip'],
                'last_name' => $email['mac_address']
            ];
        }

        return $lists;
    }

    public function previousWeekEmails($hotel_id)
    {
        $start = date("Y-m-d 00:00:00", strtotime("-7 days"));
        $end   = date("Y-m-d 00:00:00", time());

        $emails_list = $this->db->select('*')
            ->where('email_type', 'wifi')
            ->where('hotel_id', $hotel_id)
            ->where('created_at >=', $start)
            ->where('created_at <', $end)
            ->get('emails')
            ->result_array();

        $lists = [];

        foreach($emails_list as $key => $email) {
            $lists[] = [
                'email' => $email['email'],
                'mac'   => $email['mac_address']
            ];
        }

        return $lists;
    }

    public function previousAllEmails($hotel_id)
    {
        //$end = date("Y-m-d 00:00:00", time());
        $end = date("Y-m-d 00:00:00", 1478476800);

        $emails_list = $this->db->select('*')
                                ->where('email_type', 'wifi')
                                ->where('hotel_id', $hotel_id)
                                ->where('created_at <', $end)
                                ->get('emails')
                                ->result_array();

        $lists = [];

        foreach($emails_list as $key => $email) {
            $lists[] = [
                'email' => $email['email'],
                'mac'   => $email['mac_address']
            ];
        }

        return $lists;
    }


    public function getAllEmails()
    {
        $emails_list = $this->db->select('*')
                                ->where('email_type', 'left')
                                ->get('emails')
                                ->result_array();

        $lists = [];

        foreach($emails_list as $key => $email) {
            $lists[$email['hotel_alias']][] = [
                'alias' => $email['hotel_alias'],
                'email' => $email['email'],
                'firstname' => $email['router_ip'],
                'lastname' => $email['mac_address'],
                'attribute_1' => $email['created_at'],
                'attribute_2' => $email['updated_at'],
                'status' => $email['status']
            ];
        }

        return $lists;
    }


    /**
     * Send email to all contacts that has left Hotel 3 days ago
     *
     * @param $email_list
     * @return string "{"success":true,"data":{"transactionid":"eb84496e-ee5b-4b3d-9cc0-8c27fa1f6a89"}}"
     */
    public function sendEmailsToThreeDayList($email_list)
    {
        $this->load->helper('url');

        //List of email recipients - string
        $to = implode(',', $email_list);

        // get URL for the Elastic Email Add Contact into the contact list
        $send_email_url = "https://api.elasticemail.com/v2/email/send?".
                            "apikey=3306af7f-2cf6-4e19-8fcd-d10eb9fd26f0".
                            "&subject=You left Hotel 3 days ago. We hope to see you again".
                            "&from=admin@radius.com".
                            "&fromName=FromName".
                            "&sender=senderEmailAddress@gmail.com".
                            "&to=".$to;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $send_email_url);
        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close ($ch);

        return $server_output;
    }

    public function sendElasticEmail($email_list)
    {
        foreach($email_list as $alias => $data) {
            foreach($data as $user_info) {

                $send_email_url = "https://api.elasticemail.com/v2/email/send?".
                                    "apikey=3306af7f-2cf6-4e19-8fcd-d10eb9fd26f0".
                                    "&subject=". urlencode('You left Hotel 3 days ago. We hope to see you again') .
                                    "&from=admin@radius.com".
                                    "&fromName=FromName".
                                    "&sender=senderEmailAddress@gmail.com".
                                    "&template=". urlencode('hotelcc Welcome').
                                    "&to=".$user_info['email'].
                                    "&merge_firstname=". urlencode($user_info['first_name']).
                                    "&merge_lastname=". urlencode($user_info['last_name']);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $send_email_url);
                // receive server response ...
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $server_output = curl_exec($ch);

                $response = json_decode($server_output, true);

                if($response['success']) {
                    $this->setEmailStatusSent($user_info['email']);
                }

                curl_close ($ch);
            }
        }
    }


    /**
     * Add contacts to Hotel's emails list for left users
     *
     * @param $email_list
     */
    public function addContactsToHotelLeftList($email_list)
    {
        $this->load->helper('url');

        $data_of_lists = $this->getListOfLists();

        foreach($email_list as $alias => $array) {

            //Name of left users list for current hotel
            $list_name = $alias . '_left';

            foreach ($array as $key => $user) {
                // get URL for the Elastic Email Add Contact into the contact list
                $add_contacts_url = "https://api.elasticemail.com/v2/contact/quickadd?" .
                                    "apikey=3306af7f-2cf6-4e19-8fcd-d10eb9fd26f0" .
                                    "&listID="    . urlencode($data_of_lists[$list_name]) .
                                    "&emails="    . $user['email'] .
                                    "&firstName=" . urlencode($user['first_name']) .
                                    "&lastName="  . urlencode($user['last_name']);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $add_contacts_url);
                // receive server response ...
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $server_output = curl_exec($ch);
                curl_close ($ch);
            }
        }
    }


    /**
     * @return array of  ["email161_left"]=>int(31756)
     */
    public function getListOfLists()
    {
        $this->load->helper('url');

        // get URL for the Elastic Email Add Contact into the contact list
        $check_list_url = "https://api.elasticemail.com/v2/list/list?apikey=3306af7f-2cf6-4e19-8fcd-d10eb9fd26f0";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $check_list_url);
        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close ($ch);

        //List
        $lists = json_decode($server_output, true)['data'];

        $tmp_list = [];

        foreach($lists as $list) {
            $tmp_list[$list['listname']] = $list['listid'];
        }

        return $tmp_list;
    }

    /**
     * @param $alias
     * @param $name = [left, wifi , soon]
     * @return boolean
     */
    public function ifListExists($alias, $name)
    {
        $this->load->helper('url');

        $list_name = $alias .'_'. $name;

        // get URL for the Elastic Email Add Contact into the contact list
        $check_list_url = "https://api.elasticemail.com/v2/list/load?".
                            "apikey=3306af7f-2cf6-4e19-8fcd-d10eb9fd26f0".
                            "&listName=". urlencode($list_name);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $check_list_url);
        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close ($ch);

        //get success status from response
        $status = json_decode($server_output, true)['success'];

        return $status;
    }


    //We do this on new Hotel adding process
    public function createNewElasticLists($alias)
    {
        if(!$this->ifListExists($alias, 'left')) {
            $this->createHotelList($alias, 'left');
        }

        if(!$this->ifListExists($alias, 'wifi')) {
            $this->createHotelList($alias, 'wifi');
        }

        if(!$this->ifListExists($alias, 'soon')) {
            $this->createHotelList($alias, 'soon');
        }

    }

    public function setEmailStatusSent($email)
    {
        $this->db->where('email', $email)->update('emails', ['status' => 'sent']);
    }
}