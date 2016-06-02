<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

			$answer = $this->brain->get_answer($this->input->post('input'));

			$this->benchmark->mark('after_answer');
			$benchmark = $this->benchmark->elapsed_time('before_answer', 'after_answer');

			$output = array(
				'timestamp' => date("H:i:s"),
				'said' => $this->input->post('input'),
				'answer' => $answer['answer'],
				'answer_id' => $answer['answer_id'],
				'benchmark' => $benchmark);

			$this->_write_log($output);

			echo json_encode($output);
		}
	}

	private function _write_log($input)
	{
		$file = BASEPATH . '../assets/text/chat_logs/' . date("YmdH") . '_' . session_id() . '.txt';

		$output = "<" . $input['timestamp'] . "> <User> " . $input['said'] . "\n<" . $input['timestamp'] . "> <Sarabot> " . $input['answer'] . " (" . $input['answer_id'] . ")\n";
		write_file($file, $output, 'a+');
	}

	public function forget()
	{
		$this->session->sess_destroy();
		redirect('/', 'refresh');
	}
}

/* End of file bot.php */
/* Location: ./application/controllers/bot.php */