<?php

function ifPassMatched($matched_password) {
    if ($matched_password) {
        $message = 'Congratulations! Password matched!';
        return true;
    } else {
        $message = 'Sorry! Password has not matched!';
        return false;
    }
}
?>