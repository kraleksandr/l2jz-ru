<?php
$skill_id    = $_REQUEST['skill_id'];
$skill_level = check_numeric($_REQUEST['skill_level'],"Skill level must be numeric.");
$skill_name  = check_skill($skill_id,$skill_level);
$char        = check_obj_id($_REQUEST['char_id'],"char");

kick($char['id']);
$result = mysql_query("SELECT char_obj_id FROM character_skills WHERE char_obj_id='".$char['id']."' AND skill_id='$skill_id'");
if(mysql_num_rows($result)>0){
	$result = mysql_query("UPDATE character_skills SET skill_level='$skill_level' WHERE char_obj_id='".$char['id']."' AND skill_id='$skill_id'");
	print $skill_name." was succesfully edited.";
} else {
	mysql_query("INSERT INTO character_skills(char_obj_id, skill_id, skill_level) VALUES('".$char['id']."' , '$skill_id', '$skill_level')");
	print $skill_name." was succesfully added.";
}
?>