#!/bin/bash
HERE=$(cd "$(dirname "$0")";pwd);
cd "$HERE"

GameName="gamename"
midLink="/tmp/tmp.$GameName"
configHomeDir="$HOME/.gamux/common/$GameName/"
dires=(`cat ./local-data-dires`);
 
if [ ! -d "$configHomeDir" ];then
    mkdir -p "$configHomeDir"
fi

for i in "${dires[@]}";do
    rm -rf "${midLink}.${i}"
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
# Add Game Start File
if [ "`uname -m`" != "x86_64" ]; then
    BINDIR=Bin
else
    BINDIR=Bin/x64
fi

export LD_LIBRARY_PATH="${BINDIR}:$LD_LIBRARY_PATH"

"$HERE"/$BINDIR/Talos $@
 
###########################################################################################
 
for i in "${dires[@]}";do
    rm -rf "${midLink}.${i}"
done
for i in "${files[@]}";do
    rm -rf "${midLink}.$i"
done
