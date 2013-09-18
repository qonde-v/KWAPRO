<?php
  class Question_sort extends CI_Model
  {
    function __construct()
    {
        parent::__construct();
    }
    
    //sort question data by view_num
    //input:array of question data
    //output:sorted array of question data
    function sort_by_view_num($data)
    {
        foreach($data as $key => $row)
        {
            $view_num[$key] = $row['question_view_num'];
        }
        array_multisort($view_num,SORT_DESC,$data);
        return $data;
    }
    
    //sort question data by time
    //input:array of question data
    //output:sorted array of question data
    function sort_by_time($data)
    {
        foreach($data as $key => $row)
        {
            $time[$key] = $row['time'];
        }
        array_multisort($time,SORT_DESC,$data);
        return $data;
    }
    
    //sort question data by score
    //input:array of question data
    //output:sorted array of question data
    function sort_by_score($data)
    {
        foreach($data as $key => $row)
        {
            $score[$key] = $row['question_score'];
        }
        array_multisort($score,SORT_DESC,$data);
        return $data;
    }
    
    //sort question data by answer number
    //input:array of question data
    //output:sorted array of question data
    function sort_by_answer_number($data)
    {
        foreach($data as $key => $row)
        {
            $answer_num[$key] = $row['question_answer_num'];
        }
        array_multisort($answer_num,SORT_DESC,$data);
        return $data;
    }
  }