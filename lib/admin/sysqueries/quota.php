<?php
/*
        Indiestor program

	Written by Erik Poupaert, erik@sankuru.biz
        Commissioned at peopleperhour.com 
        By Alex Gardiner, alex.gardiner@canterbury.ac.uk
*/

/*

Queries a user quota. Example:

$ quota -u john
quota: Cannot open quotafile //aquota.user: No such file or directory ==> quota file does not exist

$ quota -u john
Disk quotas for user john (uid 1011): none     ---> quota not enable for user or for filesystem

$ quota --no-wrap --show-mntpoint --hide-device -u john
Disk quotas for user john (uid 1011): 
     Filesystem  blocks   quota   limit   grace   files   quota   limit   grace
              /      28  2621440 2359296               5       0       0        

*/

function sysquery_quota_u($userName)
{
	$result=ShellCommand::query("quota --format=vfsold -u $userName");
	if(preg_match("/^Disk quotas for user $userName \(uid .*\)\: none$/",$result))
	{
	 	return null;
	}
	else if(preg_match("/^quota: Cannot open quotafile/",$result))
	{
	 	return null;
	}
	//watch out --show-mntpoint and --hide-device is not supported in older versions of the quota package
	$result=ShellCommand::query_fail_if_error("quota --no-wrap -u $userName | tail -n +3");
	$result=preg_replace('/ +/',' ',$result);
	$fields=explode(' ',$result);

	//there must be at least 3 fields in the result
	if(count($fields)<4) return null;

	//match the result fields into a quota record
	$quotaRecord=array();
	$quotaRecord['quotaUsedBlocks']=floatval($fields[2]);
	$quotaRecord['quotaTotalBlocks']=floatval($fields[3]);

	if($quotaRecord['quotaTotalBlocks']!=0)
	{
		$quotaRecord['quotaUsedPerc']=number_format(($quotaRecord['quotaUsedBlocks']/$quotaRecord['quotaTotalBlocks'])*100,0);
	}
	else
	{
		$quotaRecord['quotaUsedPerc']='100';	
	}
	return $quotaRecord;
}
