(function () {
	var inputHistory = [],
		historyIndex = 0,
		answerID = 0,
		randomDelay = 0;

	function speakBeforeSend() {
		$(".input-field").attr('disabled', true);
		$('.bot-img').addClass('thinking');
		$(".input-field").val("*tänker*");
	}

	function speakComplete() {
		setTimeout(function () {
			$(".input-field").val("");
			$(".input-field").attr('disabled', false);
			$(".input-field").focus();
			$('.bot-img').removeClass('thinking');
		}, randomDelay);
	}

	function speakSuccess(answer) {
		setTimeout(function () {
			$("<p id='" + answerID + "'><span class='greyed'>&#60;" + answer.timestamp + "&#62; Du: " + answer.said + "</span><br>&#60;" + answer.timestamp + "&#62; Sarabot: " + answer.answer + "</p>").hide().prependTo(".dialog").fadeIn();
			$("span#debug").html("ID: " + answer.answer_id + " &nbsp;&nbsp;&nbsp; " + "Execution time: " + answer.benchmark + "s &nbsp;&nbsp;&nbsp;&nbsp; ");

			inputHistory[inputHistory.length] = answer.said;
			$(".input-field").val("");

			historyIndex = inputHistory.length;
			answerID++;
		}, randomDelay);
	}

	function speakError() {
		$(".dialog").prepend("<p><span style='color: red;'>Boten lyssnade inte på tilltal, försök igen...</span></p>");
	}

	function speak() {
		if ($(".input-field").val().length < 2) {
			return false;
		}

		randomDelay = Math.floor((Math.random() * 1500));

		$.ajax({
			type: "POST",
			url: $(this).attr('action'),
			dataType: "json",
			data: $(this).serialize(),
			beforeSend: speakBeforeSend,
			complete: speakComplete,
			success: speakSuccess,
			error: speakError
		});

		return false;
	}

	function getHistory(e) {
		if (e.keyCode === 38) {
			historyIndex--;
			historyIndex = (historyIndex < 1) ? 0 : historyIndex;
			$('.input-field').val(inputHistory[historyIndex]);
		}
		else if (e.keyCode === 40) {
			historyIndex++;
			$('.input-field').val(inputHistory[historyIndex]);
		}
	}

	$('.dialog-form').on('submit', speak);

	$('.btn-clear').on('click', function() {
		var url = $(this).data('url');
		window.location.href = url;
	});

	$('.input-field').on('keyup', getHistory);

	$("input[type='text']:first", document.forms[0]).focus();
})();