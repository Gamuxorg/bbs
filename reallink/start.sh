#!/bin/bash
HERE=$(cd "$(dirname "$0")";pwd);
cd "$HERE"

GameName="gamename"
midLink="/tmp/tmp.$GameName"
configHomeDir="$HOME/.gamux/common/$GameName/"
dires=(`cat ./local-data-dires`);
files=(`cat ./local-data-files`);
 
if [ ! -d "$configHomeDir" ];then
    mkdir -p "$configHomeDir"
fi

for i in "${dires[@]}";do
    rm -rf "${midLink}.$i"
    if [ ! -d "${configHomeDir}/$i" ];then
        mkdir -p "${configHomeDir}/$i"
    fi
    ln -s "${configHomeDir}/$i" "${midLink}.$i"
done
 
for i in "${files[@]}";do
    rm -rf "${midLink}.$i"
    if [ ! -f "${configHomeDir}/$i" ];then
        rm -rf "${configHomeDir}/$i"
        touch "${configHomeDir}/$i"
    fi
    ln -s "${configHomeDir}/$i" "${midLink}.$i"
done
 
##########################################################################################
# 添加二进制文件，可能需要export LD_LIBRARY_PATH，根据实际情况修改

"$HERE"/xxxxx $@
 
###########################################################################################
 
for i in "${dires[@]}";do
    rm -rf "${midLink}.$i"
done
for i in "${files[@]}";do
    rm -rf "${midLink}.$i"
done
