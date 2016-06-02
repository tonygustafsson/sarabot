<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Namememory
{
	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function parse($words)
	{
		$position = 0;

		$ignored_words = array('jag', 'heter', 'mitt', 'namn', 'är', 'namnet', 'hej');

		foreach ($words as $key => $word)
		{
			if (in_array($word, $ignored_words))
			{
				unset($words[$key]);
			}
		}

		if (count($words) < 1)
		{
			return "Främling";
		}

		$name = array_values($words)[0];

		return $name;
	}

	public function remember($input)
	{
		if ($this->CI->session->userdata('ask_for_name') == 'true')
		{
			$name = ucfirst(strtolower($input));
		}
		else
		{
			preg_match_all('/[\wåäöÅÄÖ]+/', $input, $array);
			$name = ucfirst(strtolower($array[0][2]));
		}

		$this->CI->session->set_userdata('name', $name);
		$this->CI->session->set_userdata('ask_for_name', 'false');

		$answer = $this->CI->brain->read_file("remember_name", $name);
        $output = array('answer' => $answer['answer'], 'answer_id' => 'Remember name');

		return $output;
	}

	public function retrieve()
	{
		$output = $this->CI->brain->read_file("vad_heter_jag", $this->CI->session->userdata('name'));
		return $output;
	}
}

/* End of file Namememory.php */