<?php


class Stats extends CI_Model
{

    public function getHotelsEmails()
    {
        $emails = $this->db->select('id')
                            ->get('hotels')
                            ->result_array();

        return $emails;
    }

    public function mainLoop($current_week = true)
    {
        //Result array
        $result = [];

        //Get all hotels ids and emails
        $hotel_ids_emails = $this->getHotelsEmails();

        if($current_week) {
            $startDate = date("Y-m-d 00:00:00", strtotime("-2 week"));
            $endDate   = date("Y-m-d 00:00:00", strtotime("-1 week"));

            $start_date = date("Y-m-d", strtotime("-2 week"));
            $end_date   = date("Y-m-d", strtotime("-1 week"));

//            $endDate   = date("Y-m-d 00:00:00", time());
        } else {
            $startDate = date("Y-m-d 00:00:00", strtotime("-3 week"));
            $endDate   = date("Y-m-d 00:00:00", strtotime("-2 week"));

            $start_date = date("Y-m-d", strtotime("-2 week"));
            $end_date   = date("Y-m-d", strtotime("-1 week"));
        }



        //Loop over all hotels ids
//        foreach ($hotel_ids_emails as $id_email)
//        {
//            $hotel_id    = $id_email['id'];
            //$hotel_email = $id_email['email'];

            //Total global stats
            $global_stats_tmp = $this->currentWeekStats(22, $startDate, $endDate);
//            $global_stats_tmp = $this->currentWeekStats($hotel_id, $startDate, $endDate);

            $result['total_logins']             += $global_stats_tmp['total_logins'];
            $result['total_answered_questions'] += $global_stats_tmp['total_answered_questions'];
            $result['total_mb_transfered']      += $global_stats_tmp['total_mb_transfered'];
            $result['total_users']              += $global_stats_tmp['total_users'];
            $result['total_unique_users']       += $global_stats_tmp['total_unique_users'];

            //Question stats for a week
            $questions_stats = $this->getQuestions(22, $startDate, $endDate);
//            $questions_stats = $this->getQuestions($hotel_id, $startDate, $endDate);

//        }

        $result['total_mb_transfered'] = $this->formatBytes($result['total_mb_transfered']);
        $result['start_date'] = $start_date;
        $result['end_date'] = $end_date;

        return [
            'global_stats' => $result,
            'questions_stats' => $questions_stats
        ];
    }

    public function currentWeekStats($hotel_id, $startDate, $endDate)
    {
        // Get hotel's routers IPs - nasname
        $nasnames = "SELECT id, nasname FROM nas WHERE hotel_id = '$hotel_id'";


        $totalLogins_query = "select radacctid
                              from radacct
                              right join (select nasname from nas where hotel_id = '$hotel_id') as nasnames on nasnames.nasname = radacct.nasipaddress
                              where acctstarttime >= '$startDate'
                              and acctstarttime <= '$endDate'";
        $totalLogins = $this->db->query($totalLogins_query)->num_rows();


        $totalAnsweredQuestions_query = "select id
                                          from stats
                                          where hotel_id = '$hotel_id'
                                          and created_at >= '$startDate'
                                          and created_at < '$endDate'";
        $totalAnsweredQuestions = $this->db->query($totalAnsweredQuestions_query)->num_rows();


        $totalTraffic_query = "select (sum(acctinputoctets)+sum(acctoutputoctets)) as total
                                from radacct
                                right join (select nasname from nas where hotel_id = '$hotel_id') as nasnames on nasnames.nasname = radacct.nasipaddress
                                where acctstarttime >= '$startDate'";
        $totalTraffic = $this->db->query($totalTraffic_query)->row_array()['total'];


        $totalUsers_query = "select radacctid
                              from radacct
                              right join (select nasname from nas where hotel_id = '$hotel_id') as nasnames on nasnames.nasname = radacct.nasipaddress
                              where acctstarttime >= '$startDate'
                              group by username";
        $totalUsers = $this->db->query($totalUsers_query)->num_rows();


        $totalUniqueUsers_query = "select count(*) as users_count
                                    from radacct
                                    right join (select nasname from nas where hotel_id = '$hotel_id') as nasnames on nasnames.nasname = radacct.nasipaddress
                                    where acctstarttime >= '$startDate'
                                    and acctstoptime < '$endDate'
                                    group by username
                                    having count(*) = 1";
        $totalUniqueUsers = $this->db->query($totalUniqueUsers_query)->num_rows();

        return [
            'total_logins' => $totalLogins,
            'total_answered_questions' => $totalAnsweredQuestions,
            'total_mb_transfered' => $totalTraffic,
            'total_users' => $totalUsers,
            'total_unique_users' => $totalUniqueUsers
        ];
    }

