<?php
/*
        Indiestor program

	Written by Erik Poupaert, erik@sankuru.biz
        Commissioned at peopleperhour.com 
        By Alex Gardiner, alex.gardiner@canterbury.ac.uk
*/

/*

Enables quota. Example:

$ quotaon -ug /

*/

function syscommand_quotaon($mountPoint)
{
	ShellCommand::exec_fail_if_error("quotaon --format=vfsold -u $mountPoint");
}
