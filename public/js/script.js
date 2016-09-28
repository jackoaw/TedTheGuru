$(document).ready(function() {
	// c is the counter for how many times you pressed that button
	var str = $("#likes").text();
	var len = str.length - 6;
	var c = parseInt(str.substring(0,len));
	// When you click the like button...
	$(".Button").click(function() {
		c++;
		// Incremement the value displayed in the like status text
		$("#likes").text(c + " likes" );
	});

	// When the answer quiz button is pressed ...
	$( ".Button#answerQuiz" ).click(function() {
		// determine the correct answer (already set here) and ...
		var correct = $("#correctAnswer").text();
		var value = $('input:radio:checked').val();
		// Display correct! or incorrect! whether true or not
		if(value.substring(1,2) == correct)
		{
			$("#boolean").text("Correct!");
		}
		else
		{
			$("#boolean").text("Incorrect!");
		}
		// iterate through all of the radiobuttons disabling the incorrect ones.
		for (var i=1; i<5; i++) { //assume the max number of answer choices is 4
			if(i == correct)
			{
				continue;
			}
			else
			{
				jQuery('input[type=radio][value=c' + i + ']').attr('disabled', true);
			}
		};
		// Make everything visible and display correct answer
		$(".invisible").css("visibility", "visible");
		$("#correctAnswer").text("There are always more answers young cricket");
		$(".Button#answerQuiz").prop('disabled', true);
	});

	// When you try to submit your comment ...
	$("#submitComment").click(function(){
		// The text area above your text box will change in response, showing a preview of your response.
		var preview = $("textarea").val();
		$("textarea").val("");
		$("#comment").text(preview);
	});


	
	//error highlighting for the signup page
	$('#create-account input[type=text],#create-account input[type=password]').on('click', function(event) {
		var textInput = $(this);
		var parent = $(this).closest('li');
		
		//Make sure to toggle the error
		if(parent.find('span').length == 1 && textInput.hasClass("error-highlight")) {
			parent.find('span').remove();
			textInput.removeClass("error-highlight");
		}
		
		$('html').one('click', function() {
			if(parent.find('span').length == 0) { //make sure you only show error once per list element
				var inp = textInput.val();
				if($.trim(inp).length == 0) {
					var errorMessage = $('<span class="error-message">Field cannot be empty</span>');
					parent.append(errorMessage);
					textInput.addClass("error-highlight");
				}
			}
		});
	event.stopPropagation();
	});


});

