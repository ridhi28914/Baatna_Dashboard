<?php
require_once('query.php');
$q = new Query();
if($_POST['name']==null || $_POST['password']==null)
{
	echo "name/password required";
	header('Location:login.html');
}
else
{
	$email=explode('@',$_POST['name']);
	$company=explode('.',$email[1]);
	if($company[0]=='baatna')
	{
		$sql="select PASSW from Dashboard where EMAIL='".$_POST['name']."'";
		$val=$q->getallentires($sql);
		if(empty($val))
		{
			echo "no such email";
			header('Location:login.html');
			
		}

		foreach($val as $value)
		{
			if($value['PASSW']==$_POST['password'])
			{
				header('Location:nav.html');
			}	
			else
			{
				header('Location:login.html');
				echo "password not correct";
			}
		}
	}
	else
	{
		echo "@baatna missing";
		header('Location:login.html');
	}
}

?>
