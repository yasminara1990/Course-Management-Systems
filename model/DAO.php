<?php

class DAOClass {

    function add_profile($reg) {
        $db = Database::getDB();
        $date = date('Y-m-d');  // get current date in yyyy-mm-dd format
        try {
            $query = 'INSERT INTO register VALUES
            (DEFAULT,:type, :name, :email, :password, :cpassword, :dob,  :gender)';
            $statement = $db->prepare($query);
            $statement->bindValue(':type', $reg->getRegType());
            $statement->bindValue(':name', $reg->getFullName());
            $statement->bindValue(':email', $reg->getEmail());
            $statement->bindValue(':password', $reg->getPassword());
            $statement->bindValue(':cpassword', $reg->getConfirmPassword());
            $statement->bindValue(':dob', $date);
            $statement->bindValue(':gender', $reg->getGender());
            $statement->execute();
            $statement->closeCursor();
        } catch (Exception $e) {
            include('../errors/error.php');
        }
    }

    function get_profile_details($reg) {
        $db = Database::getDB();
        $query = 'SELECT * 
              FROM register
              WHERE email = :email';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $reg->getEmail());
        $statement->execute();
        $profile = $statement->fetch();
        $statement->closeCursor();
        return $profile;
    }

    function get_login($username, $password) {
        $db = Database::getDB();
        $query = 'SELECT * 
              FROM register
              WHERE email = :email AND password= :password';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $username);
        $statement->bindValue(':password', $password);
        $statement->execute();
        $profile = $statement->fetch();
        $statement->closeCursor();
        return $profile;
    }

    function login($regId, $usernamae, $pass) {
        $db = Database::getDB();
        $date = date('Y-m-d');  // get current date in yyyy-mm-dd format
        try {
            $query = 'INSERT INTO login VALUES(DEFAULT, :reg_id, :email,:password, :login_date)';
            $statement = $db->prepare($query);
            $statement->bindValue(':reg_id', $regId);
            $statement->bindValue(':email', $usernamae);
            $statement->bindValue(':password', $pass);
            $statement->bindValue(':login_date', $date);
            $statement->execute();
            $statement->closeCursor();
        } catch (Exception $e) {
            include('../errors/error.php');
        }
    }

    function get_teachers_details($reg_id) {
        $db = Database::getDB();
        $query = 'SELECT reg.reg_id, reg.name, reg.type, reg.email,reg.gender,reg.dob, ci.course_id, ci.course_name, ci.course_code, sem.semester_name, sem.year,  cri.class_room_id, cri.time
                    FROM register reg
                    INNER JOIN instructor_course_info ici ON (reg.reg_id = ici.instructor_id)
                    INNER JOIN course_info ci ON (ici.course_id = ci.course_id)
                    INNER JOIN semester_info sem ON (ci.semester_id = sem.semester_id)
                    INNER JOIN class_room_info cri ON (cri.class_room_id = ci.class_room_id)
                    WHERE reg.reg_id = :reg_id';
        $statement = $db->prepare($query);
        $statement->bindValue(':reg_id', $reg_id);
        $statement->execute();
        $teacher_profile = $statement->fetchAll();
        $statement->closeCursor();
        return $teacher_profile;
    }

