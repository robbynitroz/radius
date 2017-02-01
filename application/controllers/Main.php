<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Main extends CI_Controller {
 
    function __construct()
    {
        parent::__construct();
 
        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        /* ------------------ */ 
 
        $this->load->library('grocery_CRUD');
 
    }
 
    public function index()
    {
        echo "<h1>Welcome to the world of Codeigniter</h1>";//Just an example to ensure that we get into the function
        die();
    }
 
  public function nas()
    {
        $this->grocery_crud->set_table('nas');
        $output = $this->grocery_crud->render();
 
        $this->_nas_output($output);        
    }
 
    function _nas_output($output = null)
 
    {
        $this->load->view('nas_template.php',$output);    
    }}
