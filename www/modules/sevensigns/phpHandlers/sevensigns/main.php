<?php
$sql->saveRow("
    SELECT active_period AS period,
           IF(((S.date-1)=0),7,(S.date-1)) AS nthDay,
           (dusk_stone_score + dusk_festival_score) AS dusk_score,
           (dawn_stone_score + dawn_festival_score) AS dawn_score,
           avarice_owner AS avarice,gnosis_owner AS gnosis,strife_owner AS strife,
           '".gmdate('d/m/Y H:i:s',time() + 3600*(date('I')))."' AS ss_time
    FROM seven_signs_status AS S
    WHERE id='0'
");
?>