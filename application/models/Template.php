<?php


class Template extends CI_Model
{

    /**
     * @param $hotel_id
     * @param $template_name
     * @return mixed
     */
    public function getTemplateIdByHotelIdAndTemplateName($hotel_id, $template_name)
    {
        return $this->db->select('id')
                        ->where('hotel_id', $hotel_id)
                        ->where('name', $template_name)
                        ->get('templates')
                        ->row_array()['id'];
    }

    /**
     * @param $template_id
     * @return mixed
     */
    public function getTemplateNameById($template_id)
    {
        return $this->db->select('name')
                        ->where('id', $template_id)
                        ->get('templates')
                        ->row_array()['name'];
    }

    /**
     * @param $template_id
     * @return mixed
     */
    public function getHotelIdByTemplateId($template_id)
    {
        return $this->db->select('hotel_id')->where('id', $template_id)->get('templates')->row_array()['hotel_id'];
    }

    /**
     * @param $hotel_id
     * @param $template_id
     * @return mixed
     */
    public function getTemplateVariables($hotel_id, $template_id)
    {
        $template_variables = $this->db->select('*')
                                        ->where('template_id', $template_id)
                                        ->get('templates_variables')
                                        ->row_array();

        // Get Template Name [Login, Email, Question]
        $template_name = $this->getTemplateNameById($template_id);

        switch($template_name) {
            case "Login template":
                $text_variables = $this->getTranslateLoginTexts($hotel_id);
                $template_variables['template_type']  = 'Login template';
                $template_variables = array_merge($template_variables, $text_variables);
                break;
            case "Email template":
                $text_variables = $this->getTranslateEmailTexts($hotel_id);
                $template_variables['template_type']  = 'Email template';
                $template_variables = array_merge($template_variables, $text_variables);
                break;
            case "Facebook template":
                $text_variables = $this->getTranslateFacebookTexts($hotel_id);
                $template_variables['template_type']  = 'Facebook template';
                $template_variables = array_merge($template_variables, $text_variables);
                break;
            case "Question template":
                $text_variables = $this->getTranslateQuestionTexts($hotel_id);
                $template_variables['translate_question_label'] = $text_variables['translate_question_label'];
                unset($text_variables['translate_question_label']);
                $template_variables['questions_list'] = $text_variables;
                $this->load->model('hotel');
                $template_variables['icons'] = $this->hotel->getIcons();
                $template_variables['template_type']  = 'Question template';
                break;
        }

        return $template_variables;
    }

    public function getTranslateLoginTexts($hotel_id, $language = "English")
    {
        $translate_id = $this->db->select('translate_id')
                                    ->from('hotel_language')
                                    ->join('languages', 'languages.id = hotel_language.language_id', 'left')
                                    ->where('languages.name', $language)
                                    ->where('hotel_id', $hotel_id)
                                    ->get()
                                    ->row_array()['translate_id'];

        $texts = $this->db->select('hotel_label_1, hotel_label_2, hotel_btn_label')
                            ->where('translate_id', $translate_id)
                            ->get('translate_login')
                            ->row_array();
        return $texts;
    }

    public function getTranslateEmailTexts($hotel_id, $language = "English")
    {

        $translate_id = $this->db->select('translate_id')
                                    ->from('hotel_language')
                                    ->join('languages', 'languages.id = hotel_language.language_id', 'left')
                                    ->where('languages.name', $language)
                                    ->where('hotel_id', $hotel_id)
                                    ->get()
                                    ->row_array()['translate_id'];

        $texts = $this->db->select('hotel_label_1, hotel_label_2, hotel_btn_label')
                            ->where('translate_id', $translate_id)
                            ->get('translate_email')
                            ->row_array();
        return $texts;
    }

    public function getTranslateFacebookTexts($hotel_id, $language = "English")
    {

        $translate_id = $this->db->select('translate_id')
                                    ->from('hotel_language')
                                    ->join('languages', 'languages.id = hotel_language.language_id', 'left')
                                    ->where('languages.name', $language)
                                    ->where('hotel_id', $hotel_id)
                                    ->get()
                                    ->row_array()['translate_id'];

        $texts = $this->db->select('*')
                            ->where('translate_id', $translate_id)
                            ->get('translate_fb')
                            ->row_array();
        return $texts;
    }

    public function getTranslateQuestionTexts($hotel_id, $language = "English")
    {

        $translate_id = $this->db->select('translate_id')
                                    ->from('hotel_language')
                                    ->join('languages', 'languages.id = hotel_language.language_id', 'left')
                                    ->where('languages.name', $language)
                                    ->where('hotel_id', $hotel_id)
                                    ->get()
                                    ->row_array()['translate_id'];

        $texts = $this->db->select('text, is_first, hotel_question.question_id, icon_set_id')
                            ->from('translate_question')
                            ->join('hotel_question', 'hotel_question.question_id = translate_question.question_id', 'left')
                            ->where('translate_id', $translate_id)
                            ->get()
                            ->result_array();


        $texts['translate_question_label'] = $this->getTranslateQuestionLabel($translate_id);

        return $texts;
    }

