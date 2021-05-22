<?php
require('../model/database.php');
require('../model/DAO.php');
require_once '../model/registration.php';
require_once '../custom_function/if_password_matched.php';
session_start();
if (isset($_SESSION['use']) && isset($_SESSION['pass'])) {
    include('../student_stuffs/student_dashboard.php');
}
$reg = new Registration();
$dao = new DAOClass();

$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'get_start';
    }
}

switch ($action) {
    CASE $action == 'get_start':
        include('registration.php');
        break;

    CASE $action == 'registration':
        $reg->setFullName(filter_input(INPUT_POST, 'fullname'));
        $reg->setGender(filter_input(INPUT_POST, 'gender'));
        $reg->setRegType(filter_input(INPUT_POST, 'regType'));
        $reg->setDob(filter_input(INPUT_POST, 'dob'));
        $reg->setEmail(filter_input(INPUT_POST, 'email'));
        $reg->setPassword(filter_input(INPUT_POST, 'password'));
        $reg->setConfirmPassword(filter_input(INPUT_POST, 'cpassword'));
        try {
            $dao->add_profile($reg);
            $message = "The profile has been added to the database.";
        } catch (Exception $e) {
            include('../errors/error.php');
        }
        $profile = $dao->get_profile_details($reg);
        include('login.php');
        break;

    CASE $action == 'login':
        $username = filter_input(INPUT_POST, 'uname');
        $password = filter_input(INPUT_POST, 'password');
        $profile = $dao->get_login($username, $password);
        $_SESSION['reg_id'] = $profile['reg_id'];
        $_SESSION['type'] = $profile['type'];
        $_SESSION['name'] = $profile['name'];
        $_SESSION['email'] = $profile['email'];
        $_SESSION['dob'] = $profile['dob'];
        $_SESSION['gender'] = $profile['gender'];
        $_SESSION['use'] = $username;
        $_SESSION['pass'] = $password;
        if ($profile) {
            $dao->login($profile['reg_id'], $profile['email'], $profile['password']);
            if ($profile['type'] == 'student') {
                $searchKey = '';
                $course_list = $dao->get_course_list($searchKey);
                $enroled_course_list = $dao->get_enrolled_course_list($profile['reg_id']);
                if ($course_list != '' || $course_list != NULL) {
                    $_SESSION['course_list'] = $course_list;
                }
                if ($enroled_course_list != '' || $enroled_course_list != NULL) {
                    $_SESSION['enroled_course_list'] = $enroled_course_list;
                }
                include('../student_stuffs/student_dashboard.php');
            } else {
                $teacher_profile = $dao->get_teachers_details($profile['reg_id']);
                $_SESSION['teacher_profile'] = $teacher_profile;
                include('../teachers_stuffs/teacher_dashboard.php');
            }
        }
        break;

    CASE $action == 'course_registration':
        include('course_registration.php');
        break;
    CASE $action == 'edit_profile':
        $reg_id = filter_input(INPUT_POST, 'reg_id');
        $name = filter_input(INPUT_POST, 'fullname');
        $dob = filter_input(INPUT_POST, 'dob');
        $email = filter_input(INPUT_POST, 'email');
        try {
            $dao->update_profile($name, $dob, $email, $reg_id);
            $message = "The profile has been updated successfullye.";
        } catch (Exception $e) {
            include('../errors/error.php');
        }
        //header("Location: ..");
        break;

    CASE $action == 'password_change':
        $reg_id = filter_input(INPUT_POST, 'reg_id');
        $current_password = filter_input(INPUT_POST, 'current_password');
        $new_password = filter_input(INPUT_POST, 'new_password');
        try {         
            
            $matched_password = $dao->match_current_password($reg_id, $current_password);
            if (ifPassMatched($matched_password)) {
                if ($matched_password == $new_password) {
                    $message = "You can't use same as previous password. Try new one!";
                    return false;
                } else {
                    $dao->update_password($reg_id, $new_password);
                    $message = "The has been changed successfully.";
                }
            } else {
                include('../errors/error.php');
            }
        } catch (Exception $e) {
            include('../errors/error.php');
        }
        include("../student_stuffs/success_page.php");
        break;

    CASE $action == 'student_list':
        $courseId = filter_input(INPUT_POST, 'courseId');
        $instructorId = filter_input(INPUT_POST, 'instructorId');
        try {
            $student_list = $dao->get_enrolled_student_list($courseId, $instructorId);
            include('../teachers_stuffs/enrolled_student_list.php');
        } catch (Exception $e) {
            include('../errors/error.php');
        }
        break;

    CASE $action == 'student_letter_grade':
        $reg_id = filter_input(INPUT_POST, 'reg_id');
        $course_id = filter_input(INPUT_POST, 'course_id');
        $grade = filter_input(INPUT_POST, 'grade');
        try {
            $dao->add_letter_grade($reg_id, $course_id, $grade);
            $message = "The grade has been added to the database.";
            include('../student_stuffs/success_page.php');
        } catch (Exception $e) {
            include('../errors/error.php');
        }
        break;
    CASE $action == 'search_course':
        $searchKey = filter_input(INPUT_POST, 'search');
        $_SESSION['searchKey'] = $searchKey;
        $course_list = $dao->get_course_list($_SESSION['searchKey']);
        $_SESSION['course_list'] = $course_list;
        include('../student_stuffs/search_result.php');
        break;
    CASE $action == 'dashboard':
        $student_reg_id = filter_input(INPUT_POST, 'student_reg_id');
        $instructor_reg_id = filter_input(INPUT_POST, 'instructor_reg_id');
        $course_id = filter_input(INPUT_POST, 'course_id');
        try {
            $dao->enroll_course($student_reg_id, $instructor_reg_id, $course_id);
            $message = "The course has been enrolled successfully. Click home button to go back";
        } catch (Exception $e) {
            include('../errors/error.php');
        }
        include('../student_stuffs/success_page.php');
        break;
    CASE $action == 'withdraw_course':
        $student_course_info_id = filter_input(INPUT_POST, 'student_course_info_id');
        try {
            $dao->withdraw_course($student_course_info_id);
            $message = "The course has been withdrawn successfullye.";
        } catch (Exception $e) {
            include('../errors/error.php');
        }
        include('../student_stuffs/success_page.php');
        break;

    DEFAULT:
        break;
}
?>