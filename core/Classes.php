<?php

class Util{

    public function sanitaze($dados){

        $d = strtolower($dados);
        $da = trim($d);
        $dad = addslashes($da);

        return $dad;
    }
}