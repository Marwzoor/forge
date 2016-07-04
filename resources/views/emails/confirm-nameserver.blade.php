<!DOCTYPE html>
	<html>
	<head>
	</head>
	<body style="background-color: #efefef; font-family: Arial; padding: 40px 0;">
		<table style="max-width: 600px; margin: 0 auto; width: 95%; background-color: #fff; padding: 20px;">
			<tr>
				<td>
					<h1>New nameserver submission</h1>
				</td>
			</tr>
			<tr>
				<td>
					<table>
						<tr>
							<td><strong>Hostname:</strong></td>
							<td>{{ $nameserver->hostname }}</td>
						</tr>
						<tr>
							<td><strong>Company name:</strong></td>
							<td>{{ $nameserver->company_name }}</td>
						</tr>
						<tr>
							<td><strong>Company url:</strong></td>
							<td>{{ $nameserver->company_url }}</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td style="text-align: center;">
					<table>
						<tr>
							<td>
								<a style="border-radius: 7px; color: #fff; background-color: #3498db; padding: 10px 20px; display: inline-block; margin-right: 20px;" href="{{ action('NameserverController@confirmNameserver', ['code' => $confirmationCode]) }}">
									Confirm
								</a>
							</td>
							<td>
								<a style="border-radius: 7px; color: #fff; background-color: #3498db; padding: 10px 20px; display: inline-block;" href="{{ action('NameserverController@deleteNameserver', ['code' => $confirmationCode]) }}">
									Delete
								</a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>