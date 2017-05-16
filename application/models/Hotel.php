<?php


class Hotel extends CI_Model
{

    public function getHotelNameById($hotel_id)
    {
        return $this->db->select('name')->where('id', $hotel_id)->get('hotels')->row_array()['name'];
    }

    /**
     * @param $hotel_id
     * @return mixed
     */
    public function getActiveTemplateForHotel($hotel_id)
    {
        return $this->db->select('active_template_id')->where('id', $hotel_id)->get('hotels')->row_array()['active_template_id'];
    }

    /**
     * Data format: [{'active_template_id', value}, {template_id, name}, {...}]
     *
     * @param $hotel_id
     * @return array
     */
    public function getHotelTemplatesAndActiveTemplate($hotel_id)
    {
        $result = $this->db->select('id, name')->where('hotel_id', $hotel_id)->get('templates')->result_array();

        $templates_list = [];

        foreach ($result as $key => $value) {
            $templates_list[$value['id']] = $value['name'];
        }

        $templates_list['active_template_id'] = $this->getActiveTemplateForHotel($hotel_id);

        return $templates_list;
    }

    /**
     * Get list of all hotels
     *
     * @return mixed
     */
    public function getHotels()
    {
        $result = $this->db->select('id, name')->get('hotels')->result_array();

        $result_arr = [];
        foreach ($result as $id => $name) {

            $result_arr[$name['id']] = $name['name'];
        }

        return $result_arr;
    }

    public function getAllHotelsAndTemplates()
    {
        $result = $this->db->select('*')
                            ->from('hotels')
                            ->join('templates', 'templates.hotel_id = hotels.id', 'right')
                            ->get()
                            ->result_array();

        $array = [];
        foreach ($result as $key => $value) {
            if(empty($array[$value['hotel_id']])) {
                $array[$value['hotel_id']] = [];
            }
            $array[$value['hotel_id']][0] = $value['active_template_id'];
            $array[$value['hotel_id']][$value['id']] = $value['name'];
        }

        return $array;
    }

    public function getActiveLanguages($hotel_id)
    {
        $result = $this->db->select('language_id, name')
                            ->from('hotel_language')
                            ->join('languages', 'languages.id = hotel_language.language_id', 'left')
                            ->where('hotel_id', $hotel_id)
                            ->get()
                            ->result_array();

        return $result;
    }

    public function getDefaultLanguage($hotel_id)
    {
        $result = $this->db->select('language_id')
                            ->from('hotel_language')
                            ->where('hotel_id', $hotel_id)
                            ->where('is_default', '1')
                            ->get()
                            ->row_array()['language_id'];

        return $result;
    }

    public function getDefaultTerms()
    {
        $result = $this->db->select('title, text')
                            ->from('translate_term')
                            ->where('language_id', 1)
                            ->get()
                            ->row_array();

        return $result;
    }

    public function getTerm($language_id)
    {
        $result = $this->db->select('title, text')
                            ->from('translate_term')
                            ->where('language_id', $language_id)
                            ->get()
                            ->row_array();

        if(!$result)
            return array();

        return $result;
    }

    public function editTerm($language_id, $title, $text)
    {
        $check = $this->db->select('*')
                            ->where('language_id', $language_id)
                            ->get('translate_term')
                            ->num_rows();
        $data = [
            'language_id' => $language_id,
            'title' => $title,
            'text'  => $text
        ];

        if($check) {
            $this->db->where('language_id', $language_id);
            $result = $this->db->update('translate_term', $data);
        } else {
            $result = $this->db->insert('translate_term', $data);
        }

        return filter_var($result, FILTER_VALIDATE_BOOLEAN);
    }

    public function getHotelQuestionsId($hotel_id)
    {
        $result = $this->db->select('question_id')
                            ->distinct()
                            ->where('hotel_id', $hotel_id)
                            ->get('stats')
                            ->result_array();

        $questions_id = [];
        foreach($result as $key => $value) {
            $questions_id[] = intval($value['question_id']);
        }

        return $questions_id;
    }

