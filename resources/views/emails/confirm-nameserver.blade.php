<!DOCTYPE html>
	<html>
	<head>
	</head>
	<body style="background-color: #efefef; font-family: Arial;">
		<h1>New nameserver submission</h1>
		<a href="{{ action('NameserverController@confirmNameserver', ['code' => $confirmationCode]) }}">
			Confirm
		</a>
		<a href="{{ action('NameserverController@deleteNameserver', ['code' => $confirmationCode]) }}">
			Delete
		</a>
	</body>
</html>