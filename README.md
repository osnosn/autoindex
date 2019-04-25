# [Autoindex](https://github.com/osnosn/autoindex/)
Contains two separate projects

* ## 1. [Autoindex-php](https://github.com/osnosn/autoindex/tree/master/autoindex-php)
   ###  Autoindex write in PHP.   
   copy `.DirTrees/` and `index.php` into FOLDER.   
   <img src="https://github.com/osnosn/autoindex/raw/master/autoindex-php.png" width="300" />.   

* ## 2. [Nginx-autoindex](https://github.com/osnosn/autoindex/tree/master/nginx-autoindex)
   ### Nginx custom autoindex with XSLT.  
> use **[ngx_http_autoindex_module](http://nginx.org/en/docs/http/ngx_http_autoindex_module.html)** module.
> ```
> location ^~ /bt/ {
>    autoindex on;
>    autoindex_format html;
>    #autoindex_localtime off;
>    charset utf-8;
>    include /etc/nginx/default.d/php71w-fpm.conf;
> }
> ```
> <img src="https://github.com/osnosn/autoindex/raw/master/nginx-org.png" width="300" />. 
   

> use **[ngx_http_autoindex_module](http://nginx.org/en/docs/http/ngx_http_autoindex_module.html)** module.   
> use **[ngx_http_xslt_module](http://nginx.org/en/docs/http/ngx_http_xslt_module.html)** module.   
> ngx_http_xslt_module support by **libexslt**. So it can use **[EXSLT](http://exslt.org/)** functions.   
> ```
> location ^~ /bt/ {
>    autoindex on;
>    autoindex_format xml;
>    xslt_stylesheet /data/www/html/autoindex.xslt cpath="$uri";
>    #charset utf-8;
>    include /etc/nginx/default.d/php71w-fpm.conf;
> }
> 
> # modify variable "TIMEDIFF" in "autoindex.xslt", 
> # time nochange 'PT0H', +8 hour='PT8H', -6 hour='-PT6H'.
> ```
> <img src="https://github.com/osnosn/autoindex/raw/master/nginx-xslt.png" width="300" />.   
> File modification time is UTC time. Because only UTC time is provided in the XML file.   
> You can modify variable "TIMEDIFF" to change display of modify time.   
