<?php
function hidePassword($password) {
    $length = strlen($password);
    
    $hiddenPassword = str_repeat('*', $length);
    
    return $hiddenPassword;
}
