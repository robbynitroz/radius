<?php

/**
 * Created by PhpStorm.
 * User: Bagrat
 * Date: 5/17/2016
 * Time: 9:44 PM
 */
class Email extends CI_Controller
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

    function sendStats()
    {
        //Test Data
        $this->load->model('stats');
//        echo '<pre>';
        $stats = $this->stats->mainLoop();

        $this->sendEmail($stats);
    }

    public function sendEmail($stats)
    {
//        $recipient = 'Rob@guestcompass.nl';
        $recipient = 'neo.matrix.sba@gmail.com';

        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'sakanyan.bagrat@gmail.com',
            'smtp_pass' => 'Sba079999',
            'charset'   => 'iso-8859-1',
            'mailtype' => 'html',
            'charset'  => 'utf-8',
            'priority' => '1'
        );

//        if(!$this->session->userdata('email')) {
//            $this->session->set_userdata('email', $recipient);
//        } else {
//            $last_email = $this->session->userdata('email');
//            if($last_email == $recipient) {
//                return;
//            } else {
//                $this->session->set_userdata('email', $recipient);
//            }
//        }


        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $body = $this->load->view('admin/email_view', $stats, TRUE);

        $this->email->from('sakanyan.bagrat@gmail.com', 'Radius admin');
        $this->email->to($recipient);
        $this->email->subject('This is an email test');
        $this->email->message($body);

        if($this->email->send())
        {
            echo 'Your email was sent, dude.';
        }

        else
        {
            show_error($this->email->print_debugger());
        }
    }
}