<?php
/*
        Indiestor program

	Written by Erik Poupaert, erik@sankuru.biz
        Commissioned at peopleperhour.com 
        By Alex Gardiner, alex.gardiner@canterbury.ac.uk
*/

/*

Copies a folder recursively preserving all atributes. Example:

$ cp /home/john /var/users/stor3

*/

function syscommand_cp_aR($fromPath,$toPath)
{
	ShellCommand::exec("cp -aR $fromPath $toPath");
}

