<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Template extends Admin_Controller
{

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

    public function templates()
    {
        $this->grocery_crud->set_table('templates')
            ->columns('name', 'filename')
            ->display_as('name', 'Template name')
            ->display_as('filename', 'Template file name');
        $output = $this->grocery_crud->render();

        $this->_templates_output($output);
    }

    function _templates_output($output = null)

    {
        $this->load->view('admin/templates_template.php', $output);
    }
}
