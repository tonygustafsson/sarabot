<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class File
{
	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function read($file, $first_var = "")
	{
		$text_file = BASEPATH . '../assets/text/answers/' . $file . '.txt';

		if (file_exists($text_file))
		{
			// Get file contents
			$handle = fopen($text_file, "r");
			$contents = fread($handle, filesize($text_file));
			fclose($handle);
			
			// Get a random answer
			$contents = explode("\n", $contents);
			$row = $contents[rand(0, count($contents) - 1)];
			
			// Replace variables
			$name = ($this->CI->session->userdata('name') != "") ? $this->CI->session->userdata('name') : 'Främling';
			$row = str_replace("{name}", $name, $row);
			$row = str_replace("{0}", $first_var, $row);

			$output = array('answer' => $row, 'answer_id' => $file);
			return $output;
		}
		else
		{
			$output = array('answer' => "Error: Could not find file!", 'file' => "Error!");
			return $output;
		}
	}
}

/* End of file File.php */