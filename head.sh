#!/bin/bash
m=`uptime | awk '{print int($8)}'`
if [ "$m" -gt 2 ];then
	exit
fi
