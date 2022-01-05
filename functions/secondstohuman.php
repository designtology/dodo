<?php
function human2seconds($time) {
    list($d, $h, $m, $s) = explode(':', $time);
    return ($d * 86400) + ($h * 3600) + ($m * 60) + $s;
}

function seconds2human($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%D:%H:%I:%S');
}

?>