    public function getTranslateQuestionLabel($translate_id)
    {
        $texts = $this->db->select('translate_question_label')
                            ->where('translate_id', $translate_id)
                            ->get('translate_question_label')
                            ->row_array()['translate_question_label'];
        return $texts;
    }


    public function getTranslate($hotel_id, $language, $template_type)
    {
        switch($template_type) {
            case "Login template":
                return $this->getTranslateLoginTexts($hotel_id, $language);
            case "Email template":
                return $this->getTranslateEmailTexts($hotel_id, $language);
            case "Question template":
                return $this->getTranslateQuestionTexts($hotel_id, $language);
            case "Facebook template":
                return $this->getTranslateFacebookTexts($hotel_id, $language);
        }
    }

    /**
     * @param $data
     * @return mixed
     */
    public function setTemplateVariables($data)
    {
        // Get Template Name [Login, Email, Question]
        $template_name = $this->getTemplateNameById($data['template_id']);

        //Check if background image and logo chosen
        if(empty($data['hotel_bg_image'])) {
            unset($data['hotel_bg_image']);
        }

        if(empty($data['hotel_logo'])) {
            unset($data['hotel_logo']);
        }

        switch($template_name) {
            case "Login template":
                // Add variables in the templates_variables
                $res_1 = $this->setTemplateLoginVariables($data);
                // Add texts in the template_login
                $res_2 = $this->setTemplateLoginTexts($data);
                return $res_1 || $res_2;
                break;
            case "Email template":
                // Add variables in the templates_variables
                $res_1 = $this->setTemplateEmailVariables($data);
                // Add texts in the template_email
                $res_2 = $this->setTemplateEmailTexts($data);
                return $res_1 || $res_2;
                break;
            case "Facebook template":
                // Add variables in the templates_variables
                $res_1 = $this->setTemplateFacebookVariables($data);
                // Add texts in the template_facebook
                $res_2 = $this->setTemplateFacebookTexts($data);
                return $res_1 || $res_2;
                break;
            case "Question template":
                // Add variables in the templates_variables
                $res_1 = $this->setTemplateQuestionVariables($data);
                // Add texts in the template_question
                $res_2 = $this->setTemplateQuestionTexts($data);
                return $res_1 || $res_2;
                break;
        }
    }

    /***********************************Set Login Template Variables***********************************************/
    public function setTemplateLoginVariables($data)
    {
        //Unset from main $data all data which are for translate table
        unset($data['hotel_label_1']);
        unset($data['hotel_label_2']);
        unset($data['hotel_btn_label']);
        unset($data['hotel_id']);
        unset($data['form_language']);
        unset($data['template_type']);

        $this->db->where('template_id', $data['template_id']);
        $result = $this->db->update('templates_variables', $data);

        return filter_var($result, FILTER_VALIDATE_BOOLEAN);
    }

    public function setTemplateLoginTexts($data)
    {
        $language = $data['form_language'];
        $hotel_id = $data['hotel_id'];

        $translate_id = $this->db->select('translate_id')
                                    ->from('hotel_language')
                                    ->join('languages', 'languages.id = hotel_language.language_id', 'left')
                                    ->where('hotel_language.hotel_id', $hotel_id)
                                    ->where('languages.name', $language)
                                    ->get()
                                    ->row_array()['translate_id'];

        //Insert into Translate table with $translate_id row
        $translate_data = [
            'hotel_label_1'   => $data['hotel_label_1'],
            'hotel_label_2'   => $data['hotel_label_2'],
            'hotel_btn_label' => $data['hotel_btn_label']
        ];

        $this->db->where('translate_id', $translate_id);
        $result = $this->db->update('translate_login', $translate_data);

        return filter_var($result, FILTER_VALIDATE_BOOLEAN);
    }

    /***********************************Set Email Template Variables***********************************************/
    public function setTemplateEmailVariables($data)
    {
        //Unset from main $data all data which are for translate table
        unset($data['hotel_label_1']);
        unset($data['hotel_label_2']);
        unset($data['hotel_btn_label']);
        unset($data['hotel_id']);
        unset($data['form_language']);
        unset($data['template_type']);

        $this->db->where('template_id', $data['template_id']);
        $result = $this->db->update('templates_variables', $data);

        return filter_var($result, FILTER_VALIDATE_BOOLEAN);
    }

    public function setTemplateEmailTexts($data)
    {
        $language = $data['form_language'];
        $hotel_id = $data['hotel_id'];

        $translate_id = $this->db->select('translate_id')
                                    ->from('hotel_language')
                                    ->join('languages', 'languages.id = hotel_language.language_id', 'left')
                                    ->where('hotel_language.hotel_id', $hotel_id)
                                    ->where('languages.name', $language)
                                    ->get()
                                    ->row_array()['translate_id'];

        //Insert into Translate table with $translate_id row
        $translate_data = [
            'hotel_label_1'   => $data['hotel_label_1'],
            'hotel_label_2'   => $data['hotel_label_2'],
            'hotel_btn_label' => $data['hotel_btn_label']
        ];

        $this->db->where('translate_id', $translate_id);
        $result = $this->db->update('translate_email', $translate_data);

        return filter_var($result, FILTER_VALIDATE_BOOLEAN);
    }

