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
<h1>This Is Edit View</h1>
</table>
<div>&nbsp;</div>
<div>&nbsp;</div>
<div>
    <form method="post" action="<?php echo  base_url('Welcome/updateData'); ?>">
        <table >
            <tr>
                <input type="hidden" name="hid" value="<?php echo $editData[0]['emp_id']; ?>">
                <td>Employee Name</td>
                <td><input type="text" name="empName" placeholder="Enter Employee Name" value="<?php echo $editData[0]['emp_name'] ?>"></td>
            </tr>
            <tr>
                <td>Employee DOB</td>
                <td><input type="text" name="empDob" placeholder="Enter Employee DOB" value="<?php echo date("d/m/Y", strtotime($editData[0]['emp_dob']));  ?>""></td>
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