    public function getHotelIdAndText($hotel_id)
    {
        // Get translate_id for current language
        $translate_id = $this->db->select('translate_id')
                                    ->from('hotel_language')
                                    ->join('languages', 'languages.id = hotel_language.language_id', 'left')
                                    ->where('languages.name', 'English')
                                    ->where('hotel_id', $hotel_id)
                                    ->get()
                                    ->row_array()['translate_id'];

        $pairs = $this->db->select('hotel_question.question_id, text')
                            ->from('hotel_question')
                            ->join('translate_question', 'translate_question.question_id = hotel_question.question_id', 'left')
                            ->where('hotel_id', $hotel_id)
                            ->where('translate_id', $translate_id)
                            ->get()
                            ->result_array();

        $result = [];
        foreach($pairs as $key =>$value) {
            $result[$value['question_id']] = $value['text'];
        }

        return $result;
    }

    public function getHotelQuestionsStats($hotel_id)
    {
        $result = $this->db->select('question_id, answer')
                            ->where('hotel_id', $hotel_id)
                            ->get('stats')
                            ->result_array();

        return $result;
    }

    public function getHotelEmailsList($hotel_id)
    {
        $result = $this->db->select('email, created_at, updated_at')
                            ->where('hotel_id', $hotel_id)
                            ->limit(2)
                            ->order_by('updated_at', 'DESC')
                            ->get('emails')
                            ->result_array();

        return $result;
    }

    public function getHotelEmailsListPaginated($hotel_id, $limit, $offset)
    {
        $result = $this->db->select('email, created_at, updated_at')
                            ->where('hotel_id', $hotel_id)
                            ->limit($limit, $offset)
                            ->get('emails')
                            ->result_array();

        return $result;
    }

    public function getHotelEmailsListRanged($hotel_id, $from, $to)
    {
        $from_date = date("Y-m-d 00:00:00", $from);
        $to_date   = date("Y-m-d 00:00:00", $to);


        $result = $this->db->select('email, created_at, updated_at')
                            ->where('hotel_id', $hotel_id)
                            ->where('updated_at >=', $from_date)
                            ->where('updated_at <=', $to_date)
                            ->get('emails')
                            ->result_array();

        return $result;
    }

    public function setHotelActiveTemplate($hotel_id, $template_id)
    {
        $data = array(
            'active_template_id' => $template_id
        );

        return $this->db->where('id', $hotel_id)->update('hotels', $data);
    }

    public function setHotelActiveQuestion($hotel_id, $question_id)
    {
        //Get hotel's templates ids
//        $templates_ids = $this->db->select('id')->where('hotel_id', $hotel_id)->get('templates')->result_array();
//        $array_ids = [];
//        foreach($templates_ids as $key => $value) {
//            $array_ids[] = $value['id'];
//        }
//
//        $this->db->where_in('template_id', $array_ids)->update('questions', array('is_first' => 0));

        // Get all questions belong to this hotel id and reset active status
        $this->db->where('hotel_id', $hotel_id)->update('hotel_question', array('is_first' => 0));

        return $this->db->where('question_id', $question_id)->update('hotel_question', array('is_first' => 1));
    }

    /**
     * @param $hotel_id
     * @param $text
     * @param $language
     * @return mixed
     */
    public function addNewQuestion($hotel_id, $text, $language)
    {
        // Get default icon_set_id
        $default_icon_set_id = $this->db->select('id')
                                        ->where('default', 1)
                                        ->get('icon_sets')
                                        ->row_array()['id'];

        // Add new question in hotel_question table
        $data = [
            'hotel_id'    => $hotel_id,
            'is_first'    => '0',
            'icon_set_id' => $default_icon_set_id
        ];

        $this->db->insert('hotel_question', $data);
        // Get new added question ID
        $new_question_id = $this->db->insert_id();

        // Get translate_id for current language
        $translate_id = $this->db->select('translate_id')
                                    ->from('hotel_language')
                                    ->join('languages', 'languages.id = hotel_language.language_id', 'left')
                                    ->where('languages.name', $language)
                                    ->where('hotel_id', $hotel_id)
                                    ->get()
                                    ->row_array()['translate_id'];

        $translate_question_data = [
            'translate_id' => $translate_id,
            'question_id'  => $new_question_id,
            'text'         => $text
        ];

        //Insert new question into the translate_question
        $result = $this->db->insert('translate_question', $translate_question_data);


        // Get all rest languages ids
        $linked_languages = $this->db->select('translate_id')
                                        ->where('hotel_id', $hotel_id)
                                        ->where('translate_id !=', $translate_id)
                                        ->get('hotel_language')
                                        ->result_array();

        // Insert current question for all linked languages
        foreach($linked_languages as $key => $tmp_translate_id)
        {
            $tmp_data = [
                'translate_id' => $tmp_translate_id['translate_id'],
                'question_id'  => $new_question_id,
                'text'         => $text
            ];

            $this->db->insert('translate_question', $tmp_data);
        }

        return $this->getIcons();
    }

