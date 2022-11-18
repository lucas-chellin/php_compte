<?php


/**
 * fonction DEV qui permet un affichage clair des donnés (array, 
 * string, number...)
 */

function debug($value){
    echo "<pre>";
        print_r($value);
    echo"</pre>";

}