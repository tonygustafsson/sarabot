<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calc
{
	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function get($input)
	{
		preg_match_all('/[0-9\+\-\*\/]+/', $input, $array);

		switch ($array[0][1])
		{
			case "+":
				$result = $array[0][0] + $array[0][2];
				break;
			case "-":
				$result = $array[0][0] - $array[0][2];
				break;
			case "*":
				$result = $array[0][0] * $array[0][2];
				break;
			case "/":
				$result = $array[0][0] / $array[0][2];
				break;
			default:
				$result = "Jag kan inte räkna så bra... :(";
		}

		return array('answer' => $result, 'answer_id' => 'Calculator');
	}
}

/* End of file Calc.php */