    public function getQuestionStats($question_id, $startDate, $endDate)
    {
        $total_answers_q = "select count(*) as total_answers, question_text
                            from stats
                            where question_id = '$question_id'
                            and created_at >= '$startDate'
                            and created_at < '$endDate'";

        $total_answers_q = $this->db->query($total_answers_q)->row_array();
        $total_answers = $total_answers_q['total_answers'];

        $question_text = $total_answers_q['question_text'];


        $positive_answers_q = "select count(*) as total_positive_answers
                                from stats
                                where question_id = '$question_id'
                                and answer = '1'
                                and created_at >= '$startDate'
                                and created_at < '$endDate'";
        $positive_answers = $this->db->query($positive_answers_q)->row_array()['total_positive_answers'];


        $neutral_answers_q = "select count(*) as total_neutral_answers
                                from stats
                                where question_id = '$question_id'
                                and answer = '0'
                                and created_at >= '$startDate'
                                and created_at < '$endDate'";
        $neutral_answers = $this->db->query($neutral_answers_q)->row_array()['total_neutral_answers'];


        $negative_answers_q = "select count(*) as total_negative_answers
                                from stats
                                where question_id = '$question_id'
                                and answer = '-1'
                                and created_at >= '$startDate'
                                and created_at < '$endDate'";
        $negative_answers = $this->db->query($negative_answers_q)->row_array()['total_negative_answers'];

        $icons_query = "select icon_1, icon_2, icon_3
                          from hotel_question
                          LEFT JOIN icon_sets ON hotel_question.icon_set_id = icon_sets.id
                          WHERE hotel_question.question_id = '$question_id'";
        $icons = $this->db->query($icons_query)->row_array();

        return [
            'question_text' => $question_text,
            'total_answers' => $total_answers,
            'likes' => $positive_answers,
            'neutral' => $neutral_answers,
            'dislike' => $negative_answers,
            'icons'   => $icons
        ];

    }

    public function getQuestions($hotel_id, $startDate, $endDate)
    {
        //Get all hotel questions
        $all_questions_query = "select question_id
                                  from stats
                                  where hotel_id = '$hotel_id'
                                  group by question_id";
        $all_questions = $this->db->query($all_questions_query)->result_array();

        $result = [];

        foreach($all_questions as $question_id)
        {
            $result[$question_id['question_id']] = $this->getQuestionStats($question_id['question_id'], $startDate, $endDate);
        }

        return $result;
    }

    function formatBytes($bytes)
    {
        return intval($bytes/1048576);
    }

    public function getStatsDifference()
    {
        $current_week = $this->mainLoop();

        $old_week     = $this->mainLoop(false);

        $diff_array = [];

        $diff_array['global_stats']['total_logins'] = $this->getDiff($old_week['global_stats']['total_logins'],
                                                                    $current_week['global_stats']['total_logins']);

        $diff_array['global_stats']['total_answered_questions'] = $this->getDiff($old_week['global_stats']['total_answered_questions'],
                                                                             $current_week['global_stats']['total_answered_questions']);

        $diff_array['global_stats']['total_mb_transfered'] = $this->getDiff($old_week['global_stats']['total_mb_transfered'],
                                                                        $current_week['global_stats']['total_mb_transfered']);

        $diff_array['global_stats']['total_users'] = $this->getDiff($old_week['global_stats']['total_users'],
                                                                $current_week['global_stats']['total_users']);

        $diff_array['global_stats']['total_unique_users'] = $this->getDiff($old_week['global_stats']['total_unique_users'],
                                                                       $current_week['global_stats']['total_unique_users']);

        $diff_array['questions_stats'] = [];
        foreach($current_week['questions_stats'] as $key => $value) {
            $diff_array['questions_stats'][$key]['total_answers'] = $this->getDiff($old_week['questions_stats'][$key]['total_answers'], $value['total_answers']);
            $diff_array['questions_stats'][$key]['likes'] = $this->getDiff($old_week['questions_stats'][$key]['likes'], $value['likes']);
            $diff_array['questions_stats'][$key]['neutral'] = $this->getDiff($old_week['questions_stats'][$key]['neutral'], $value['neutral']);
            $diff_array['questions_stats'][$key]['dislike'] = $this->getDiff($old_week['questions_stats'][$key]['dislike'], $value['dislike']);
        }

        return [
            'stats' => $current_week,
//            'previous_week_stats' => $old_week,
            'diff'   => $diff_array
        ];

    }

    public function getDiff($value_old, $value_new)
    {
        if($value_new == 0 && $value_old != 0) {
            return -100;
        }

        if($value_old == 0 && $value_new != 0) {
            return $value_new*100;
        }

        if($value_old == 0 && $value_new == 0) {
            return 0;
        }

        $percent = round( (($value_new - $value_old) * 100)/$value_old );

        return $percent;
    }
}