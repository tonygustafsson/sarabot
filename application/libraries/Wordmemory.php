<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wordmemory
{
	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function retrieve()
	{
		$remembered_words = $this->CI->session->userdata('unusual_words');

		$answer = "";

		if (count($remembered_words) > 0)
		{
			$answer .= "Du gillar att prata om ";

			for ($x = 0; $x < count($remembered_words); $x++)
			{
				$answer .= $remembered_words[$x];
				if ($x == count($remembered_words) - 2)
				{
					$answer .= " och ";
				}
				else if ($x < count($remembered_words) - 1)
				{
					$answer .= ", ";
				}
				else
				{
					$answer .= ".";
				}
			}
		}

		return array('answer' => $answer, 'answer_id' => 'Get knowledge');
	}

	public function mention_memory()
	{
		$word = "kebab";
		$remembered_words = $this->CI->session->userdata('unusual_words');

		if (count($remembered_words) > 0)
		{
			shuffle($remembered_words);
			$word = array_slice($remembered_words, 0, 1);
			$word = $word[0];
		}

		$answer = $this->CI->file->read("du_namnde", $word);

		return array('answer' => $answer['answer'], 'answer_id' => 'Talked about');
	}

	public function remember_words($words)
	{
		$text_file = BASEPATH . '../assets/text/lists/usual_words.txt';

		$handle = fopen($text_file, "r");
		$contents = fread($handle, filesize($text_file));
		fclose($handle);

		$usual_words = explode("\r\n", $contents);
		$words = preg_replace("/[^A-Za-z0-9\-åäöÅÄÖ ]/", "", $words);
		$words = strtolower($words);
		$word_array = explode(" ", $words);

		$remembered_words = array();

		if ($this->CI->session->userdata('unusual_words') !== NULL)
		{
			$remembered_words = $this->CI->session->userdata('unusual_words');
		}

		foreach ($word_array as $word)
		{
			if (!in_array($word, $remembered_words) && !in_array($word, $usual_words))
			{
				$remembered_words[] = $word;
			}
		}

		$this->CI->session->set_userdata('unusual_words', $remembered_words);
	}

}

/* End of file Wordmemory.php */