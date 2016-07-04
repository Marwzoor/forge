jQuery(document).ready(function ($) {
	$(".image-compress-form").submit(function (e) {
		e.preventDefault();

		var $form = $(this);

		var url = $form.attr("action");

		var formData = new FormData(this);

		var request = new XMLHttpRequest();
		request.open("POST", url, true);

		$form.find(".progress").show();
		$form.find(".progress .progress-bar").css("width", "0%");
		$form.find(".progress .progress-percentage").text("0%");

		request.onprogress = function (event) {
			var percentComplete = (event.loaded / event.total) * 100;
			$form.find(".progress .progress-bar").css("width", percentComplete + "%");
			$form.find(".progress .progress-percentage").text(percentComplete + "%");
		};

		request.onreadystatechange = function() {
			if(request.readyState == 4) {
				if(request.status == 200) {
					var data = JSON.parse(request.response);

					window.location.assign(data.downloadUrl);

					setTimeout(function() {
						$form.find(".progress").hide();
						$form.find(".progress .progress-bar").css("width", "0%");
						$form.find(".progress .progress-percentage").text("0%");
					}, 1000);
				}
			}
		};

		request.send(formData);

		// $.ajax({
		// 	type: "POST",
		// 	contentType: false,
		// 	data: formData,
		// 	url: url,
		// 	processData: false,
		// 	success: function (data) {
		// 		window.location.assign(data.downloadUrl);
		// 	}
		// });
	});
});