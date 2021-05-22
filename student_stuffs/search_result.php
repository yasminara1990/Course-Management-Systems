<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
session_start();
if (!isset($_SESSION['course_list'])) { // If session is not set then redirect to Login Page
    header("Location:Login.php");
}
echo "Login Success";

echo "<a href='logout.php'> Logout</a> ";
?>
<form action="." method="post">
    <input type="hidden" name="action" value="search_course">
    <input type="text" placeholder="Search.." name="search">
    <button type="submit" id="srchBtn" ><i class="fa fa-search"></i></button>
</form>
<div style="margin-left: 50px;">
    <table>
        <tr>
            <th>Course Name</th>
            <th>Semester</th>
            <th>Instructor</th>
            <th>Class Room#</th>
            <th>Time</th>
            <th>&nbsp;</th>
        </tr>
        <?php foreach ($_SESSION['course_list'] as $list) : ?>
            <input type="hidden" name="instructor_reg_id" value="<?php echo htmlspecialchars($list['reg_id']); ?>"> 
            <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($list['course_id']); ?>"> 
            <input type="hidden" name="semester_id" value="<?php echo htmlspecialchars($list['semester_id']); ?>"> 
            <input type="hidden" name="class_room_id" value="<?php echo htmlspecialchars($list['class_room_id']); ?>"> 
            <tr>
                <td><?php echo htmlspecialchars($list['course_name']); ?></td>
                <td><?php echo htmlspecialchars($list['semester_name']); ?></td>
                <td><?php echo htmlspecialchars($list['name']); ?></td>
                <td><?php echo htmlspecialchars($list['class_room_id']); ?></td>
                <td><?php echo htmlspecialchars($list['time']); ?></td>

                <td>
                    <input type="button" value="Enroll" id="gradeButtion" /><br>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>