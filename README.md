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
  /home/a.mp4为文件的路径,请用绝对路径
  /home/c 转码储存的目录 [请不要在后面添加 "/"]
*/
```

配置cron
```
crontab -e
```
```
*/1 * * * * sh /home/vcode/cron.sh 
```

### 核心文件

* vcode.php
* head.sh
* cron.sh


