<?php

class Encryption {
    public static function hash($password): string {
        return md5($password);
    }
}

?>