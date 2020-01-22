<?php

function numReais($num){
    return "R$ ".number_format($num,2, ",", ".");
}

?>