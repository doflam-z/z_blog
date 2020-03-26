<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=phptest1", "root", "root");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   //设置PDO显示异常
} catch (PDOException $e) {
    echo '数据库连接失败' . $e->getMessage();
}
$article=$_POST["test-editor-html-code"];
//echo $article;
//$str=htmlspecialchars($article, ENT_QUOTES);
//echo $str;
//$sql="insert into article (article_title,article_content) value('Nginx获取Let’s Encrypt SSL证书',$str)";
$sql="insert into article (article_title,article_content) value('TEST','<p>服务器：centos7<br>v2ray：官网一键安装脚本<br>nginx：yum安装</p> <h2 id=\"h2--nginx-v2ray\"><a name=\"安装nginx、v2ray\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>安装nginx、v2ray</h2><p>执行官网一键安装脚本，<a href=\"https://www.v2ray.com/chapter_00/install.html\">v2ray官网地址</a></p> <pre><code>[root]# bash &lt;(curl -L -s https://install.direct/go.sh) </code></pre><p>安装nginx软件源+安装nginx</p> <pre><code>[root~]# rpm -ivh http://nginx.org/packages/centos/7/noarch/RPMS/nginx-release-centos-7-0.el7.ngx.noarch.rpm [root~]# yum install nginx -y </code></pre><h2 id=\"h2--let-s-encrypt-ssl-nginx-let-s-encrypt-ssl-\"><a name=\"获取Let’s Encrypt SSL证书方法可查看 Nginx获取Let’s Encrypt SSL证书\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>获取Let’s Encrypt SSL证书方法可查看<a href=\"https://blog.csdn.net/qq_43308140/article/details/102853956\">Nginx获取Let’s Encrypt SSL证书</a></h2><p>获取证书成功后证书会保存至\"/etc/letsencrypt/live/你申请的域名/\" 目录下。</p> <h2 id=\"h2--v2ray\"><a name=\"配置v2ray\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>配置v2ray</h2><p>打开/etc/v2ray/config.json文件，删除所有内容，填入以下配置。</p> <pre><code>[root~]# vi /etc/v2ray/config.json { &quot;inbounds&quot;: [ { &quot;port&quot;: 12306, &quot;listen&quot;:&quot;127.0.0.1&quot;, &quot;protocol&quot;: &quot;vmess&quot;, &quot;settings&quot;: { &quot;clients&quot;: [ { &quot;id&quot;: &quot;eec3e54c-68ba-4b7a-bfe2-a98b9821c143&quot;, &quot;alterId&quot;: 64 } ] }, &quot;streamSettings&quot;: { &quot;network&quot;: &quot;ws&quot;, //使用的协议 &quot;wsSettings&quot;: { &quot;path&quot;: &quot;/ws&quot; //这个路径 必须与nginx配置的路径相同 } } } ], &quot;outbounds&quot;: [ { &quot;protocol&quot;: &quot;freedom&quot;, &quot;settings&quot;: {} } ] } </code></pre><h2 id=\"h2--nginx\"><a name=\"配置nginx\" class=\"reference-link\"></a><span class=\"header-link octicon octicon-link\"></span>配置nginx</h2><p>新建nginx配置文件，在/etc/nginx/conf.d/路径下新建v2ray.conf文件</p> <pre><code>[root~]# vi /etc/nginx/conf.d/v2ray.conf server { listen 443 ssl; ssl on; ssl_certificate /etc/letsencrypt/live/你 的域名/fullchain.pem; //这是你申请好的证书路径 ssl_certificate_key /etc/letsencrypt/live/你的域名/privkey.pem; //这是你 申请的证书密钥路径 ssl_protocols TLSv1 TLSv1.1 TLSv1.2; ssl_ciphers HIGH:!aNULL:!MD5; server_name linode.doflam.top; location /ws { //这个路径要与config.json文件里配置的相同 proxy_redirect off; proxy_pass http://127.0.0.1:12306; proxy_http_version 1.1; proxy_set_header Upgrade ￥http_upgrade; proxy_set_header Connection &quot;upgrade&quot;; proxy_set_header Host ￥http_host; } } </code></pre><p>检查nginx配置文件</p> <pre><code>[root~]# nginx -t nginx: the configuration file /etc/nginx/nginx.conf syntax is ok nginx: configuration file /etc/nginx/nginx.conf test is successful </code></pre><p>重启nginx、v2ray</p> <pre><code>[root~]# systemctl restart nginx v2ray </code></pre><p>客户端连接，完成。<br>注意服务器防火墙需要开放443端口。</p>')";
//echo $sql;
$result=$pdo->exec($sql);
echo $result;