    public function deleteHotelQuestion($question_id)
    {
        return $this->db->where('question_id', $question_id)->delete('hotel_question');
    }

    public function editHotelQuestion($hotel_id, $question_id, $text, $language)
    {
        $translate_id = $this->db->select('translate_id')
                                    ->from('hotel_language')
                                    ->join('languages', 'languages.id = hotel_language.language_id', 'left')
                                    ->where('languages.name', $language)
                                    ->where('hotel_id', $hotel_id)
                                    ->get()
                                    ->row_array()['translate_id'];

        return $this->db->where('question_id', $question_id)
                        ->where('translate_id', $translate_id)
                        ->update('translate_question', array('text' => $text));
    }

    public function getNextHotelId()
    {
        $result = $this->db->select('id')
                            ->order_by("id", "desc")
                            ->limit(1)
                            ->get('hotels')
                            ->row_array()['id'];
        return $result;
    }

    public function addActiveLanguage($hotel_id, $language_id)
    {
        $this->db->insert('hotel_language', array(
            'hotel_id'    => $hotel_id,
            'language_id' => $language_id,
            'is_default'  => '0'
        ));

        $translate_id = $this->db->insert_id();

        $res_1 = $this->setDefaultTranslateLogin($translate_id);
        $res_1 = filter_var($res_1, FILTER_VALIDATE_BOOLEAN);

        $res_2 = $this->setDefaultTranslateEmail($translate_id);
        $res_2 = filter_var($res_2, FILTER_VALIDATE_BOOLEAN);

        $res_3 = $this->setDefaultTranslateFacebook($translate_id);
        $res_3 = filter_var($res_3, FILTER_VALIDATE_BOOLEAN);

        $translate_question_label_data = [
            'translate_id'             => $translate_id,
            'translate_question_label' => 'Answer and go online >'
        ];

        $res_4 = $this->db->insert('translate_question_label', $translate_question_label_data);
        $res_4 = filter_var($res_4, FILTER_VALIDATE_BOOLEAN);

        $res_5 = $this->setQuestionsForNewLanguage($translate_id, $hotel_id);
        $res_5 = filter_var($res_5, FILTER_VALIDATE_BOOLEAN);

        return $res_1 || $res_2 || $res_3 || $res_4 || $res_5;

    }

    public function removeActiveLanguage($hotel_id, $language_id)
    {
        return $this->db->where('hotel_id', $hotel_id)->where('language_id', $language_id)->delete('hotel_language');
    }

    public function setDefaultTranslateLogin($translate_id)
    {
        $default_login_data = $this->db->select('login_header_text, login_btn_text, login_btn_label')
                                        ->get('defaults')
                                        ->row_array();

        $translate_data = [
            'translate_id'    => $translate_id,
            'hotel_label_1'   => $default_login_data['login_header_text'],
            'hotel_label_2'   => $default_login_data['login_btn_label'],
            'hotel_btn_label' => $default_login_data['login_btn_text']
        ];

        return $this->db->insert('translate_login', $translate_data);
    }