    /***********************************Set Facebook Template Variables***********************************************/
    public function setTemplateFacebookVariables($data)
    {
        //Unset from main $data all data which are for translate table
        unset($data['title']);
        unset($data['fb_title']);
        unset($data['middle_title']);
        unset($data['email_title']);
        unset($data['hotel_id']);
        unset($data['form_language']);
        unset($data['template_type']);

        $this->db->where('template_id', $data['template_id']);
        $result = $this->db->update('templates_variables', $data);

        return filter_var($result, FILTER_VALIDATE_BOOLEAN);
    }

    public function setTemplateFacebookTexts($data)
    {
        $language = $data['form_language'];
        $hotel_id = $data['hotel_id'];

        $translate_id = $this->db->select('translate_id')
            ->from('hotel_language')
            ->join('languages', 'languages.id = hotel_language.language_id', 'left')
            ->where('hotel_language.hotel_id', $hotel_id)
            ->where('languages.name', $language)
            ->get()
            ->row_array()['translate_id'];



        //Insert into Translate table with $translate_id row
        $translate_data = [
            'title'        => $data['title'],
            'fb_title'     => $data['fb_title'],
            'middle_title' => $data['middle_title'],
            'email_title'  => $data['email_title'],
        ];

        var_dump($translate_id);
        var_dump($translate_data); exit;
        $this->db->where('translate_id', $translate_id);
        $result = $this->db->update('translate_fb', $translate_data);

        return filter_var($result, FILTER_VALIDATE_BOOLEAN);
    }

    /***********************************Set Question Template Variables***********************************************/
    public function setTemplateQuestionVariables($data)
    {
        //Unset from main $data all data which are for translate table
        unset($data['translate_question_label']);
        unset($data['hotel_id']);
        unset($data['form_language']);
        unset($data['template_type']);

        $this->db->where('template_id', $data['template_id']);
        $result = $this->db->update('templates_variables', $data);

        return filter_var($result, FILTER_VALIDATE_BOOLEAN);
    }

    public function setTemplateQuestionTexts($data)
    {
        $language = $data['form_language'];
        $hotel_id = $data['hotel_id'];

        $translate_id = $this->db->select('translate_id')
                                    ->from('hotel_language')
                                    ->join('languages', 'languages.id = hotel_language.language_id', 'left')
                                    ->where('hotel_language.hotel_id', $hotel_id)
                                    ->where('languages.name', $language)
                                    ->get()
                                    ->row_array()['translate_id'];

        //Insert into Translate table with $translate_id row
        $translate_data = [
            'translate_question_label' => $data['translate_question_label']
        ];

        //check if translate exists
        $translate_exists = $this->db->where('translate_id', $translate_id)->get('translate_question_label')->num_rows();

        if($translate_exists) {
            $this->db->where('translate_id', $translate_id);
            $result = $this->db->update('translate_question_label', $translate_data);
        } else {
            $result = $this->db->insert('translate_question_label', $translate_data);
        }

        return filter_var($result, FILTER_VALIDATE_BOOLEAN);
    }


    /**
     * @param $hotel_id
     * @return array of ids of new added Hotel's templates
     */
    public function addTemplatesToHotel($hotel_id)
    {
        $new_templates = [];

        $this->db->insert('templates', ['hotel_id' => $hotel_id, 'name' => 'Login template']);
        $new_templates[] = $this->db->insert_id();

        $this->db->insert('templates', ['hotel_id' => $hotel_id, 'name' => 'Email template']);
        $new_templates[] = $this->db->insert_id();

        $this->db->insert('templates', ['hotel_id' => $hotel_id, 'name' => 'Question template']);
        $new_templates[] = $this->db->insert_id();

        return $new_templates;
    }

    public function addTemplateVariablesToTemplates($new_templates)
    {
        $default_variables = $this->db->get('defaults')->row_array();

        $data = [
            'template_id'        => '',
            'hotel_bg_color'     => $default_variables['hotel_bg_color'],
            'hotel_bg_image'     => $default_variables['hotel_bg_image'],
            'hotel_logo'         => $default_variables['hotel_logo'],
            'hotel_centr_color'  => $default_variables['hotel_center_color'],
            'hotel_btn_bg_color' => $default_variables['hotel_btn_bg_color'],
            'hotel_font_color1'  => $default_variables['hotel_header_font_color'],
            'hotel_font_color2'  => $default_variables['hotel_btn_font_color'],
            'hotel_font_color3'  => $default_variables['hotel_label_font_color'],
            'hotel_font_size1'   => $default_variables['hotel_header_font_size'],
            'hotel_font_size2'   => $default_variables['hotel_btn_font_size'],
            'hotel_font_size3'   => $default_variables['hotel_label_font_size']
        ];

        $i = 0;
        foreach($new_templates as $new_template) {
            $data['template_id'] = $new_template;

            $this->db->insert('templates_variables', $data);

            $i++;
        }
    }
}