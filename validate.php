<?php

    function check_empty($data) {
        return empty($data);
    }

    function check_characters($data) {
        return (preg_match('/^[a-zA-Zа-яА-ЯёЁ]++$/u', $data) === 0);
    }

?>
