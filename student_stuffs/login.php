<?php include '../view/header.php'; ?>
<script src="../js/jquery.min.js"></script>
<main>
    <?php if(isset($message)): ?>
    <?php echo $message; ?>
    <?php endif;?>
    
    <?php if(isset($profile)): ?>
    <?php echo 'Welcome '. $profile['name'].'. Now login to access the dashboard!'; ?>
    <?php endif;?>
       
    <h1>Login</h1>
    <form action="." method="post" id="aligned">
        <input type="hidden" name="action" value="login">
        <input type="hidden" name="reg_id" value="<?php echo $profile['name']; ?>">

        <label>Username:</label>
        <input type="text" name="uname"><br>

        <label>Password:</label>
        <input type="password" name="password"><br>

        <label>&nbsp;</label>
        <input type="submit" name = "login" value="Login" /><br>
    </form>
    <script>
        $(document).ready(function () {
            $("#aligned").submit(function (event) {
                var username = $("input[name='uname']").val();
                var password = $("input[name='password']").val();
                if (username == '' || password == '') {
                    event.preventDefault();
                    alert("Please check all fields and provide required entry!");
                    return  false;
                }else{
                    return true;
                }
            });
        });

    </script>

</main>
<?php include '../view/footer.php'; ?>