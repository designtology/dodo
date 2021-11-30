<?php

function seconds2human($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%D:%H:%I:%S');
}

?>