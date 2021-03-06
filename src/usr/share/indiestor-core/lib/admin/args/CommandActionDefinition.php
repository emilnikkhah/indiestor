<?php
/*
        Indiestor program
        Concept, requirements, specifications, and unit testing
        By Alex Gardiner, alex@indiestor.com
        Written by Erik Poupaert, erik@sankuru.biz
        Commissioned at peopleperhour.com 
        Licensed under the GPL
*/

requireLibFile('admin/args/CommandAction.php');

class CommandActionDefinition
{
        var $entityType=null;
        var $action=null;
	var $priority=null;
        var $hasArg=null;
	var $isOption=null;
	var $isUpdateCommand=null;

        function __construct($entityType,$action,$hasArg,$priority,$isOption,$isUpdateCommand)
        {
                $this->entityType=$entityType;
                $this->action=$action;
                $this->hasArg=$hasArg;
		$this->priority=$priority;
		$this->isOption=$isOption;
		$this->isUpdateCommand=$isUpdateCommand;
        }

	function newCommandAction($action,$actionArg)
	{
		return new CommandAction
		(
			$action,
			$actionArg,
			$this->priority,
			$this->isOption,
			$this->isUpdateCommand
		);
		
	}
}