    public function setDefaultTranslateEmail($translate_id)
    {
        $default_email_data = $this->db->select('email_header_text, email_btn_text, email_placeholder_text')
                                        ->get('defaults')
                                        ->row_array();

        $translate_data = [
            'translate_id'    => $translate_id,
            'hotel_label_1'   => $default_email_data['email_header_text'],
            'hotel_label_2'   => $default_email_data['email_placeholder_text'],
            'hotel_btn_label' => $default_email_data['email_header_text'],
        ];

        return $this->db->insert('translate_email', $translate_data);
    }

    public function setDefaultTranslateFacebook($translate_id)
    {
        $translate_data = [
            'translate_id'  => $translate_id,
            'title'         => 'Title',
            'fb_title'      => 'Facebook Title',
            'middle_title'  => 'Middle Title',
            'email_title'   => 'Email Title',
            'like_title'    => 'Like Title',
        ];

        return $this->db->insert('translate_fb', $translate_data);
    }

    public function setDefaultTranslateQuestion($translate_id, $question_id)
    {
        $default_question_data = $this->db->select('question_text, question_label')
                                        ->get('defaults')
                                        ->row_array();

        $translate_data = [
            'translate_id' => $translate_id,
            'question_id'  => $question_id,
            'text'         => $default_question_data['question_text']
        ];

        $translate_question_label_data = [
            'translate_id'             => $translate_id,
            'translate_question_label' => $default_question_data['question_label']
        ];

        $this->db->insert('translate_question_label', $translate_question_label_data);

        return $this->db->insert('translate_question', $translate_data);
    }

    public function setDefaultTranslateTerm()
    {
        $default_term_data = $this->db->select('term_title, term_text')
                                            ->get('defaults')
                                            ->row_array();

        $translate_term_data = [
            'language_id'  => 1,
            'title'        => $default_term_data['term_title'],
            'text'         => $default_term_data['term_text']
        ];

        return $this->db->insert('translate_term', $translate_term_data);
    }

    public function setQuestionsForNewLanguage($translate_id, $hotel_id)
    {
        $default_question_data = $this->db->select('question_text, question_label')
                                            ->get('defaults')
                                            ->row_array();

        // Get current hotel's questions
        $all_languges = $this->db->select('question_id')
                                    ->where('hotel_id', $hotel_id)
                                    ->get('hotel_question')
                                    ->result_array();

        foreach($all_languges as $key => $question_id_value)
        {
            $data = [
                'translate_id' => $translate_id,
                'question_id'  => $question_id_value['question_id'],
                'text'         => $default_question_data['question_text']
            ];

            $this->db->insert('translate_question', $data);
        }
    }

    public function addDefaultQuestion($hotel_id)
    {
        $hotel_question_data = [
            'hotel_id'        => $hotel_id,
            'is_first'        => '1',
            'icon_set_id'     => $this->getDefaultIconSet()
        ];

        $this->db->insert('hotel_question', $hotel_question_data);
        return $this->db->insert_id();
    }

    public function setDefaultLanguage($hotel_id, $language_id)
    {
        $data = [
            'hotel_id'    => $hotel_id,
            'language_id' => $language_id,
            'is_default'  => '1'
        ];
        $this->db->insert('hotel_language', $data);

        $translate_id = $this->db->insert_id();

        //Insert default English row in Translate Login
        $this->setDefaultTranslateLogin($translate_id);

        //Insert default English row in Translate Email
        $this->setDefaultTranslateEmail($translate_id);

        //Insert default English row in Translate Facebook
        $this->setDefaultTranslateFacebook($translate_id);

        //Insert default English Question
        $question_id = $this->addDefaultQuestion($hotel_id);

        //Insert default English row in Translate Question
        $this->setDefaultTranslateQuestion($translate_id, $question_id);

        //Insert default English row in Translate Term table
        $this->setDefaultTranslateTerm();
    }

    public function changeDefaultLanguage($hotel_id, $language_id)
    {
        $this->db->where('hotel_id', $hotel_id)
                    ->where('is_default', '1')
                    ->update('hotel_language', ['is_default' => '0']);

        return $this->db->where('hotel_id', $hotel_id)
                        ->where('language_id', $language_id)
                        ->update('hotel_language', ['is_default' => '1']);
    }

