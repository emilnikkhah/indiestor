<?php
/*
        Indiestor program

	Written by Erik Poupaert, erik@sankuru.biz
        Commissioned at peopleperhour.com 
        By Alex Gardiner, alex.gardiner@canterbury.ac.uk
*/

<<<<<<< HEAD
require_once('ShellCommand.php');

=======
>>>>>>> added --volume -quota-remove --volumes -purge-fstab-backups
/*

Deletes a group from the system. Example:

$ delgroup myfriends

*/

function syscommand_delgroup($groupName)
{
	ShellCommand::exec("delgroup $groupName");
}
