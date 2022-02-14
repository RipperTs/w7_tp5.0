## 微擎ThinkPHP应用模块开发框架

### 序言

在使用之前需要有thinkphp框架开发基础，否则可能无法快速上手。  需要注意的是，php版本推荐使用7.1，另外宝塔会默认在php7.1禁用一些函数，根据自己需要删减吧

ThinkPHP5.0版本，开发手册： https://www.kancloud.cn/manual/thinkphp5/118003  

此模块可以正常使用所有基于php的composer，基于Thinkphp的消息队列等所有特性，所以你可以在不了解或者完全不需要查看微擎开发文档的基础上也能自己开发出来微擎模块。  

同样的配套H5和原生小程序前端用于快速上手对应的前端开发  

如果你有需要，还可以查看微擎开发文档(https://wiki.w7.cc/document/35/370)，毕竟微擎有些关于微信的方法封装的很好，我们同样的可以直接使用微擎的类和方法，就像下面这个获取assesstoken的示例：  

```php
$account_api = \WeAccount::create(); // 所有的微擎类，需要加\才能用到，不需要在上面use
return $account_api->getAccessToken();
```



#### 适配进度

- Thinkphp5.0框架所有均支持  
- composer已支持

- 微擎模块路由已支持  

- 微擎模块多开已支持  

- 微擎原装api已支持  

- 微信小程序前端基础框架已支持  

- 微信公众号、H5前端框架已支持  



## 快速上手

#### 创建应用

创建应用填写必要信息后，返回到`分支/版本`，在版本列表中点击`编辑`，这时候下载一个基础包，我们可以在这个基础包中进行基于微擎的原生开发，但这并不是本文档推荐的方式。

同时，因程序不依赖微擎框架，创建应用时候请选择PC，避免审核失败。当然，如果是小程序端可以自行改写调整api，然后在微擎中再次上传一个纯前端的小程序代码。

![img](https://api.axu9.com/Public/Uploads/2020-11-12/5face54152f8c.png)

Tips：微擎应用有多版本设置，因此我们可以将`管理后台` `超级后台` 分开，比如说：基础版只有`管理后台`入口，高级版才有`超级后台` `管理后台` 两个入口。

![img](https://api.axu9.com/Public/Uploads/2020-11-12/5face5bb8f562.png)

导出模块基础包就可以进行开发了！

#### 整合基础包

- 在微擎上下载应用生成的基础包文件，保留的文件有：
`developer.cer` `icon.jpg` `manifest.xml` `preview.jpg` 

修改 manifest.xml，将数据库安装，卸载，更新文件替换到新的应用基础包中，代码如下：

```xml
<install><![CDATA[install.php]]></install>
<uninstall><![CDATA[uninstall.php]]></uninstall>
<upgrade><![CDATA[upgrade.php]]></upgrade>
```

将上面代码替换到 `manifest.xml` 文件中即可，然后直接将这四个文件替换到ThinkPHP的模块框架文件夹中即可。

压缩成zip上传到微擎的`addons`文件夹中即可。

#### 安装模块

在微擎模块管理中，执行刚刚上传的模块后会自动写入数据库一些常用的演示数据，因此后台的账号密码如下：

###### 普通后台

账号： `admin`  

密码：`chaungcai@123`  

##### 超级管理后台

账号：`admin`  

密码： `chuangcai@123`  

你可以查看`install.php`文件修改创建数据库的表前缀



#### 开发规范
1. 禁止使用`db`进行数据库操作  
2. 禁止使用`saveAll`等`ThinkPHP`框架提供的批量数据操作方法
3. 使用原生`sql`必须带上`uniacid`查询条件  
4. 数据库建表必须带上`wxapp_id` `uniacid` 两个字段，字段类型为`int(11)` 默认 `0`

- 更新应用如涉及到数据库更新操作，前置操作必须判断字段是否存在，且更新记录文件内容永久保留，下次再涉及到数据库更新，应在上一个版本后面追加写`SQL`

#### 目录结构

```
tp5_web
├─ source                                   ThinkPHP框架目录(tp框架基础结构和composer)
│  ├─ application                            应用目录
│  │  ├─ admin                              超级管理后台入口模块
│  │  │  ├─ controller                   控制器层
│  │  │  ├─ extra                          左侧菜单
│  │  │  │  └─ menus.php            菜单文件
│  │  │  ├─ model                         超级后台模型层
│  │  │  ├─ view                           超级后台模板目录
│  │  │  ├─ config.php                  超级后台复写全局配置文件
│  │  ├─ api                                   前端接口模块(所有的前端请求接口都在此目录)
│  │  │  ├─ behavior                     接口应用行为(主要包含支付成功回调处理事件)
│  │  │  ├─ controller                   控制器层
│  │  │  ├─ model                         模型层
│  │  │  ├─ service                        服务层（主要实现api接口的扩展与方法重用）
│  │  │  ├─ validate                      表单数据校验（参考ThinkPHP表单验证规则）
│  │  │  ├─ config.php                  复写全局配置文件
│  │  │  ├─ tags.php                     行为标签扩展文件(处理支付成功行为)
│  │  ├─ common                           公共模块
│  │  │  ├─ behavior                     接口应用行为(主要包含支付成功回调处理事件)
│  │  │  │  └─ App.php                自动记录系统各种运行日志
│  │  │  ├─ enum                          枚举类库模块（处理各种枚举应用场景）
│  │  │  ├─ exception                    异常抛出模块
│  │  │  │  └─ BaseException.php                自定义异常基类
│  │  │  │  └─ ExceptionHandler.php           自定义异常消息类（错误日志自动写入）
│  │  │  ├─ library                         library类库(调起支付、短信、打印、全局钩子等)
│  │  │  ├─ model                全局模型层(admin/api/store模型层都需要继承这里的模型)
│  │  │  ├─ service                        服务层(含海报生成、太阳码生成等)
│  │  ├─ store                                管理后台模块
│  │  │  ├─ controller                   控制器层
│  │  │  ├─ extra                          左侧菜单
│  │  │  │  └─ menus.php            菜单文件
│  │  │  ├─ model                         超级后台模型层
│  │  │  ├─ service                        服务层
│  │  │  ├─ view                           超级后台模板目录
│  │  │  │  ├─ layouts                           超级后台模板目录
│  │  │  │  │  └─ error.php                 错误模板文件
│  │  │  │  │  └─ layout.php                后台公共模板部分
│  │  │  ├─ common.php               管理后台公共函数库文件
│  │  │  ├─ config.php                  复写全局配置文件
│  │  ├─ task                                 公共行为
│  │  ├─ common.php                     全局公共方法
│  │  ├─ config.php                       全局统一配置文件
│  │  ├─ database.php                     数据库配置文件
│  │  ├─ route.php                        路由(如非必要，无需修改)
│  │  ├─ tags.php                          应用行为初始化
│  ├─ runntime                               ThinkPHP缓存目录
│  ├─ thinkphp                               ThinkPHP框架目录
│  ├─ vendor                                  composer依赖目录
├─ web                                           静态文件入口
│  ├─ assets                                   全局js文件存储目录
│  ├─ temp                                    临时文件目录
│  ├─ uploads                                 上传文件目录
│  └─ index.php                             原入口文件（废弃）
│  └─ notice.php                            异步回调通知入口（废弃）
├─ developer.cer                              微擎模块证书文件
├─ dist.zip                                       Vue前端文件
├─ icon.jpg                                      应用图标
├─ index.php                                   应用入口文件
├─ install.php                                  sql安装执行文件
├─ manifest.xml                              微擎模块描述文件（模块唯一）
├─ module.php                                微擎模块
├─ notice.php                                  微信支付回调异步通知
├─ notice.txt                                   微信支付回调地址文件
├─ preview.jpg                                应用图标（建议与icon.jpg相同）
├─ site.php                                      微擎web模块入口
├─ start.php                                    处理微擎路由规则
├─ uninstall.php                               卸载sql执行文件
├─ upgrade.php                               更新应用执行文件中内容（可处理数据库操作）
├─ version.json                                系统版本
└─ wxapp.php                                  前端接口入口模块
```



#### 预定义常量

- `WEB_PATH` 模块运行根目录
- `APP_PATH` 应用运行目录
- `SITE_URL` 模版静态文件访问公共地址
- `MODULE_NAME` 当前模块(微擎)
- `MODULE_UNIACID` 当前模块的 i 参数值
- `ROOT_URL` 根目录

#### 路由

##### 生成路由

使用`siteUrl`函数生成路由（该函数写在`application\Common.php`文件中）
页面间的路由跳转将会变成：
```php 
// 原来的样子
$this->redirect('passport/login');
// 改写后的样子
$this->redirect(siteUrl('passport/login'));
```
使用用过`thinkphp5`的`url`函数的同学应该清楚，前两个参数和`url`函数类似， 而`$weDoor`这个参数，不传则默认当前入口

#### siteUrl() 函数的路由参数

路由参数表示此方法的第一个参数，规则大致与ThinkPHP路由规则相同，如下：
`控制器/方法`
`目录.控制器/方法`
`/模块/控制器/方法` (不推荐)
`/模块/目录.控制器/方法` （不推荐）

> 以上参数路由规则定义仅适合在此函数中使用，代码判断区别依据是`/`的出现次数

#### 路由规则

###### 后台路由规则

地址例子：`https://w7demo.test.noteo.cn/web/index.php?m=tp5_web&c=site&a=entry&do=store&tpp=/index/index`

参数解释：
- `m` 表示当前安装的应用名，同时也是ThinkPHP模块最外层的文件夹名字
- `do` 表示模块
- `tpp` 传入的ThinkPHP路由

要注意的路径是：`web/index.php` 表示后台地址入口文件关于ThinkPHP路由可以参考：[ThinkPHP路由](https://www.kancloud.cn/manual/thinkphp5/118029 "ThinkPHP路由")，这里大致说下：
`/控制器/方法&参数值1=xxx&参数值2=xxx`  如果模块在目录包含中(外层有文件夹的)/目录.控制器/方法&参数值1=xxx&参数值2=xxx`

> 在这里需要注意的是，每个控制器前面的`/`是必须填写的，否则解析失败！

##### 前台接口路由规则

地址例子：`https://w7demo.test.noteo.cn/app/index.php?m=tp5_web&c=entry&a=wxapp&i=4&do=api&tpp=/`

参数解释：
- `i` 表示当前模块的 `uniacid` 注意：这个是变动的，每次安装模块都会改变
- `m` 表示当前安装的应用名，同时也是ThinkPHP模块最外层的文件夹名字
- `do` 表示当前模块
- `tpp` 传入的ThinkPHP路由，参考上面路由规则
- `a` 表示`wxapp.php`为接口的入口文件，此文件作用具体参考微擎开发文档

> 在这里需要注意的是，每个控制器前面的`/`是也是必须填写的，否则解析失败！

这里的路径是 `app/index.php` 表示的是前台接口，区别就是这个接口不用验证微擎的登陆信息



#### 安装、卸载、更新sql

在模块根目录下新建以下三个文件
- install.php
- uninstall.php
- upgrade.php （此文件每次更新模块都会执行一次）

代码参考：
```php
global $_W;
$tablename = trim(tablename('tp5_web_'),"`");
$uniacid = $_W['uniacid'];
pdo_query("
	DROP TABLE IF EXISTS `{$tablename}admin_user`;
")
```
这里的`tp5_web_`表示表前缀，在安装过程中微擎会自动在前面追加`ims_`，因此最后可能生成的表前缀：`ims_tp5_web_user` 完全符合微擎定义的数据库表名规范。

然后在`manifest.xml`文件中修改以下：
```xml
<install><![CDATA[install.php]]></install>
<uninstall><![CDATA[uninstall.php]]></uninstall>
<upgrade><![CDATA[upgrade.php]]></upgrade>
```
用来表示模块安装、更新、卸载直接操作数据库

#### 支付回调

在统一下单api接口中填写回调地址如下：

```php
'notify_url' => request()->domain() . '/addons/' . MODULE_NAME . '/notice.php',  // 异步通知地址
```
微信或者支付宝均填写此地址，实际指向的方法`/source/application/api/controller/Notify.php` 中的 `order()` 方法。

后续可根据自己业务自行扩展。



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