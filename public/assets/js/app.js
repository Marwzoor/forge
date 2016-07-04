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

		request.upload.onprogress = function (event) {
			var percentComplete = Math.round((event.loaded / event.total) * 100);
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

	$(".nameserver-search-form").submit(function (e) {
		e.preventDefault();

		$(".nameserver-result").slideUp(200);

		$.post($(this).attr("action"), $(this).serialize())
			.done(function (data) {
				$("#result").html('<div class="alert alert-success">' + data.message + '</div>');
				$(".nameserver-result .nameserver-domain").text(data.domain);
				$(".nameserver-result .nameserver-company-name").text(data.companyName);
				$(".nameserver-result .nameserver-company-url").attr("href", data.companyUrl).text(data.companyUrl);
				$(".nameserver-result").slideDown(200);
			})
			.fail(function (data) {
				data = JSON.parse(data.responseText);

				$("#result").html('<div class="alert alert-danger">' + data.message + '</div>');
			});
	});

	$(".nameserver-submit-form").submit(function (e) {
		e.preventDefault();

		$.post($(this).attr("action"), $(this).serialize())
			.done(function (data) {
				$("#result").html('<div class="alert alert-success">' + data.message + '</div>');
			})
			.fail(function (data) {
				data = JSON.parse(data.responseText);

				$("#result").html('<div class="alert alert-danger">' + data.message + '</div>');
			});
	});
});