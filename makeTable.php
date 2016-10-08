<!DOCTYPE html>
<html>
<head>
	<title>Display Table</title>
</head>
<body>
	<?php
	$clubid = $_COOKIE["clubid"];
	$json = file_get_contents("/getStudentList.php?clubid=". $clubid);
	$data = json_decode($json);
	?>
    <tr>
        <td><strong>First Name</strong></td>
        <td><strong>Last Name</strong></td>
        <td><strong>Email</strong></td>
        <td><strong>Grade</strong></td>
    </tr>
	<?php
	foreach($data as $object):
	?>
    	<tr>
        	<td><?php echo $object->{'firstname'}?></td>
            <td><?php echo $object->{'lastname'}?></td>
            <td><?php echo $object->{'email'}?></td>
            <td><?php echo $object->{'grade'}?></td>
        </tr>
	<?php endforeach; ?>
</body>
</html>