    function update_profile($name, $dob, $email, $reg_id) {
        $db = Database::getDB();
        try {
            $query = 'UPDATE register SET name = :name, dob = :dob, email = :email WHERE reg_id = :reg_id';
            $statement = $db->prepare($query);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':dob', $dob);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':reg_id', $reg_id);
            $statement->execute();
            $statement->closeCursor();
        } catch (Exception $e) {
            include('../errors/error.php');
        }
    }

    function match_current_password($reg_id, $current_password) {
        $db = Database::getDB();
        $query = 'SELECT password
                  FROM register 
                  WHERE reg_id = :reg_id AND password = :current_password';
        $statement = $db->prepare($query);
        $statement->bindValue(':reg_id', $reg_id);
        $statement->bindValue(':current_password', $current_password);
        $statement->execute();
        $present_password = $statement->fetch();
        $statement->closeCursor();
        return $present_password;
    }

    function update_password($reg_id, $new_password) {
        $db = Database::getDB();
        try {
            $query = 'UPDATE register SET password = :new_password, confirm_password = :new_password WHERE reg_id = :reg_id';
            $statement = $db->prepare($query);
            $statement->bindValue(':new_password', $new_password);
            $statement->bindValue(':reg_id', $reg_id);
            $statement->execute();
            $statement->closeCursor();
        } catch (Exception $e) {
            include('../errors/error.php');
        }
    }
    function get_enrolled_student_list($courseId, $instructorId) {
        $db = Database::getDB();
        $query = 'SELECT reg.reg_id, reg.name, reg.email, reg.gender, ci.course_id
                    FROM register reg
                    INNER JOIN student_course_info sci ON sci.student_id = reg.reg_id
                    INNER JOIN course_info ci ON ci.course_id = sci.course_id
                    WHERE sci.course_id = :course_id AND sci.instructor_id = :instructor_id';
        $statement = $db->prepare($query);
        $statement->bindValue(':course_id', $courseId);
        $statement->bindValue(':instructor_id', $instructorId);
        $statement->execute();
        $student_list = $statement->fetchAll();
        $statement->closeCursor();
        return $student_list;
    }
    function add_letter_grade($reg_id, $course_id, $grade) {
        $db = Database::getDB();
        try {
            $query = 'INSERT INTO letter_grade VALUES
            (DEFAULT,:reg_id, :course_id, :grade)';
            $statement = $db->prepare($query);
            $statement->bindValue(':reg_id', $reg_id);
            $statement->bindValue(':course_id', $course_id);
            $statement->bindValue(':grade', $grade);
            $statement->execute();
            $statement->closeCursor();
        } catch (Exception $e) {
            include('../errors/error.php');
        }
    }
    function get_course_list($searchKey) {
        $db = Database::getDB();
        if($searchKey==''){
            $query = 'SELECT reg.reg_id,reg.name, ci.course_id, ci.course_name, si.semester_id, CONCAT(si.semester_name, ", ", si.year) AS semester_name, cri.class_room_id, cri.time
            FROM register reg
            INNER JOIN instructor_course_info sci ON sci.instructor_id = reg.reg_id
            INNER JOIN course_info ci ON ci.course_id = sci.course_id
            INNER JOIN semester_info si ON ci.semester_id = si.semester_id
            INNER JOIN class_room_info cri ON ci.class_room_id = cri.class_room_id';
        }else{
            $query = 'SELECT reg.reg_id,reg.name, ci.course_id, ci.course_name, si.semester_id, CONCAT(si.semester_name, ", ", si.year) AS semester_name, cri.class_room_id, cri.time
            FROM register reg
            INNER JOIN instructor_course_info sci ON sci.instructor_id = reg.reg_id
            INNER JOIN course_info ci ON ci.course_id = sci.course_id
            INNER JOIN semester_info si ON ci.semester_id = si.semester_id
            INNER JOIN class_room_info cri ON ci.class_room_id = cri.class_room_id
            WHERE ci.course_id=:searchKey || ci.course_name=:searchKey ||reg.name=:searchKey';
        }
        $statement = $db->prepare($query);
        $statement->bindValue(':searchKey', $searchKey);
        $statement->execute();
        $course_list = $statement->fetchAll();
        $statement->closeCursor();
        return $course_list;
    }
    function enroll_course($student_reg_id, $instructor_reg_id, $course_id) {
        $db = Database::getDB();
        try {
            $query = 'INSERT INTO student_course_info VALUES
            (DEFAULT,:student_id, :course_id, :instructor_id, 1)';
            $statement = $db->prepare($query);
            $statement->bindValue(':student_id', $student_reg_id);
            $statement->bindValue(':course_id', $course_id);
            $statement->bindValue(':instructor_id', $instructor_reg_id);
            $statement->execute();
            $statement->closeCursor();
        } catch (Exception $e) {
            include('../errors/error.php');
        }
    }
    function get_enrolled_course_list($reg_id) {
        $db = Database::getDB();
            $query = 'SELECT reg.reg_id,reg.name, ci.course_id, ci.course_name, si.semester_id, CONCAT(si.semester_name, ", ", si.year) AS semester_name, cri.class_room_id, cri.time, sci.student_course_info_id
            FROM register reg
            INNER JOIN student_course_info sci ON sci.student_id = reg.reg_id
            INNER JOIN course_info ci ON ci.course_id = sci.course_id
            INNER JOIN semester_info si ON ci.semester_id = si.semester_id
            INNER JOIN class_room_info cri ON ci.class_room_id = cri.class_room_id
            WHERE reg_id=:reg_id AND sci.if_enrolled=1';
        $statement = $db->prepare($query);
        $statement->bindValue(':reg_id', $reg_id);
        $statement->execute();
        $course_list = $statement->fetchAll();
        $statement->closeCursor();
        return $course_list;
    }
    function withdraw_course($student_course_info_id) {
        $db = Database::getDB();
        try {
            $query = 'UPDATE student_course_info SET if_enrolled = 0 WHERE student_course_info_id=:student_course_info_id';
            $statement = $db->prepare($query);
            $statement->bindValue(':student_course_info_id', $student_course_info_id);
            $statement->execute();
            $statement->closeCursor();
        } catch (Exception $e) {
            include('../errors/error.php');
        }
    }
}

?>