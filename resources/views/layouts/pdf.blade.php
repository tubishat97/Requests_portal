<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>PDF</title>
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
</head>
<body>
    <div class="wrapper">
    	<div class="page-wrap">
	    	<div class="main-content">
	    		@yield('content')
	    	</div>
    	</div>
	</div>
</body>
</html>