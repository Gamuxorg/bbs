#!/bin/bash
touch time_stun
#modify to elf of game, so this will start game
./ELF-file-of-game
find  . -maxdepth 1 -cnewer time_stun  -type d |grep -v '^\.$' |cut -d/ -f2 > local-data-dires
find  . -maxdepth 1 -cnewer time_stun  -type f |grep -v '^\.$' |cut -d/ -f2 |grep -v 'local-data-dires' |grep -v 'local-data-files' > local-data-files
rm time_stun
