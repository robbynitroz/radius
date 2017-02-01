<?php

/**
 * Created by PhpStorm.
 * User: Bagrat
 * Date: 9/18/2016
 * Time: 12:14 PM
 */
class ExportCSV extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
        /* ------------------ */

        // this controller can only be called from the command line
        if (!$this->input->is_cli_request())
            show_error('Direct access is not allowed');
    }

    public function exportCsv()
    {
        //emails
        $this->load->model('email');
        $this->load->model('hotel');

        // Get all hotels ['id' => 'name'];
        $all_hotels_ids = $this->hotel->getHotels();

        // File name
        $file = 'emails.txt';

        foreach($all_hotels_ids as $id => $name) {

            $name = 'ftp/'.$name;

            // Check does folder with the same hotel name exist
            if (is_dir($name)) {
                // open file to get content
                $content = file_get_contents($name .'/'. $file);

                // Creating content
                $content = json_encode($this->email->previousWeekEmails($id));

                // Write content in file
                file_put_contents($name .'/'. $file, $content);
            } else {
                mkdir($name, 0777, true);

                // open file to get content
                $content = file_get_contents($name .'/'. $file);

                // Creating content
                $content = json_encode($this->email->previousWeekEmails($id));

                // Write content in file
                file_put_contents($name .'/'. $file, $content);
            }
        }
    }
}