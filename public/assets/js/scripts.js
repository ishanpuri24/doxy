$(document).ready(function() {
	$(".ialert").fadeTo(5000, 500).slideUp(500, function() {
	    $(".ialert").slideUp(500);
	});

	$('[data-toggle="tooltip"]').tooltip();

	$(".search-document").keyup(function() {
		$("ul.document-types li").addClass("d-none");

		if ($(this).val().trim() == '')
		{
			$("ul.document-types li").removeClass("d-none");
		}
		else
		{
			$("ul.document-types li[data-name*='" + $(this).val().toLowerCase() + "']").removeClass("d-none");
		}
	});

	$(".questions-wrap button[data-role='next']").click(function() {
		let doxyStorage = JSON.parse(localStorage.getItem('doxy'));
		let inputs = $(this).closest("div[data-step]").find("input[type='text'], input[type='date'], textarea");
			inputs.each(function(index, input) {
				doxyStorage[$(input).attr("data-src")] = $(input).val();
			});

		localStorage.setItem("doxy", JSON.stringify(doxyStorage));
	});

	$('span[data-role="fillable"]').each(function(index) {
		renderBlanks($(this).data("length") && $(this).data("length") !="" ? $(this).data("length") : 25, $(this));
	});
	
	$(".update-preview").click(function() {
		let doxyStorage = JSON.parse(localStorage.getItem('doxy'));
		for(var storeageKey in doxyStorage) {
			if (doxyStorage[storeageKey] != "")
			{
				$('.document-preview span[data-role="fillable"][data-dest="' + storeageKey + '"]').html(doxyStorage[storeageKey]);
				$('.document-preview span[data-role="fillable"][data-dest="' + storeageKey + '"]').removeClass("rl-blank");
			}
			else
			{
				renderBlanks($('.document-preview span[data-role="fillable"][data-dest="' + storeageKey + '"]').attr("data-length"), $('.document-preview span[data-role="fillable"][data-dest="' + storeageKey + '"]'));
			}
		}
	});
});

function renderBlanks(contentLength, ele)
{
	let html = '';
	for (var i = 1; i <= contentLength; i++)
	{
		html += "_";
	}

	ele.html(html);
	ele.addClass("blank");
}