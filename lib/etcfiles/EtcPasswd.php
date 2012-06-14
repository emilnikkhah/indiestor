<?php

/*
        Indiestor simulation program

	Written by Erik Poupaert, erik@sankuru.biz
        Commissioned at peopleperhour.com 
        By Alex Gardiner, alex.gardiner@canterbury.ac.uk
*/

<<<<<<< HEAD
=======
class oneUser
{
	var $name=null;
	var $homeFolder=null;
	var $shell=null;
}

>>>>>>> fixes to error messages; reorganized indiestor subfolders
class EtcPasswd
{
	static $instance=null;	
        var $users=null;

	//----------------------------------------------
	// INSTANCE
	//----------------------------------------------

	static function instance()
	{
		if(self::$instance==null) self::$instance=new EtcPasswd();
		return self::$instance;
	}

	//----------------------------------------------
	// RESET
	//----------------------------------------------

	static function reset()
	{
		self::$instance=null;
	}

	//----------------------------------------------
	// CONSTRUCTOR
	//----------------------------------------------

	function __construct()
	{
		//username:...other fields ...
		$etcPasswdFile=file_get_contents('/etc/passwd');
		$this->parseEtcPasswdFile($etcPasswdFile);
	}

	//----------------------------------------------
	// PARSE PASSWD FILE
	//----------------------------------------------

        function parseEtcPasswdFile($etcPasswdFile)
        {
		$etcPasswdFileLines=explode("\n",$etcPasswdFile);
		foreach($etcPasswdFileLines as $etcPasswdFileLine)
		{
			if(strlen($etcPasswdFileLine)>0)
			{
				$this->parseEtcPasswdFileLine($etcPasswdFileLine);
			}
		}
                
        }
 
	//----------------------------------------------
	// PARSE PASSWD FILE LINE
	//----------------------------------------------

	function parseEtcPasswdFileLine($etcPasswdFileLine)
	{
		$etcPasswdFileLinefields=explode(':',$etcPasswdFileLine);
<<<<<<< HEAD
		$user=$etcPasswdFileLinefields[0];
		$this->users[$user]=$user;
=======
		$user=new oneUser();
		$user->name=$etcPasswdFileLinefields[0];
		$user->homeFolder=$etcPasswdFileLinefields[5];
		$user->shell=$etcPasswdFileLinefields[6];
		$this->users[$user->name]=$user;
>>>>>>> fixes to error messages; reorganized indiestor subfolders
	}

	//----------------------------------------------
	// EXISTS
	//----------------------------------------------

	function exists($userName)
	{
<<<<<<< HEAD
		foreach($this->users as $user)
		{
			if($user==$userName)
			{
				return true;
			}
		}
		return false;
	}

=======
		return $this->findUserByName($userName)!=null;
	}

	//----------------------------------------------
	// FIND USER BY NAME
	//----------------------------------------------

	function findUserByName($userName)
	{
		foreach($this->users as $user)
		{
			if($user->name==$userName)
			{
				return $user;
			}
		}
		return null;
	}

	//----------------------------------------------
	// FIND USER BY HOME FOLDER
	//----------------------------------------------

	function findUserByHomeFolder($homeFolder)
	{
		foreach($this->users as $user)
		{
			if($user->homeFolder==$homeFolder)
			{
				return $user;
			}
		}
		return null;
	}
>>>>>>> fixes to error messages; reorganized indiestor subfolders
}
