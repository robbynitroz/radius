<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Main extends Admin_Controller
{
    public $fb;

    function __construct()
    {
        parent::__construct();

        require '../login/Facebook/autoload.php';

        $this->fb = new Facebook\Facebook([
            'app_id' => '696113500523537',
            'app_secret' => 'f7c94fe5f0f51cc9a04fc2512b5c58cd',
            'default_graph_version' => 'v2.8',
        ]);

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('my_helper');
        $this->load->library('session');

        /* ------------------ */

        $this->load->library('grocery_CRUD');

        //Test Data testtset
//        $this->load->model('stats');
//        $data = $this->stats->getStatsDifference();
//
//        $this->sendEmail($data);

//        var_dump($this->getAttachment());exit;

//        $this->emails();
//        echo '<pre>';
//
//        exit;

        $this->generateOfflinePagesAll();

    }

    public function index()
    {
        echo "<h1>Welcome to the world of Codeigniter ;</h1>". CI_VERSION;//Just an example to ensure that we get into the function
        die();
    }

    public function login(  )
    {
        echo 'LOGIN';
    }

    public function  stat()
    {
        //Test Data
        $this->load->model('stats');
        $data = $this->stats->getStatsDifference();

        $this->load->view('admin/email_view', $data);

    }

    public function sendEmail($stats)
    {
        $recipient = 'Rob@guestcompass.nl';
//        $recipient = 'neo.matrix.sba@gmail.com';

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

    public function getAllHotelsAndTemplates() {

        $this->load->model('hotel');
//        var_dump($this->hotel->getAllHotelsAndTemplates());exit;
        echo json_encode($this->hotel->getAllHotelsAndTemplates());
    }

    public function getHotels()
    {
        $this->load->model('hotel');

        echo json_encode($this->hotel->getHotels());
    }

    public function getHotelTemplatesAndActiveTemplate()
    {
        $hotel_id = $_POST['hotel_id'];

        $this->load->model('hotel');

        echo json_encode($this->hotel->getHotelTemplatesAndActiveTemplate($hotel_id));
    }

    public function setHotelActiveTemplate()
    {
        $template_id   = $_POST['template_id'];
        $hotel_id      = $_POST['hotel_id'];

        $this->load->model('hotel');

        echo json_encode($this->hotel->setHotelActiveTemplate($hotel_id, $template_id));
    }

    public function setHotelActiveQuestion()
    {
        $hotel_id    = $_POST['hotel_id'];
        $question_id = $_POST['question_id'];

        $this->load->model('hotel');

        echo json_encode($this->hotel->setHotelActiveQuestion($hotel_id, $question_id));
    }

    public function addNewQuestion()
    {
        $hotel_id    = $_POST['hotel_id'];
        $text        = $_POST['text'];
        $language    = $_POST['language'];

        $this->load->model('hotel');

//        var_dump($this->hotel->addNewQuestion($hotel_id, $text, $language));exit;
        echo json_encode($this->hotel->addNewQuestion($hotel_id, $text, $language));
    }

    public function deleteHotelQuestion()
    {
        $question_id = $_POST['question_id'];

        $this->load->model('hotel');

        echo json_encode($this->hotel->deleteHotelQuestion($question_id));
    }

    public function editHotelQuestion()
    {
        $hotel_id    = $_POST['hotel_id'];
        $question_id = $_POST['question_id'];
        $text        = $_POST['text'];
        $language    = $_POST['language'];

        $this->load->model('hotel');

        echo json_encode($this->hotel->editHotelQuestion($hotel_id, $question_id, $text, $language));
    }

    public function getHotelQuestionsStats()
    {
        $hotel_id = $_POST['hotel_id'];

        $this->load->model('hotel');

        $result = $this->hotel->getHotelQuestionsStats($hotel_id);
//        array(17) {
//        [0]=>
//        array(2) {
//            ["question_id"] => string(2) "15"
//            ["answer"] => string(2) "-1"
//          }

        $question_ids =  $this->hotel->getHotelQuestionsId($hotel_id);


        $hotel_id_text = $this->hotel->getHotelIdAndText($hotel_id);

        $stats = [];
        foreach($question_ids as $key => $value) {
            $stats[$value] = [
                -1 => 0,
                0  => 0,
                1  => 0
            ];
        }

        // $key - question id, $value - [-1, 0, 1]
        foreach($result as $key => $value) {
            $question_id = intval($value['question_id']);
            $answer      = intval($value['answer']);

            $stats[$question_id][$answer] += 1;
        }

        //Add question_id => text pairs
        $stats['texts'] = $hotel_id_text;

        echo json_encode($stats);

    }

    public function getHotelEmailsList()
    {
        $hotel_id = $_POST['hotel_id'];

        $this->load->model('hotel');

        $result = $this->hotel->getHotelEmailsList($hotel_id);

        echo json_encode($result);
    }

    public function getHotelEmailsListPaginated()
    {
        $hotel_id = $_POST['hotel_id'];
        $limit    = $_POST['limit'];
        $offset   = $_POST['offset'];

        $this->load->model('hotel');

        $result = $this->hotel->getHotelEmailsListPaginated($hotel_id, $limit, $offset);

        echo json_encode($result);
    }

    public function getHotelEmailsListRanged()
    {
        $hotel_id = $_POST['hotel_id'];

        //timestamp format
        $from     = $_POST['from'];
        $to       = $_POST['to'];

        $this->load->model('hotel');

        $result = $this->hotel->getHotelEmailsListRanged($hotel_id, $from, $to);

//        var_dump(json_encode($result)); exit;
        echo json_encode($result);
    }

    public function getAllLanguages()
    {
        $hotel_id = $_POST['hotel_id'];

        $this->load->model('language');
        $this->load->model('hotel');


        $all_languages    = $this->language->getAllLanguages($hotel_id);
        $active_languages = $this->hotel->getActiveLanguages($hotel_id);
        $default_language = $this->hotel->getDefaultLanguage($hotel_id);
        $default_terms    = $this->hotel->getDefaultTerms();

        $result['all']     = $all_languages;
        $result['active']  = $active_languages;
        $result['default'] = $default_language;
        $result['terms']   = $default_terms;

//        var_dump(json_encode($default_terms)); exit;
        echo json_encode($result);
    }

    public function getTerm()
    {
        $language_id = $_POST['language_id'];

        $this->load->model('hotel');
        $term = $this->hotel->getTerm($language_id);

        echo json_encode($term);
    }

    public function editTerm()
    {
        $language_id = $_POST['language_id'];
        $title       = $_POST['title'];
        $text        = $_POST['text'];

        $this->load->model('hotel');

        $result = $this->hotel->editTerm($language_id, $title, $text);

        echo json_encode($result);
    }

    /******************Add/Delete Active Languages **************************/

    public function addActiveLanguage()
    {
        $hotel_id    = $_POST['hotel_id'];
        $language_id = $_POST['language_id'];

        $this->load->model('hotel');

//        var_dump(json_encode($this->hotel->addActiveLanguage($hotel_id, $language_id)));exit;
        echo json_encode($this->hotel->addActiveLanguage($hotel_id, $language_id));
    }

    public function removeActiveLanguage()
    {
        $hotel_id    = $_POST['hotel_id'];
        $language_id = $_POST['language_id'];

        $this->load->model('hotel');

        echo json_encode($this->hotel->removeActiveLanguage($hotel_id, $language_id));
    }

    /******************Add/Change Default Language **************************/

    public function setDefaultLanguage()
    {
        $hotel_id    = $_POST['hotel_id'];
        $language_id = $_POST['language_id'];

        $this->load->model('hotel');

        echo json_encode($this->hotel->setDefaultLanguage($hotel_id, $language_id));
    }

    public function changeDefaultLanguage()
    {
        $hotel_id    = $_POST['hotel_id'];
        $language_id = $_POST['language_id'];

        $this->load->model('hotel');

        echo json_encode($this->hotel->changeDefaultLanguage($hotel_id, $language_id));
    }

    public function getTranslate()
    {
        $hotel_id      = $_POST['hotel_id'];
        $language      = $_POST['language'];
        $template_type = $_POST['template_type'];

        $this->load->model('template');

//        var_dump(json_encode($this->template->getTranslate($hotel_id, $language, $template_type)));exit;
        echo json_encode($this->template->getTranslate($hotel_id, $language, $template_type));
    }

    public function getTemplateVariables()
    {
        $hotel_id      = $_POST['hotel_id'];
        $template_id   = $_POST['template_id'];

        $this->load->model('template');

//        var_dump(json_encode($this->template->getTemplateVariables($hotel_id, $template_id)));exit;
        echo json_encode($this->template->getTemplateVariables($hotel_id, $template_id));
    }

    public function setTemplateVariables()
    {
        $data = [];

        $template_type       = $_POST['template_type'];
        $data['hotel_id']    = $_POST['hotel_id'] ;
        $data['template_id'] = $_POST['template_id'];

        switch($template_type) {
            case 'Login template':
                $data['hotel_label_1']      = $_POST['hotel_label_1'];
                $data['hotel_label_2']      = $_POST['hotel_label_2'];
                $data['hotel_btn_label']    = $_POST['hotel_btn_label'];
                break;
            case 'Email template':
                $data['hotel_label_1']      = $_POST['hotel_label_1'];
                $data['hotel_label_2']      = $_POST['hotel_label_2'];
                $data['hotel_btn_label']    = $_POST['hotel_btn_label'];
                break;
            case 'Facebook template':
                $data['title']        = $_POST['title'];
                $data['fb_title']     = $_POST['fb_title'];
                $data['middle_title'] = $_POST['middle_title'];
                $data['email_title']  = $_POST['email_title'];
                break;
            case 'Question template':
                $data['translate_question_label'] = $_POST['translate_question_label'];
                break;
        }

        $data['hotel_bg_color']     = $_POST['hotel_bg_color'];
        $data['hotel_centr_color']  = $_POST['hotel_centr_color'];
        $data['hotel_btn_bg_color'] = isset($_POST['hotel_btn_bg_color'])? $_POST['hotel_btn_bg_color']: '';

        $data['hotel_font_color1']  = $_POST['hotel_font_color1']; // header font color
        $data['hotel_font_color2']  = isset($_POST['hotel_font_color2'])? $_POST['hotel_font_color2']: ''; // button font color
        $data['hotel_font_color3']  = $_POST['hotel_font_color3']; // label  font color

        $data['hotel_font_size1']   = $_POST['hotel_font_size1']; // header font size
        $data['hotel_font_size2']   = isset($_POST['hotel_font_size2'])? $_POST['hotel_font_size2']: ''; // button font size
        $data['hotel_font_size3']   = $_POST['hotel_font_size3']; // label  font size

        $data['form_language']      = $_POST['form_language'] ;

        if(!empty($_FILES['hotel_bg_image']['name']))
        {
            $uploaded_image = $this->uploadImage('hotel_bg_image');
            if($uploaded_image == false) {
                 echo json_encode(array('image_errors' => 'Please upload background image with size less than 500KB'));
                return;
            } else {
                $data['hotel_bg_image'] = $uploaded_image;
            }
        }
        else
        {
            $data['hotel_bg_image'] = "";
        }

        if(!empty($_FILES['hotel_logo']['name']))
        {
            $uploaded_image = $this->uploadImage('hotel_logo');
            if($uploaded_image == false) {
                echo json_encode(array('image_errors' => 'Please upload hotel logo with size less than 500KB'));
                return;
            } else {
                $data['hotel_logo'] = $uploaded_image;
            }
        }
        else
        {
            $data['hotel_logo'] = "";
        }

        $this->load->model('template');

//        var_dump(json_encode($this->template->setTemplateVariables($data)));exit;
        echo json_encode($this->template->setTemplateVariables($data));

    }

    /**
     * @param $image_name is a input field name
     * @return bool|string
     */
    public function uploadImage($image_name)
    {
        $errors= array();

        $file_name = $_FILES[$image_name]['name'];
        $file_tmp  = $_FILES[$image_name]['tmp_name'];

        if(empty($file_name))
            return '';

        // Get file size, it should be <= 500 KB
        $file_size = filesize($file_tmp);

        if($file_size > 5000000) {
            // Add to session error message
            $this->session->set_flashdata("$image_name", 'Please upload image with size less than 500KB');
            return false;
        } else {
            $file_name = mt_rand().'_'.$file_name;

            if(empty($errors)==true){
                move_uploaded_file($file_tmp, "assets/variables/".$file_name);
            }else{
                print_r($errors);
            }
            return $file_name;
        }

//        $file_ext = strtolower(end(explode('.',$_FILES[$image_name]['name'])));

//        $expensions= array("jpeg","jpg","png");
//
//        if(in_array($file_ext,$expensions)=== false){
//            $errors[]="extension not allowed, please choose a JPEG or PNG file.";
//        }
    }


    public function uploadIcon($icon_name)
    {
        $errors= array();

        $file_name = $_FILES[$icon_name]['name'];
        $file_tmp  = $_FILES[$icon_name]['tmp_name'];

        $file_name = 'icon_'. mt_rand() .'_'. $file_name;

        if(empty($errors)==true){
            move_uploaded_file($file_tmp, "assets/variables/".$file_name);
        }else{
            print_r($errors);
        }
        return $file_name;

    }

    public function updateIcon($icon_name, $old_name)
    {
        unlink("assets/variables/$old_name");

        $errors= array();

        $file_name = $_FILES[$icon_name]['name'];
        $file_tmp  = $_FILES[$icon_name]['tmp_name'];

        $file_name = 'icon_'. mt_rand() .'_'. $file_name;

        if(empty($errors)==true){
            move_uploaded_file($file_tmp, "assets/variables/".$file_name);
        }else{
            print_r($errors);
        }
        return $file_name;

    }

    public function generateOfflinePagesAll()
    {
        //Get array of all WANMACS
        $this->load->model('nas');
        $wanmacs = $this->nas->getAllMac();


        foreach($wanmacs as $kay => $value)
        {
            $wanmac = $value['wanmac'];
            copy("offline_pages/example.html", "offline_pages/$wanmac.html");
        }
    }

    public function generateOfflinePages($wanmac)
    {
        copy("offline_pages/example.html", "offline_pages/$wanmac.html");
    }

    public function createConfFileForRouter($ip)
    {
        $file = fopen("ccd/$ip", "w") or die("Unable to open file!");
        $content = "ifconfig-push $ip 255.255.255.0";
        fwrite($file, $content);
        fclose($file);
    }

    public function getLastRouterIp()
    {
        $this->load->model('nas');

        return $this->nas->getLastRouterIp();
    }
    
    public function setNewRouter()
    {
        $ip_last = $this->getLastRouterIp();

        $ip_arr = explode('.', $ip_last);

        if($ip_arr[3] < 254) {

            $ip_next = $ip_arr[0] .'.'. $ip_arr[1] .'.'. $ip_arr[2] .'.'. ($ip_arr[3]+1);
        }
        else {
            if($ip_arr[2] < 254) {
                $ip_next = $ip_arr[0] .'.'. $ip_arr[1] .'.'. ($ip_arr[2]+1) .'.0';
            }
            else {
                $ip_next = $ip_arr[0] .'.'. ($ip_arr[1]+1) .'.0.0';
            }
        }

        $this->createConfFileForRouter($ip_next);

        shell_exec('sudo /sbin/service radiusd restart');

        return $ip_next;
    }

    public function getRoutersStatus()
    {
        $routers_ip_array = $_POST['routers_ip_array'];

        $this->load->model('hotel');
        $array_of_status = $this->hotel->getRoutersStatus($routers_ip_array);

        echo json_encode($array_of_status);
    }

    public function getRoutersUsersCount()
    {
        $routers_ip_array = $_POST['routers_ip_array'];

        $this->load->model('hotel');
        $users_count = $this->hotel->getRoutersUsersCount($routers_ip_array);

        echo json_encode($users_count);
    }

    public function getRoutersBandwidth()
    {
        $routers_ip_array = $_POST['routers_ip_array'];

        $this->load->model('hotel');
        $users_count = $this->hotel->getRoutersBandwidth($routers_ip_array);

        echo json_encode($users_count);
    }


    public function nas()
    {
        //Load hotel model
        $this->load->model('hotel');

        $this->grocery_crud->set_table('nas')
            ->columns('nasname', 'shortname', 'secret', 'description', 'hotel_id', 'wanmac', 'wifi')
            ->display_as('nasname',     'Router IP')
            ->display_as('shortname',   'Router name')
            ->display_as('type',        'Type')
            ->display_as('secret',      'Router Radius-VPN pass')
            ->display_as('description', 'Router description')
            ->display_as('hotel_id',    'Hotel name')
            ->display_as('wanmac',      'Wan mac address')
            ->display_as('wifi',        'Wi-Fi yes/no')

            ->field_type('type',        'hidden')
            ->set_relation('hotel_id','hotels', 'name')
            ->field_type('nasname',     'hidden')
            ->field_type('server',      'hidden');

        $this->grocery_crud->unset_columns('secret', 'description', 'wifi');

        //Callback before add new router
        $this->grocery_crud->callback_before_insert(function($post_array) {

            //Generate new added router IP
            $post_array['nasname'] = $this->setNewRouter();

            //Create new Offline file with new router macaddress
            $this->generateOfflinePages($post_array['wanmac']);

            return $post_array;
        });

        $output = $this->grocery_crud->render();

        $this->_nas_output($output);

    }

    function _nas_output($output = null)
    {
        $this->load->view('admin/nas_template.php', $output);
    }


    public function templates()
    {
        $this->grocery_crud->set_table('templates')
            ->columns('name', 'filename')
            ->display_as('name', 'Template name')
            ->display_as('filename', 'Template file name')
            ->set_field_upload('filename', 'assets/uploads/templates');
        $output = $this->grocery_crud->render();

        $this->_templates_output($output);
    }

    function _templates_output($output = null)

    {
        $this->load->view('admin/templates_template.php', $output);
    }

    public function users()
    {
        $this->grocery_crud->set_table('users')
            ->columns('username', 'email', 'password')
            ->display_as('username', 'User name')
            ->display_as('email', 'User email')
            ->display_as('password', 'User password');
        $output = $this->grocery_crud->render();

        $this->_users_output($output);
    }

    function _users_output($output = null)

    {
        $this->load->view('admin/users_template.php', $output);
    }

    public function exportCsv()
    {
        // Get all hotels ['id' => 'name'];
        $all_hotels_ids = $this->hotel->getHotels();

        // File name
        $file = 'emails.txt';

        foreach($all_hotels_ids as $id => $name) {
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

    public function hotels()
    {
     //Load hotel model
        $this->load->model('hotel');
        $this->load->model('template');
        $this->load->model('email');

        $this->grocery_crud->set_table('hotels')
            ->columns('id', 'name', 'alias', 'url', 'Active template', 'session_timeout', 'questions_timeout', 'emails_timeout')
            ->display_as('id', 'Hotel ID')
            ->display_as('name', 'Hotel name')
            ->display_as('alias', 'Email alias')
            ->display_as('session_timeout', 'Session timeout')
            ->display_as('questions_timeout', 'Questions timeout(number of days)')
            ->field_type('questions_timeout', 'integer')
            ->display_as('emails_timeout',     'Emails timeout(number of days)')
            ->field_type('emails_timeout',     'integer')
            ->display_as('url', 'Redirect after login to next URL')
            ->field_type('facebook_page_id',     'hidden');

        //callback after new hotel add
        $this->grocery_crud->callback_after_insert(function($post_array){

            $nextHotelId = $this->hotel->getNextHotelId();

            $newTemplateIds = $this->template->addTemplatesToHotel($nextHotelId);

            $this->template->addTemplateVariablesToTemplates($newTemplateIds);

            //Set English language as default language for the new added hotel
            $this->hotel->setDefaultLanguage($nextHotelId, 1);

            //Create if not exists new contacts list in Elastic based on new hotel alias name
            $this->email->createNewElasticLists($post_array['alias']);

            return $post_array;
        });

        $this->grocery_crud->callback_before_delete(array($this, 'deleteHotelRelationships'));

        $output = $this->grocery_crud->render();

        $this->_hotels_output($output);
    }

    public function setFbPageId()
    {
        $request = $this->fb->request('GET', '/', ['id' => 'https://www.facebook.com/coderiders.am/?fref=ts']);

        $response = $this->fb->getClient()->sendRequest($request);

        var_dump($response);exit;
    }

    public function deleteHotelRelationships($primary_key)
    {
        $this->load->model('hotel');

        $this->hotel->deleteHotel($primary_key);
    }

    function _hotels_output($output = null)
    {
        $this->load->view('admin/nas_template.php', $output);
    }

    public function emails()
    {
        $this->getCsv();

        $this->load->model('email');

        if(isset($_POST['read_and_send'])) {
            $this->readAndSendEmails();
        }

        //Get all emails of left users
        $all_emails = $this->email->getAllEmails();

        $data['emails'] = $all_emails;
        return $this->load->view('admin/emails.php', $data);
    }

    public function getCsv()
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

    public function readAndSendEmails()
    {
        //Get data from attached csv files
        $emails = $this->getAttachment();

        //Insert in db all new emails
        $this->email->insertNewEmails($emails);

        /*Works*/
        $email_list = $this->email->getThreeDayEmails();

        $result = $this->email->addContactsToHotelLeftList($email_list);

        //$this->email->sendElasticEmail($email_list);
    }

    public function defaults()
    {
        $this->load->model('hotel');

        $defaults_variables = $this->hotel->getDefaults();

        $this->load->view('admin/default_variables.php', $defaults_variables);
    }

    public function setDefaults()
    {
        // Get all data from form
        $data = $_POST;

        //Get image files
        $image_data = $_FILES;

        foreach($image_data as $input_name => $img_details) {
            $uploaded_image = $this->uploadImage($input_name);
            if($uploaded_image == false) {
                return redirect('admin/main/defaults', 'refresh');
            } else {
                $data[$input_name] = $uploaded_image;
            }
        }

        $this->load->model('hotel');
        $this->hotel->setDefaults($data);

        return redirect('admin/main/defaults', 'refresh');
    }

    public function icons()
    {
        $this->load->model('hotel');
        $this->load->model('language');

        $data['icons'] = $this->hotel->getIcons();

        $this->load->view('admin/icon_sets.php', $data);
    }

    public function setIcons()
    {
        $this->load->model('hotel');

        if(isset($_POST['icon_set_id']))
        {
            // This mean that we are updating an icon list
            $icon_set_id = $_POST['icon_set_id'];
            $icons = $this->hotel->getSpecificIcons($icon_set_id);

            $update_data = [];
            if($_POST['name'] != $icons['name'])
            {
                $update_data['name'] = $_POST['name'];
            }

            $icon_images = $_FILES;

            foreach($icon_images as $input_name => $img_details)
            {
                if(!empty($img_details['name']))
                {
                    $update_data[$input_name] = $this->updateIcon($input_name, $icons[$input_name]);
                }
            }

            $this->hotel->updateIcons($icon_set_id, $update_data);

            unset($_POST);
        }
        else
        {
            // This mean that we add new icon set
            // Get all data from form
            $icons['name'] = $_POST['name'];

            //Get image files
            $image_data = $_FILES;

            foreach($image_data as $input_name => $img_details){
                $icons[$input_name] = $this->uploadIcon($input_name);
            }

            $this->hotel->setIcons($icons);
        }

        redirect('admin/main/icons', 'refresh');
    }

    public function deleteIconSet()
    {
        $icon_set_id = $_POST['icon_set_id'];

        $this->load->model('hotel');

        //Get icon images names
        $icon_data = $this->hotel->getSpecificIcons($icon_set_id);
        unset($icon_data['id']);
        unset($icon_data['name']);

        // Delete all images from variables folder
        foreach($icon_data as $key => $value)
        {
            unlink("assets/variables/$value");
        }

        return $this->hotel->deleteIconSet($icon_set_id);

    }

    public function setIconSetDefault()
    {
        $this->load->model('hotel');

        $icon_set_id = $_POST['icon_set_id'];

        echo json_encode($this->hotel->setIconSetDefault($icon_set_id));
    }

    public function setIconsForQuestion()
    {
        // Get all data from form
        $question_id = $_POST['question_id'];
        $icon_set_id = $_POST['icon_set_id'];

        $this->load->model('hotel');

        echo json_encode($this->hotel->setIconsForQuestion($question_id, $icon_set_id));
    }

    public function getIcons()
    {
        $this->load->model('hotel');

        echo json_encode($this->hotel->getIcons());
    }


    public function flushMacAddress()
    {
        $router_id = $_POST['router_id'];

        $this->load->model('hotel');

        echo json_encode($this->hotel->flushMacAddress($router_id));
    }

    public function getAttachment()
    {
        /**
         *	Gmail attachment extractor.
         *
         *	Downloads attachments from Gmail and saves it to a file.
         *	Uses PHP IMAP extension, so make sure it is enabled in your php.ini,
         *	extension=php_imap.dll
         *
         */

        set_time_limit(3000);


        /* connect to gmail with your credentials */
        $hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
        $username = 'email@hanglos.nl'; # e.g somebody@gmail.com
        $password = 'b@gr@t12345';

        $result = [];

        /* try to connect */
        $inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

        /* get all new emails. If set to 'ALL' instead
         * of 'NEW' retrieves all the emails, but can be
         * resource intensive, so the following variable,
         * $max_emails, puts the limit on the number of emails downloaded.
         *
         */
        $emails = imap_search($inbox, 'UNSEEN');
//        $emails = imap_search($inbox, 'ALL');

        /* useful only if the above search is set to 'ALL' */
        $max_emails = 2;

        /* file names index*/
        $index = 1;

        /* if any emails found, iterate through each email */
        if($emails) {

            $count = 1;

            /* put the newest emails on top */
            rsort($emails);

            /* for every email... */
            foreach($emails as $email_number)
            {

                /* get information specific to this email */
                $overview = imap_fetch_overview($inbox,$email_number,0);

                /* get mail message */
                $message = imap_fetchbody($inbox,$email_number,2);

                /* get mail structure */
                $structure = imap_fetchstructure($inbox, $email_number);

                $header = imap_headerinfo($inbox, $email_number);

                //Get email alias
                $alias = $header->to[0]->mailbox;
//                $sender = $header->from[0]->mailbox . "@" . $header->from[0]->host;

                $attachments = array();

                /* if any attachments found... */
                if(isset($structure->parts) && count($structure->parts))
                {
                    for($i = 0; $i < count($structure->parts); $i++)
                    {
                        $attachments[$i] = array(
                            'is_attachment' => false,
                            'filename' => '',
                            'name' => '',
                            'attachment' => ''
                        );

                        if($structure->parts[$i]->ifdparameters)
                        {
                            foreach($structure->parts[$i]->dparameters as $object)
                            {
                                if(strtolower($object->attribute) == 'filename')
                                {
                                    $attachments[$i]['is_attachment'] = true;
                                    $attachments[$i]['filename'] = $object->value;
                                }
                            }
                        }

                        if($structure->parts[$i]->ifparameters)
                        {
                            foreach($structure->parts[$i]->parameters as $object)
                            {
                                if(strtolower($object->attribute) == 'name')
                                {
                                    $attachments[$i]['is_attachment'] = true;
                                    $attachments[$i]['name'] = $object->value;
                                }
                            }
                        }

                        if($attachments[$i]['is_attachment'])
                        {
                            $attachments[$i]['attachment'] = imap_fetchbody($inbox, $email_number, $i+1);

                            /* 4 = QUOTED-PRINTABLE encoding */
                            if($structure->parts[$i]->encoding == 3)
                            {
                                $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                            }
                            /* 3 = BASE64 encoding */
                            elseif($structure->parts[$i]->encoding == 4)
                            {
                                $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                            }
                        }
                    }

                }

                /* iterate through each attachment and save it */
                foreach($attachments as $attachment)
                {
                    if($attachment['is_attachment'] == 1)
                    {
                        $filename = $attachment['name'];
                        if(empty($filename)) $filename = $attachment['filename'];

                        if(empty($filename)) $filename = time() . ".dat";

                        /* prefix the email number to the filename in case two emails
                         * have the attachment with the same file name.
                         */
                        $path =  $filename .'-'. $index++;
                        $fp = fopen($path, "w+");
                        fwrite($fp, $attachment['attachment']);
                        fclose($fp);

                        $parsedCSV = $this->parseCSV($path, $alias);

                        if(count($parsedCSV)) {
                            $result[] = $parsedCSV;
                        }

                    }

                }

                if($count++ >= $max_emails) break;
            }

        }

        /* close the connection */
        imap_close($inbox);

        return $result;
    }

    public function parseCSV($p_Filepath, $alias)
    {

        $separator = ';';   // separator used to explode each line
        $enclosure = '500';   // enclosure used to decorate each field

        $max_row_size = 4096 * 2;    /** maximum row size to be used for decoding */

        $file = fopen($p_Filepath, 'r');
        $keys_values = fgetcsv($file, $max_row_size, $separator, $enclosure);

        $content = array();
        $keys    = $this->escape_string($keys_values);

        $i  =   1;
        while( ($row = fgetcsv($file, $max_row_size, $separator, $enclosure)) != false )
        {
            if( $row != null )
            {
                // skip empty lines
                if(count($keys) == count($row))
                {
                    $arr = array();
                    $new_values = $this->escape_string($row);

                    for($j = 0; $j < count($keys); $j++)
                    {
                        if($keys[$j] != "")
                        {
                            if($keys[$j] == 'email') {
                                $arr[$keys[$j]] = $new_values[$j];
                            }
                            if($keys[$j] == 'firstname' || $keys[$j] == 'lastname') {
                                $arr[$keys[$j]] = $new_values[$j];
                            }
                            elseif($keys[$j] == 'attribute_1' || $keys[$j] == 'attribute_2'){
                                $arr[$keys[$j]] = date("Y-m-d H:i:s", strtotime($new_values[$j]));
                            }

                            $arr['alias'] = $alias;
                        }
                    }

                    if(trim($arr['email']) != '') {
                        $content[$i++] = $arr;
                    }
                }
            }
        }


        fclose($file);

        unlink($p_Filepath);

        return $content;
    }

    public function escape_string($data){
        $result =   array();
        foreach($data as $row){
            $result[]   =   str_replace('"', '', $row);
        }
        return $result;
    }
}
