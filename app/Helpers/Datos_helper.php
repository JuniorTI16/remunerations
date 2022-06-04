<?php
    function sanitize($arg)
    {
        $arg = trim($arg);
        $arg = filter_var($arg, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        return $arg;
    }

    function isAuth(){
        $session = session();
        $value = $session->get('auth') ?  true : false;
        return $value;
    }