## 微擎ThinkPHP应用框架
### 消息队列处理
需要使用`/source/think`文件来处理消息队列,`exec()`函数执行监听指令时必须添加`2>&1 &`使其后台执行,
或者使用单线程模式,否则将大大消耗服务器内存

#### 消息队列配置文件
`extra/queue.php`

#### 消息队列处理类
`source/application/common/message/DoJob.php`

#### 发送及消费消息demo
`source/application/common/message/sendDemo.php`

#### 监听消息队列
1. 在此项目目录下执行命令 `sh ./start.sh`
2. 然后 `Ctrl+c` 终止前台命令。
3. `ps -ef|grep queue|grep -v grep`查看进程,  
   找到 `think queue`进行即可
4. 关闭小黑框即可, 如果服务器重启后需要再次执行以上操作  

**注意,必须使用 `Ctrl+c` 方式进行退出,否则不会后台运行**

```
关于消息队列:
    与原有的ThinkPHP的queue不同,注意查看使用demo
```