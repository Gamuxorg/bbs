# 使用说明
此目录内的三个文件目的是在打包appimage时，解决目录为只读，而文件需要写入的问题。
使用顺序：
* 首先修改find-local-data-and-files.sh文件，替换文件名为实际游戏的二进制/运行脚本的名称，然后运行。
* 其次修改build-readlink.sh，替换为游戏名称，然后运行
* 最后修改start.sh，替换为游戏名称和实际游戏的二进制的名称，然后替换原游戏脚本。

请注意，三个文件内替换的字符有所区别。