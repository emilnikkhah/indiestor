#!/usr/bin/php
<?php

/*
        Indiestor program
        Concept, requirements, specifications, and unit testing
        By Alex Gardiner, alex@indiestor.com
        Written by Erik Poupaert, erik@sankuru.biz
        Commissioned at peopleperhour.com 
        Licensed under the GPL
*/

//--------------------------
//Check deployment location
//--------------------------
if (dirname(__FILE__)=='/usr/share/indiestor/prg')
{
	$BIN='/usr/bin';
	$LIB='/usr/share/indiestor';
	$INUSER='indienotify';
}
else
{
	$BIN=dirname(__FILE__);
	$LIB=dirname(__FILE__).'/lib';
	$INUSER='root';
}

function indiestor_INUSER()
{
	global $INUSER;
	return $INUSER;
}

function indiestor_BIN()
{
	global $BIN;
	return $BIN;
}

function requireLibFile($path)
{
	global $LIB;
	require_once("$LIB/$path");
}

//--------------------------

requireLibFile("admin/etcfiles/EtcPasswd.php");
requireLibFile("admin/etcfiles/EtcGroup.php");
requireLibFile("admin/sysqueries/df.php");
requireLibFile("admin/action-engine/Incrontab.php");
requireLibFile("inotify/syslog.php");
requireLibFile("inotify/SharingStructureDefault.php");
requireLibFile("inotify/SharingStructureAvid.php");
requireLibFile("inotify/SharingStructureMXF.php");
requireLibFile("inotify/SharingOperations.php");
requireLibFile("inotify/SharingFolders.php");
requireLibFile("inotify/chmodRecursive.php");

//syslog error handling
function customError($errno,$errmsg,$errfile,$errline)
{
        if($errno==0) return true; //ignore errors prepended with @
	syslog_notice("err:$errno,$errmsg in file $errfile, line $errline");
	die();
}
set_error_handler("customError");

//catch fatal errors
function handleShutdown()
{
	$error = error_get_last();
	if($error !== NULL)
		customError('FATAL-SHUTDOWN',$error['message'],$error['file'],$error['line']);
}
register_shutdown_function('handleShutdown');

/*
	while(true)
		retrieve the group
		process the group
	remove pid file
*/

define('PID_FILE','/var/run/indiestor/process.pid');

function lockProcess()
{
	file_put_contents(PID_FILE,getmypid()."\n");
	chown(PID_FILE,'indienotify');
}

function unlockProcess()
{
	if(file_exists(PID_FILE)) unlink(PID_FILE);
}

syslog_notice_start_running();

lockProcess();
while(true)
{

	$groupFiles=glob("/var/lock/indiestor/*");
	//pick the first group available or terminate

	if($groupFiles===FALSE)
	{
		syslog_notice("error reading /var/lock/indiestor");
		break;		
	}
	if(count($groupFiles)==0) break;
	$groupFile=$groupFiles[0];
	$groupName=basename($groupFile);
	unlink($groupFile);
	syslog_notice("processing group: $groupName");

	//find group record by name
	$group=EtcGroup::instance()->findGroup($groupName);
	if($group==null)
	{
		syslog_notice("cannot find group '$GroupName'; skipping");
		continue;
	}

	//retrieve all group members
	$members=EtcPasswd::instance()->findUsersForEtcGroup($group);

	//reshare
	SharingStructureAvid::reshare($groupName,$members);
	SharingStructureMXF::reshare($members);
	SharingStructureDefault::reshare($groupName,$members);
}

unlockProcess();
syslog_notice("generating incrontab");
Incrontab::generate();

//notify end run
syslog_notice_end_running();
