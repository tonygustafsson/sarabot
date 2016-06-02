<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wikipedia
{
	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function read($word)
	{
		$url = "https://sv.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro=&explaintext=&exchars=200&titles=" . $word;

		$json = file_get_contents($url);
		$obj = json_decode($json);
		$article = (Array)$obj->query->pages;

		if (count($article) == 0)
			return $this->read_file("default_answer");

		$article = reset($article);

		if (!isset($article->extract))
			return $this->read_file("default_answer");

		$extract = $article->extract;

		if (empty(str_replace(".", "", $extract)))
			return $this->read_file("default_answer");

		$output = array('answer' => $extract, 'answer_id' => 'Wikipedia: ' . $word);

		return $output;
	}

	public function read_random()
	{
		$url = "https://sv.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&generator=random&exchars=200";

		$json = file_get_contents($url);
		$obj = json_decode($json);
		$article = (Array)$obj->query->pages;
		$extract = reset($article)->extract;
		$extract = strip_tags($extract);

		$output = array('answer' => $extract, 'answer_id' => 'Wikipedia: RANDOM');
		return $output;
	}
}

/* End of file Wikipedia.php */