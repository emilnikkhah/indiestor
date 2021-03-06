<?php
/*
        Indiestor program
        Concept, requirements, specifications, and unit testing
        By Alex Gardiner, alex@indiestor.com
        Written by Erik Poupaert, erik@sankuru.biz
        Commissioned at peopleperhour.com 
        Licensed under the GPL
*/

class UserReportRecord
{
	var $userName=null;
	var $homeFolder=null;
	var $device=null;
	var $locked=null;
	var $groupName=null;
	var $hasQuotaRecord=null;
	var $quotaTotalGB=null;
	var $quotaUsedGB=null;
	var $quotaUsedPerc=null;

	function __construct($userName)
	{
		$this->userName=$userName;
		$etcPasswd=EtcPasswd::instance();
		$etcUser=$etcPasswd->findUserByName($userName);
		$this->homeFolder=$etcUser->homeFolder;
		//find device for user home folder
		$this->device=sysquery_df_device_for_folder($this->homeFolder);
		$this->locked=sysquery_passwd_S_locked($userName);
		$etcGroup=EtcGroup::instance();
		$group=$etcGroup->findGroupForUserName($userName);
		if($group==null) $this->groupName=null;
		else $this->groupName=$group->name;

		if(sysquery_df_filesystem_for_folder($this->homeFolder)=='zfs')
			$quotaRecord=sysquery_df_quota_for_folder($userName,$this->homeFolder);
		else
			$quotaRecord=null;

		if($quotaRecord!=null)
		{
			$this->hasQuotaRecord=true;
			$this->quotaTotalGB=$this->convertToGB($quotaRecord['quota']);
			$this->quotaUsedGB=$this->convertToGB(trim($quotaRecord['used']));
			if($this->quotaTotalGB!=0)
				$this->quotaUsedPerc=floor($this->quotaUsedGB/$this->quotaTotalGB*100);
			else
				$this->quotaUsedPerc=0;
		}
		else
		{
			$this->hasQuotaRecord=false;
		}
	}

	function convertToGB($quotaRepNumber)
	{
		$len=strlen($quotaRepNumber);
		if($len>=2)
		{
			$lastChar=substr($quotaRepNumber,-1);
			$number=substr($quotaRepNumber,0,-1);
			if(!is_numeric($number)) return 0;
			switch(strtoupper($lastChar))
			{
				case 'K': return $number/(1024*1024);
				case 'M': return $number/1024;
				case 'G': return $number;
				case 'T': return $number*1024;
				default: return 0;
			}
		}
		else
		{
			return 0;
		}
	}
}

