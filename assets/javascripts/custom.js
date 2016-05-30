var inputHistory = new Array();
var historyIndex = 0;
var answerID = 0;

$(document).ready(function() {
	$("input[type='text']:first", document.forms[0]).focus();
});

$(document).on('submit', '#dialog_form', function() {
	if ($("input#input_field").val().length > 1) {
		$('.bot-img').addClass('thinking');
		
		$.ajax({
			type: "POST",
			url: $(this).attr('action'),
			dataType: "json",
			data: $(this).serialize(),
			beforeSend: function() {
				$("input#input_field").attr('disabled', true);
				$("input#input_field").val("*tänker*");
			},
			complete: function() {
				$("input#input_field").val("");
				$("input#input_field").attr('disabled', false);
				$("input#input_field").focus();
				
				$('.bot-img').removeClass('thinking');
			},
			success: function(answer) {
				$("<p id='" + answerID + "'><span class='greyed'>&#60;" + answer['timestamp'] + "&#62; Du: " + answer['said'] + "</span><br>&#60;" + answer['timestamp'] + "&#62; Sarabot: " + answer['answer'] + "</p>").hide().prependTo("div#dialog").fadeIn();
				$("span#debug").html("ID: " + answer['answer_id'] + " &nbsp;&nbsp;&nbsp; " + "Execution time: " + answer['benchmark'] + "s &nbsp;&nbsp;&nbsp;&nbsp; ");

				inputHistory[inputHistory.length] = answer['said'];
				$("input#input_field").val("");

				historyIndex = inputHistory.length;
				answerID++;
			},
			error: function() {
				$("div#dialog").prepend("<p><span style='color: red;'>Boten lyssnade inte på tilltal, försök igen...</span></p>");
			}
		});
	}

	return false;
});

$(document).on('click', 'input#clean', function() {
	$("div#dialog").html("");
	$("input#input_field").val("");
	$("input#input_field").focus();
});

$(document).on('keyup', 'input#input_field', function(e) {
	if (e.keyCode == 38) {
		historyIndex--;
		historyIndex = (historyIndex < 1) ? 0 : historyIndex;
		$('input#input_field').val(inputHistory[historyIndex]);
	}
	else if (e.keyCode == 40) {
		historyIndex++;
		$('input#input_field').val(inputHistory[historyIndex]);
	}
});