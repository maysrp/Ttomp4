# Ttomp4
转码到MP4

### 配置

```
apt-get install ffmpeg
```
#### 创建目录

* pre 
* doing

确保两个目录权限777 [让PHP写入转码配置]
[确保两个文件夹下没有其他.sh脚本文件]

### 使用范例

index.php


```
<?php
	include "vcode.php";
	$vcode=new vcode();
	$vcode->vcode("/home/a.mp4","/home/c",2);
 /*
  参数1: /home/a.mp4为文件的路径,请用绝对路径
  参数2：/home/c 转码储存的目录 [请不要在后面添加 "/"]
  参数3： 1为转码【同画质】 2额外转换出一个848X480的分辨率视频
*/


```

配置cron
```
crontab -e
```
```
*/1 * * * * sh /home/vcode/cron.sh 
```
目前文件目录应该如此:
* ./
	* doing/      权限: 777
	* pre/        权限: 777
	* cron.sh
	* vcode.php
	* head.sh
	* index.php  [运行脚本地址，可为其他文件名,但必须同目录]


自动生成的转码配置文件

若想在其他目录下调用，请把doing 和 pre 和cron.sh head.sh与你的调用的文件放在同一目录下

```
#!/bin/bash
m=`uptime | awk '{print int($8)}'`
if [ "$m" -gt 2 ];then
	exit
fi

cd ./pre
mv 5b9a4c7ce81c35e3ba855e11d08c3ee2.mp4.sh ../doing
ffmpeg -y -i /home/wwwroot/default/m/v.mp4 -c:v libx264 -strict -2 /home/wwwroot/default/m/video/5b9a4c7ce81c35e3ba855e11d08c3ee2.mp4
ffmpeg -y -i /home/wwwroot/default/m/v.mp4 -c:v libx264 -strict -2 -s 848*480 /home/wwwroot/default/m/video/small_5b9a4c7ce81c35e3ba855e11d08c3ee2.mp4
rm ../doing/5b9a4c7ce81c35e3ba855e11d08c3ee2.mp4.sh
#R#E#M#/home/wwwroot/default/m/v.mp4#R#E#M#/home/wwwroot/default/m/video/5b9a4c7ce81c35e3ba855e11d08c3ee2.mp4
```

### 核心文件

* vcode.php
* head.sh
* cron.sh


