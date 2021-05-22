<?php include '../view/header.php'; ?>
<script src="../js/jquery.min.js"></script>
<main>
    <h1>Registration</h1>
    <form action="." method="post" id="aligned">
        <input type="hidden" name="action" value="registration">

        <label>Full Name:</label>
        <input type="text" name="fullname"><br>

        <label>Male:</label>
        <input type="radio" name="gender" value="Male" checked> Male<br>
        <label>Female:</label>
        <input type="radio" name="gender" value="Female" checked> Female<br>

        <label>Student Type:</label>
        <input type="radio" name="regType" value="student" checked><br> 
        <label>Teacher Type:</label>
        <input type="radio" name="regType" value="teacher"><br>

        <label>DOB:</label>
        <input type="text" name="dob"><br>

        <label>Email:</label>
        <input type="text" name="email"><br>

        <label>Password:</label>
        <input type="password" name="password"><br>

        <label>Confirm Password:</label>
        <input type="password" name="cpassword"><br>

        <label>&nbsp;</label>
        <input type="submit" value="Register" /><br>
    </form>
    <script>
        $(document).ready(function () {
            $("#aligned").submit(function (event) {
                var fullName = $("input[name='fullname']").val();
                var gender = $('input[name="gender"]:checked').val();
                var regType = $('input[name="regType"]:checked').val();
                var dob = $("input[name='dob']").val();
                var email = $("input[name='email']").val();
                var password = $("input[name='password']").val();
                var cpassword = $("input[name='cpassword']").val();
                if (fullName == '' || dob == '' || email == '' || password == '' || cpassword =='') {
                    event.preventDefault();
                    alert("Please check all fields and provide required entry!");
                    return  false;
                }else{
                    if(password!=cpassword){
                        event.preventDefault();
                        alert("Password doesn't match. Try again!");
                        return  false;
                    }
                    return true;
                }
            });
        });

    </script>
</main>
<?php include '../view/footer.php'; ?>