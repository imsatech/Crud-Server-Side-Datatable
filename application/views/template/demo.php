<?php
/**
 * Created by PhpStorm.
 * User: Apple
 * Date: 18/09/17
 * Time: 12:00 PM
 */

?>

<html>
<head>
    <title> this is demo file</title>
</head>
<body>
<h1>This Is Demo View</h1>
<h1> sorathiadaksh@gmail.com 9558181686 </h1>
<h1> lochawalapratik5@gmail.com 8460780308 </h1>
<table border="1">
    <thead>
        <th>Name</th>
        <th>DOB</th>
        <th>Action</th>
    </thead>
    <tbody>
    <?php $cnt=0; foreach ($employee as $dt): ?>
        <tr>
            <td><?php echo $dt['emp_name']; ?></td>
            <td><?php echo $dt['emp_dob']; ?></td>
            <td> <a href="<?php echo base_url('Welcome/deleteData?did='.$dt['emp_id']); ?>"><input type="button" value="Delete"></a> | <a href="<?php echo base_url('Welcome/getSelectedData/'.$dt['emp_id']); ?>"><input type="button" value="Edit"></a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div>&nbsp;</div>
<div>&nbsp;</div>
<div>
    <form method="post" action="<?php echo  base_url('Welcome/insertData'); ?>">
        <table >
            <tr>
                <td>Employee Name</td>
                <td><input type="text" name="empName" placeholder="Enter Employee Name"></td>
            </tr>
            <tr>
                <td>Employee DOB</td>
                <td><input type="date" name="empDob" placeholder="Enter Employee DOB"></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit" value="Submit"></td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>
