var inputHistory = [],
	historyIndex = 0,
	answerID = 0;

$(document).ready(function() {
	$("input[type='text']:first", document.forms[0]).focus();
});

$('.dialog-form').on('submit', function() {
	if ($(".input-field").val().length > 1) {
		$.ajax({
			type: "POST",
			url: $(this).attr('action'),
			dataType: "json",
			data: $(this).serialize(),
			beforeSend: function() {
				$(".input-field").attr('disabled', true);
				$('.bot-img').addClass('thinking');
				$(".input-field").val("*tänker*");
			},
			complete: function() {
				$(".input-field").val("");
				$(".input-field").attr('disabled', false);
				$(".input-field").focus();
				$('.bot-img').removeClass('thinking');
			},
			success: function(answer) {
				$("<p id='" + answerID + "'><span class='greyed'>&#60;" + answer.timestamp + "&#62; Du: " + answer.said + "</span><br>&#60;" + answer.timestamp + "&#62; Sarabot: " + answer.answer + "</p>").hide().prependTo(".dialog").fadeIn();
				$("span#debug").html("ID: " + answer.answer_id + " &nbsp;&nbsp;&nbsp; " + "Execution time: " + answer.benchmark + "s &nbsp;&nbsp;&nbsp;&nbsp; ");

				inputHistory[inputHistory.length] = answer.said;
				$(".input-field").val("");

				historyIndex = inputHistory.length;
				answerID++;
			},
			error: function() {
				$(".dialog").prepend("<p><span style='color: red;'>Boten lyssnade inte på tilltal, försök igen...</span></p>");
			}
		});
	}

	return false;
});

$('.btn-clear').on('click', function() {
	$(".dialog").html("");
	$(".input-field").val("");
	$(".input-field").focus();
});

$('.input-field').on('keyup', function(e) {
	if (e.keyCode === 38) {
		historyIndex--;
		historyIndex = (historyIndex < 1) ? 0 : historyIndex;
		$('.input-field').val(inputHistory[historyIndex]);
	}
	else if (e.keyCode === 40) {
		historyIndex++;
		$('.input-field').val(inputHistory[historyIndex]);
	}
});