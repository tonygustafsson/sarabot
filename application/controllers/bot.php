<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bot extends CI_Controller {

	public function index()
	{
		header("Content-Type: text/html; charset=utf-8");

		if ($this->session->userdata('name') == "")
		{
			$this->session->set_userdata('ask_for_name', 'true');
		}

		$this->load->view('html_top');
		$this->load->view('startpage');
		$this->load->view('html_bottom');
	}

	public function speak()
	{
		if (strlen($this->input->post('input')) > 1)
		{
			date_default_timezone_set('Europe/Stockholm');
			$this->benchmark->mark('before_answer');

			$name = ($this->session->userdata('name') != "") ? $this->session->userdata('name') : 'Främling';

			$input = strtolower(strtr($this->input->post('input'), "ÅÄÖ", "åäö"));
			$answer = $this->brain->get_answer($input);
			$answer['answer'] = str_replace("#name#", $name, $answer['answer']);

			$this->benchmark->mark('after_answer');
			$benchmark = $this->benchmark->elapsed_time('before_answer', 'after_answer');

			$output = array('timestamp' => date("H:i:s"), 'said' => $this->input->post('input'), 'answer' => $answer['answer'], 'answer_id' => $answer['answer_id'], 'benchmark' => $benchmark);

			$this->_write_log($output);

			echo json_encode($output);
		}
	}

	private function _write_log($input)
	{
		$file = BASEPATH . '../assets/text/chat_logs/' . date("YmdH") . '_' . $this->session->userdata('session_id') . '.txt';

		$output = "<" . $input['timestamp'] . "> <User> " . $input['said'] . "\n<" . $input['timestamp'] . "> <Sarabot> " . $input['answer'] . " (" . $input['answer_id'] . ")\n";
		write_file($file, $output, 'a+');
	}

	public function about()
	{
		date_default_timezone_set('Europe/Stockholm');
		$this->load->view('html_top');
		$this->load->view('about');
		$this->load->view('html_bottom');
	}

}

/* End of file bot.php */
/* Location: ./application/controllers/bot.php */