<?php include '../view/header.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="../js/jquery.min.js"></script>
<?php
if (!isset($_SESSION['use']) && !isset($_SESSION['pass']) && !isset($_SESSION['course_list'])) { // If session is not set then redirect to Login Page
    header("Location:Login.php");
}
echo "Login Success";

echo "<a href='logout.php'> Logout</a> ";
?>
<main>
    <h3>You have logged in as  <?php echo $_SESSION['name']; ?></h3>
    <p><a href="#" class='srchlink'>Click Here to search available course!<i class="fa fa-search"></i></a></p>
    <p><a href="#" class='availableCourselink'>View Available Courses</a></p>
    <p><a href="#" class='enrolledCourselink'>View Enrolled Courses</a></p>
    <p><a href="#" class='profilelink'>View Profile</a></p>
    <p><a href="#" class='pswdChangelink'>Changed Password</a></p>
    <div class="search_div" style="display:none;">

    </div>
    <div class="enrolled_course_div" style="display:none;">
        <form action="." method="post" id="aligned">
            <input type="hidden" name="action" value="withdraw_course">
            <table>
                <tr>
                    <th>Course Name</th>
                    <th>Semester</th>
                    <th>Instructor</th>
                    <th>Class Room#</th>
                    <th>Time</th>
                    <th>&nbsp;</th>
                </tr>
                <?php foreach ($_SESSION['enroled_course_list'] as $list) : ?>
                    <input type="hidden" name="student_course_info_id" value="<?php echo htmlspecialchars($list['student_course_info_id']); ?>"> 
                    <tr>
                        <td><?php echo htmlspecialchars($list['course_name']); ?></td>
                        <td><?php echo htmlspecialchars($list['semester_name']); ?></td>
                        <td><?php echo htmlspecialchars($list['name']); ?></td>
                        <td><?php echo htmlspecialchars($list['class_room_id']); ?></td>
                        <td><?php echo htmlspecialchars($list['time']); ?></td>

                        <td>
                            <input type="submit" value="Withdraw"/>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </form>

    </div> 
    <div class="profile_div" style="display:none;">
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
            Student<input type="radio" name="regType" value="student" checked readonly="readonly"><br>

            <label>DOB:</label>
            <input type="text" name="dob" value="<?php echo htmlspecialchars($_SESSION['dob']); ?>"><br>

            <label>Email:</label>
            <input type="text" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>"><br>

            <label>&nbsp;</label>
            <input type="submit" value="Update" /><br>
        </form>
    </div>
    <div class="password_change_div" style="display:none;">
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
    <div class="course_div" style="display:none;">
        <form action="." method="post" id="aligned">
            <input type="hidden" name="action" value="dashboard">
            <input type="hidden" name="student_reg_id" value="<?php echo $_SESSION['reg_id']; ?>">
            <table>
                <tr>
                    <th>Course Name</th>
                    <th>Semester</th>
                    <th>Instructor</th>
                    <th>Class Room#</th>
                    <th>Time</th>
                    <th>&nbsp;</th>
                </tr>
                <?php foreach ($_SESSION['course_list'] as $list) : $i=0+1; ?>
                    
                    <input type="hidden" name="instructor_reg_id" value="<?php echo htmlspecialchars($list['reg_id']); ?>"> 
                    <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($list['course_id']); ?>"> 
                    <tr>
                        <td><?php echo htmlspecialchars($list['course_name']); ?></td>
                        <td><?php echo htmlspecialchars($list['semester_name']); ?></td>
                        <td><?php echo htmlspecialchars($list['name']); ?></td>
                        <td><?php echo htmlspecialchars($list['class_room_id']); ?></td>
                        <td><?php echo htmlspecialchars($list['time']); ?></td>

                        <td>
                            <input type="submit" value="Enroll" name="enrol_<?php echo $i; ?>"/>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </form>
    </div>
    <script>
        $(document).ready(function () {

            $(".srchlink").click(function () {
                $(".course_div").hide();
                $(".enrolled_course_div").hide();
                $(".password_change_div").hide();
                $(".profile_div").hide();
                $(".search_div").show();
                $(".search_div").load('../student_stuffs/search_result.php');
            });
            $(".availableCourselink").click(function () {
                $(".course_div").show();
                $(".search_div").hide();
                $(".enrolled_course_div").hide();
                $(".password_change_div").hide();
                $(".profile_div").hide();
            });

            $(".enrolledCourselink").click(function () {
                $(".enrolled_course_div").show();
                $(".search_div").hide();
                $(".course_div").hide();
                $(".password_change_div").hide();
                $(".profile_div").hide();
            });

            $(".pswdChangelink").click(function () {
                $(".password_change_div").show();
                $(".enrolled_course_div").hide();
                $(".search_div").hide();
                $(".course_div").hide();
                $(".profile_div").hide();
            });
            $(".profilelink").click(function () {
                $(".profile_div").show();
                $(".password_change_div").hide();
                $(".enrolled_course_div").hide();
                $(".search_div").hide();
                $(".course_div").hide();
            });
        });
    </script>
</main>
<?php include '../view/footer.php'; ?>