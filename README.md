# [autoindex](https://github.com/osnosn/autoindex/)

* ## [autoindex-php/](https://github.com/osnosn/autoindex/tree/master/autoindex-php)
   autoindex write in PHP.   
   copy `.DirTrees/` and `index.php` into FOLDER.   
   <img src="https://github.com/osnosn/autoindex/raw/master/autoindex-php.png" width="300" />.   

* ## [nginx-autoindex](https://github.com/osnosn/autoindex/tree/master/nginx-autoindex)

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
   

> ```
> location ^~ /bt/ {
>    autoindex on;
>    autoindex_format xml;
>    xslt_stylesheet /data/www/html/autoindex.xslt cpath="$uri";
>    #charset utf-8;
>    include /etc/nginx/default.d/php71w-fpm.conf;
> }
> ```
> <img src="https://github.com/osnosn/autoindex/raw/master/nginx-xslt.png" width="300" />.   
> File modification time is UTC time. Because only UTC time is provided in the XML file. 
