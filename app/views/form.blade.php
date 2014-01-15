<!DOCTYPE html>
<html lang='ja'>
<head>
	<title>URL Shortener</title>
	<link rel="stylesheet" type="text/css" href="/assets/css/styles.css">
</head>
<body>
	<div id="container">
		<h2>Uber-Shortener</h2>
		{{Form::open(array('url' => '/', 'method' => 'post'))}}

		{{Form::text('link', Input::old('link'),
		  array('placeholder' => 'Insert URL here and press Enter!'))}}

		{{Form::close()}}
	</div>

</body>
</html>