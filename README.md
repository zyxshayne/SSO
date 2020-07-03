**说明：**

此项目是简要展示单点登录的工作原理

www.a.com: 提供A服务

www.b.com :提供B服务

www.sso.com:认证中心

重写session机制，共享session存储，都是写在redis中 