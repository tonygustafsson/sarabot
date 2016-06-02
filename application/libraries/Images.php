<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Images
{
	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function send()
	{
        $motives = array("computer", "tree", "waterfall", "boy", "girl", "fire", "love", "dog");
        $motive = $motives[rand(0, count($motives) - 1)];
        
		$answer = $this->CI->file->read("bild_" . $motive);
		$answer = $answer['answer'] . '<br><img src="http://loremflickr.com/200/200/' . $motive . '" height="200" width="200">';
		$output = array('answer' => $answer, 'answer_id' => 'Image: ' . $motive);
        
		return $output;
	}
}

/* End of file Images.php */