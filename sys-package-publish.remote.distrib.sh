#!/usr/bin/env bash
#------------------------------------------------------------
#        Indiestor program
#
#	 Written by Erik Poupaert, erik@sankuru.biz
#        Commissioned at peopleperhour.com 
#        By Alex Gardiner, alex.gardiner@canterbury.ac.uk
#------------------------------------------------------------
# Runs on the remote deployment server
# Executes the reprepro script to populate the deployment
# repository
#------------------------------------------------------------

cd /home/packages/packages.indiestor.com/html/apt/ubuntu
reprepro -Vb . include precise incoming/indiestor_0.8.0.10_amd64.changes
rm incoming/indiestor_0.8.0.10*
