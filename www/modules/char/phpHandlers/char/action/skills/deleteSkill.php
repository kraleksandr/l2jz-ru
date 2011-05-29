<?php
$skill_id    = $_REQUEST['skill_id'];
$skill_level = check_numeric($_REQUEST['skill_level'],"Skill level must be numeric.");
$skill_name  = check_skill($skill_id,$skill_level);
$char        = check_obj_id($_REQUEST['char_id'],"char");

kick($char['id']);
mysql_query("DELETE FROM character_skills WHERE char_obj_id='".$char['id']."' AND skill_id='$skill_id' AND skill_level='$skill_level'");
print $skill_name." was succesfully deleted."
?>