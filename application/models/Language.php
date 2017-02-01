<?php


class Language extends CI_Model
{

    public function getAllLanguages()
    {
        $result = $this->db->select('*')
                            ->get('languages')
                            ->result_array();

        return $result;
    }

    public function getEnglishQuestions()
    {
        $translates_icons_id = $this->db->select('translate_id, icon_set_id')
                                        ->from('hotel_language')
                                        ->join('hotel_question', 'hotel_question.hotel_id = hotel_language.hotel_id', 'left')
                                        ->where('hotel_language.language_id', '1')
                                        ->get()
                                        ->result_array();

        $translate_id = [];
        foreach($translates_icons_id as $key => $value)
        {
            $translate_id[] = $value['translate_id'];
        }

        $questions = $this->db->select('text, question_id')
                                ->where_in('translate_id', $translate_id)
                                ->get('translate_question')
                                ->result_array();

        $question_icon = [];
        foreach($questions as $key => $value)
        {
            $question_icon[] = array('question' => $value, 'icon_set_id' => $translates_icons_id[$key]['icon_set_id']);
        }

        return $question_icon;
    }
}