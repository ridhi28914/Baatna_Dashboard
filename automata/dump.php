<?php 

error_reporting(E_ALL);
ini_set('display_errors',1);


exec('mysqldump -u root -p{password} BaatnaServer > my_database_dump.sql ');


require "s3.php";

$s3=new S3('{id}','{secret key}');
$newname=time() . '.sql';
S3::putObject(
	$s3->inputFile('my_database_dump.sql',false),
	'{bucketname}',
	$newname,
	S3::ACL_PUBLIC_READ,
	array(),
	array(),
	S3::STORAGE_CLASS_RRS

 );
?>
