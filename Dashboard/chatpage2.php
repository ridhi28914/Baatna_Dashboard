<?php
/*
session_start();
if(!isset($_session['baatna']))
{
  header('Location:login.html');
}
*/
?>
<head><link rel="stylesheet" type="text/css" href="table.css">
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"> </script>
<script src="sorttable.js" > </script>

<html>
<body>
<table class="sortable table" border="2px" id="t">
<thead>
    <tr class=" row header blue">
       <th width="150" class="cell">MESSAGES</th>
      <th width="150" class="cell">TIMESTAMP</th>
      <th width="150" class="cell">FROM</th>
      <th width="150" class="cell">TO</th>
    </tr>
</thead>
<tbody>
 <?php

     
      require_once("query.php");
      $WISHID=$_GET['wishid'];
      $USERID=$_GET['userid'];
      $q = new Query();
      $sql="SELECT USER_TWO_ID from USERWISH where USERWISH.WISHID=". $WISHID ;         
      $val=$q->getallentires($sql);


       //Constant User's username
      $sql="select FACEBOOKDATA from USER where USERID=$USERID";
      $val2=$q->getallentires($sql);
      foreach ($val2 as $name) 
      {
            // $USERNAME=$name['USER_NAME'];
        $obj=json_decode($name['FACEBOOKDATA']);

     	$USERNAME= $obj->name;

        

      }
      //End
                

      foreach ($val as $value) 
      {
            $u1=$USERID;
            $u2=$value['USER_TWO_ID']; 

            //Constant User_TWO_id's username
            $sql="select FACEBOOKDATA,USER_NAME from USER where USERID=$u2";
            $val3=$q->getallentires($sql);
            foreach ($val3 as $name) 
            {
        //           $u2username=$name['USER_NAME'];
		
        $obj=json_decode($name['FACEBOOKDATA']);

      $u2username=$obj->name;

            }
            //End
?>
<tr class="row">
            <td colspan="4" style="text-align:center;">Chat between <?php echo  $USERNAME ?> and <?php echo $u2username ?></td>    
          </tr>  
<?php        
$sql3="SELECT MESSAGE , TIME_OF_MESSAGE,FROMUSERID,TOUSERID from MESSAGE where WISHID=". $WISHID ." and (( FROMUSERID=".$u1 ." and TOUSERID=".$u2. ") or ( FROMUSERID=".$u2 ." and TOUSERID=".$u1. ")) order by TIME_OF_MESSAGE" ;
            $val4=$q->getallentires($sql3);
         
   foreach ($val4 as $value3)
             {
           ?>
          
              <tr class="row">
               <td class="cell"><?php echo ($value3['MESSAGE']); ?> </td>
               <td class="cell">

<?php 
 $timestamp = (int) ($value['TIME_OF_MESSAGE'] / 1000);
    // MySQL takes year-month-day hour:minute:second format
    $mysql_datetime = date('Y-m-d H:i:s', $timestamp);
    echo $mysql_datetime;
 ?>

 </td>

               <td class="cell"><?php if($USERID==$value3['FROMUSERID'])echo  $USERNAME; else echo $u2username;?>
               </td>
               <td class="cell"><?php if($USERID==$value3['TOUSERID'])echo  $USERNAME; else echo $u2username;?>
               </td>
              </tr>
            <?php
           
          }
          ?>
          <?php
      }


         ?>

  
</tbody>
</body>
</html>
