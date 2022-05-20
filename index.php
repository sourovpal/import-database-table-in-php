<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		*
		{
			margin:0;
			padding:0;
			box-sizing:border-box;
		}
		body
		{
			display:flex;
			justify-content:center;
			align-items:center;
			height:100vh;
		}
		#main
		{
			width:400px;
			height:300px;
			border-radius:5px;
			box-shadow:3px 3px 5px rgba(0,0,0,0.25);
			padding:20px 25px;
		}
		label
		{
			margin-bottom:8px;
			font-size:16px;
			font-weight:bold;
			display:block;
		}
		input
		{
			width:100%;
			padding:10px 12px;
			border-radius:4px;
			border:1px solid #ddd;
			outline:none;
		}
		.btn
		{
			width:100%;
			padding:12px 0;
			border:1px solid #ddd;
			background:orange;
			outline:none;
			margin-top:8px;
			border-radius:5px;
			font-size:16px;
			color:#fff;
			cursor:pointer;
		}
	</style>
</head>
<body>

<?php 

$message = '';
if(isset($_POST['import']))
{
	if($_FILES['input']['name'] != '')
	{
		$ext = '.'.pathinfo($_FILES['input']['name'], 
			PATHINFO_EXTENSION);
		if($ext == '.sql')
		{
			$connect = mysqli_connect('localhost', 'root', '', 'test');
			$output = '';
			$count = -1;
			$file_data = file($_FILES['input']['tmp_name']);
			foreach ($file_data as $key => $row)
			{
				$start_character = substr(trim($row), 0, 2);
					print_r($start_character);
				if($start_character != '--' || $start_character != '/*' || $start_character != '//' || $row != '')
				{
					$output = $output . $row;
					$end_character = substr(trim($row), -1, 1);
					if($end_character == ';')
					{
						if(mysqli_query($connect, $output))
						{
							$message = 'impurt successfully !';
						}
						else
						{
							$message = 'This is not import database table';
						}
						$output = '';
					}
				}
			}
		}
		else
		{
			$message = 'This file invalid !';
		}
	}
	else
	{
		$message = 'Please Input File !';
	}
}



 ?>


<div id="main">
	<form method="post" enctype="multipart/form-data">
		<p><?php echo $message; ?></p>
		<label for="sql">Sql :</label>
		<input  id="sql" type="file" name="input" placeholder="Select Sql">
		<button class="btn" name="import">Submit</button>
	</form>
</div>



</body>
</html>