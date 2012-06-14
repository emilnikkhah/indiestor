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
	$result=sysquery("quota -u $userName");
	if(preg_match("/^Disk quotas for user $userName \(uid .*\)\: none$/",$result))
	{
	 	return null;
	}
	else if(preg_match("/^quota: Cannot open quotafile/",$result))
	{
	 	return null;
	}
	$result=sysquery("quota --no-wrap --show-mntpoint --hide-device -u $userName | tail -n +3");
	$result=preg_replace('/ +/',' ',$result);
	$fields=explode(' ',$result);
	$quotaRecord=array();
	$quotaRecord['quotaTotalBlocks']=$fields[3];
	$quotaRecord['quotaUsedBlocks']=$fields[2];
	if($fields[3]!=0)
	{
		$quotaRecord['quotaUsedPerc']=number_format(($fields[2]/$fields[3])*100,2);
	}
	else
	{
		$quotaRecord['quotaUsedPerc']='100.00';
	}
	return $quotaRecord;
}
