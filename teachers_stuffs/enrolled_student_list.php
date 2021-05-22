<script src="../js/jquery.min.js"></script>
<?php if (!isset($student_list)): ?>
    <form action="." method="post" id="aligned">
        <input type="hidden" name="action" value="student_list">  
        <p>Instructor ID: <?php echo $_POST['instructorId']; ?></p>
        <p>Instructor Name: <?php echo $_POST['instructorName']; ?></p>
        <h4>Enrolled Students' List With <?php echo $_POST['courseName']; ?>  Course</h4><hr>
        <input type="hidden" name='courseId' value='<?php echo $_POST['courseId']; ?>' >
        <input type="hidden" name='instructorId' value='<?php echo $_POST['instructorId']; ?>' >
        <input type="submit" value="Show Student Enrolled With This Course" /><br>
    </form>
<?php endif; ?>
<?php if (isset($student_list)): ?>
    <?php include '../view/header.php'; ?>
    <form action="." method="post" id="aligned">
        <input type="hidden" name="action" value="student_letter_grade"> 
        <table>
            <tr>
                <th>Full Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Grage</th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach ($student_list as $list) : ?>
                <input type="hidden" name="reg_id" value="<?php echo htmlspecialchars($list['reg_id']); ?>"> 
                <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($list['course_id']); ?>"> 
                <tr>
                    <td><?php echo htmlspecialchars($list['name']); ?></td>
                    <td><?php echo htmlspecialchars($list['gender']); ?></td>
                    <td><?php echo htmlspecialchars($list['email']); ?></td>
                    <td>
                        <select name="grade">
                            <option value="1">A</option>
                            <option value="2">B</option>
                            <option value="3">C</option>
                            <option value="4">D</option>
                            <option value="5">F</option>
                        </select>
                    </td>
                    <td>
                        <input type="submit" value="Save" id="gradeButtion" /><br>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </form>
    <?php include '../view/footer.php'; ?>
<?php endif; ?>