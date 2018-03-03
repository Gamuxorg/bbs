#!/bin/bash
HERE=$(cd "$(dirname "$0")";pwd);
cd "$HERE"

#modify to game name
GameName="gamename"
dires=(`cat ./local-data-dires`);
files=(`cat ./local-data-files`);

for i in "${dires[@]}";do
    rm -rf "$HERE/$i"
    ln -s "/tmp/tmp.$GameName.$i" "$HERE/$i"
done
for i in "${files}";do
    rm -rf "$HERE/$i"
    ln -s "/tmp/tmp.$GameName.$i" "$HERE/$i"
done
