<?php include '../view/header.php'; ?>
<script src="../js/jquery.min.js"></script>
<?php
if (!isset($_SESSION['use']) && !isset($_SESSION['pass'])) { // If session is not set then redirect to Login Page
    header("Location:Login.php");
}
echo "Login Success";

echo "<a href='logout.php'> Logout</a> ";
?>
<main>
        <input type="hidden" name="reg_id" value="<?php echo $_SESSION['reg_id']; ?>">

        <p><a href="#" class='course_list'>View All Available Course</a></p>
        <p><a href="#" class='profile'>View Profile</a></p>
        <p><a href="#" class='password_change'>Change Password</a></p>

    <div id='course_list_div' style="display: none;">
        <h1>My Courses:</h1>
        <table>
            <tr>
                <th>Course Name [CODE]</th>
                <th>Semester</th>
                <th>Class Room#</th>
                <th>Class Time</th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach ($_SESSION['teacher_profile'] as $tprofile) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($tprofile['course_name'] . '[' . $tprofile['course_code'] . ']'); ?></td>
                    <td><?php echo htmlspecialchars($tprofile['semester_name'] . ' ' . $tprofile['year']); ?></td>
                    <td><?php echo htmlspecialchars($tprofile['class_room_id']); ?></td>
                    <td><?php echo htmlspecialchars($tprofile['time']); ?></td>
                    <td>
                        <p><a href="#" style="text-decoration: none;" class='class_roster' name='<?php echo htmlspecialchars($tprofile['course_name']); ?>' id ='<?php echo htmlspecialchars($tprofile['course_id']); ?>'>Class Roster</a></p>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div id='class_roster_div' style="display: none;">
        
    </div>
    <div id='profile_div' style="display: none;">
        <h1>My Profile</h1><hr>
        <form action="." method="post" id="aligned">
            <input type="hidden" name="action" value="edit_profile">
            <input type="hidden" name="reg_id" value="<?php echo htmlspecialchars($_SESSION['reg_id']); ?>"<br>
            <label>Full Name:</label>
            <input type="text" name="fullname" value="<?php echo htmlspecialchars($_SESSION['name']); ?>"><br>

            <label>Gender:</label>
            <?php if ($_SESSION['gender'] == 'male'): ?>
                <input type="radio" name="gender" value="Male" checked> Male<br>
            <?php elseif (($_SESSION['gender'] == 'female')): ?>
                <input type="radio" name="gender" value="Female" checked>Female <br>
            <?php endif; ?>   

            <label>Reg. Type:</label>
            Teacher<input type="radio" name="regType" value="teacher" checked readonly="readonly"><br>

            <label>DOB:</label>
            <input type="text" name="dob" value="<?php echo htmlspecialchars($_SESSION['dob']); ?>"><br>

            <label>Email:</label>
            <input type="text" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>"><br>

            <label>&nbsp;</label>
            <input type="submit" value="Update" /><br>
        </form>
    </div>
    <div id='password_div' style="display: none;">
        <h1>Change Password:</h1><hr>
        <form action="." method="post" id="aligned">
            <input type="hidden" name="action" value="password_change">
            <input type="hidden" name="reg_id" value="<?php echo htmlspecialchars($_SESSION['reg_id']); ?>"><br>
            <label>Current Password:</label>
            <input type="password" name="current_password"><br>

            <label>New Password:</label>
            <input type="password" name="new_password"><br>

            <label>&nbsp;</label>
            <input type="submit" value="Change"><br>
        </form>
    </div>
    <script>
        $(document).ready(function () {
            var count = 0;
            $(".course_list").click(function () {
                count = count + 1;
                if (count % 2 == 0) {
                    $("#course_list_div").hide();
                } else {
                    $("#course_list_div").show();
                }
            });

            $(".profile").click(function () {
                count = count + 1;
                if (count % 2 == 0) {
                    $("#profile_div").hide();
                } else {
                    $("#profile_div").show();
                }
            });
            $(".password_change").click(function () {
                count = count + 1;
                if (count % 2 == 0) {
                    $("#password_div").hide();
                } else {
                    $("#password_div").show();
                }
            });
            $(".class_roster").click(function () {
                count = count + 1;
                if (count % 2 == 0) {
                    $("#class_roster_div").hide();
                } else {
                    $("#class_roster_div").show();
                }
                
                $("#class_roster_div").load('../teachers_stuffs/enrolled_student_list.php', {courseId:$(this).attr('id'), courseName:$(this).attr('name'),instructorId:$("input[name='reg_id']").val(), instructorName:$("input[name='fullname']").val()});
            });

            $("#aligned").submit(function (event) {
                var fullName = $("input[name='fullname']").val();
                var dob = $("input[name='dob']").val();
                var email = $("input[name='email']").val();

                if (fullName == '' || dob == '' || email == '') {
                    event.preventDefault();
                    alert("Please check all fields and provide required entry!");
                    return  false;
                } else {
                    return true;
                }
            });
        });
    </script>

</main>
<?php include '../view/footer.php'; ?>