    public function getTemplateLoginTranslate($translate_id)
    {
        
    }

    public function deleteHotel($hotel_id)
    {
        // Update NAS table set all linked router's hotel_id = NULL
        $result_nas = $this->db->where('hotel_id', $hotel_id)->update('nas', ['hotel_id' => NULL]);

        // Delete rows from templates
        $result_templates = $this->db->where('hotel_id', $hotel_id)->delete('templates');
    }

    public function setDefaults($data)
    {
        $check = $this->db->get('defaults')->num_rows();

        if(!$check) {
            return $this->db->insert('defaults', $data);
        } else {
            $exist_row = $this->db->get('defaults')->row();
            $exist_row_id = $exist_row->id;
            return $this->db->where('id', $exist_row_id)->update('defaults', $data);
        }

    }

    public function getDefaults()
    {
        return $this->db->get('defaults')->row_array();
    }

    public function getIcons()
    {
        return $this->db->get('icon_sets')->result_array();
    }

    public function getDefaultIconSet()
    {
        $icon_set = $this->db->select('id')->where('default', 1)->get('icon_sets')->row_array();

        return $icon_set['id'];
    }

    public function getSpecificIcons($icon_set_id)
    {
        return $this->db->where("id", $icon_set_id)->get('icon_sets')->row_array();
    }

    public function setIcons($data)
    {
        return $this->db->insert('icon_sets', $data);
    }

    public function updateIcons($icon_set_id, $data)
    {
        return $this->db->where('id', $icon_set_id)->update('icon_sets', $data);
    }

    public function deleteIconSet($icon_set_id)
    {
        return $this->db->where('id', $icon_set_id)->delete('icon_sets');
    }

    public function setIconsForQuestion($question_id, $icon_set_id)
    {
        $this->db->where('question_id', $question_id);
        return $this->db->update('hotel_question', array('icon_set_id' => $icon_set_id));
    }

    public function setIconSetDefault($icon_set_id)
    {
        // Drop all defaults
        $this->db->update('icon_sets', ['default' => '0']);

        // Set default
        return  $this->db->where('id', $icon_set_id)->update('icon_sets', ['default' => 1]);

        return filter_var($result, FILTER_VALIDATE_BOOLEAN);
    }

    public function flushMacAddress($router_id)
    {
        $res_1 = $this->db->where('router_ip', $router_id)->delete('answers');

        $res_2 = $this->db->where('router_ip', $router_id)->delete('emails');

        $result = $res_1 || $res_2;

        return filter_var($result, FILTER_VALIDATE_BOOLEAN);
    }

    public function getRoutersStatus($routers_ip_array)
    {
//        select * from raddact where username='[ROUTER_VPN_IP]' and acctstoptime is null must back not empy

        $users_array = [];
        foreach($routers_ip_array as $key => $value)
        {
            $query = "SELECT * FROM radacct WHERE username = '$value' AND acctstoptime IS NULL";

            $users_array[$value] = $this->db->query($query)->num_rows();
        }

        return $users_array;
    }

    public function getRoutersUsersCount($routers_ip_array)
    {
        $users_array = [];
        foreach($routers_ip_array as $key => $value)
        {
            $query = "SELECT COUNT(DISTINCT username) AS 'count' FROM radacct WHERE nasipaddress = '$value' AND acctstoptime IS NULL";

            $users_array[$value] = $this->db->query($query)->row_array()['count'];
        }

        return $users_array;
    }

    public function getRoutersBandwidth($routers_ip_array)
    {
        $today_start = date("Y-m-d 00:00:00", time());

        $traffic_array = [];
        foreach($routers_ip_array as $key => $value)
        {
            $query = "SELECT SUM(acctinputoctets) as input, SUM(acctoutputoctets) as output
                      FROM radacct
                      WHERE nasipaddress = '$value' AND acctstarttime >= '$today_start'";

            $input  = intval($this->db->query($query)->row_array()['input']);
            $output = intval($this->db->query($query)->row_array()['output']);

            $traffic_array[$value] = $input + $output;
        }

        return $traffic_array;
    }
}