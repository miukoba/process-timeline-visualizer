#!/bin/bash

ps -Ao pid,args| grep YOUR-GREP-KEYWORD | grep -v grep | awk '{print d "," $0}' "d=`date '+%Y/%m/%d %H:%M:%S'`" >> /path/to/log/$(date +%Y%m%d).log 2>&1
