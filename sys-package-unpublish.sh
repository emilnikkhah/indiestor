#!/usr/bin/env bash
#------------------------------------------------------------
# Indiestor program
# Concept, requirements, specifications, and unit testing
# By Alex Gardiner, alex@indiestor.com
# Written by Erik Poupaert, erik@sankuru.biz
# Commissioned at peopleperhour.com 
# Licensed under the GPL
#------------------------------------------------------------
# Removes the deployment packages on the deployment server
# for a particular distribution
# Reverses sys-package-publish.sh (for all versions)
#------------------------------------------------------------

# load the default environment
source ./config-default.sh

#remove distribution publication
ssh $user_machine rm -rf $user_repository_root/$distribution/{db,dists,pool}

