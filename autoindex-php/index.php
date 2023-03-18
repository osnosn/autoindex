<?php

define('START_DIR',__DIR__);
define('TARGET_FILE',START_DIR.'/'.'index11.html'); //target_file
define('README_FILE','readme');
define('START_URL','.');
define('BASE_HREF','');
//define('BASE_HREF','<base href="http://fxb.csair.com/soft/" />');
define('ICON_PATH','.DirTrees/');
//$WRITE_FILE_OR_OUTPUT='file';

class MyClass 
{
   public $dirtreeid=1;
   function __construct() {
   }
}
date_default_timezone_set('Asia/Chongqing');

function writefile($wkdir,$tt){
    global $WRITE_FILE_OR_OUTPUT;
    global $imgfolder,$imgfolder1,$imgbase,$imgminus,$imgminus1,$imgplus,$imgplus1;
    $f=$wkdir;
    $t=$wkdir;
    $start_url=START_URL;
    $rootname=basename($f);
    $runtime=getmicrotime();
    $tt->dirtreeid=1;
    $tfile=TARGET_FILE;
    $readmefile=README_FILE;
    if(isset($WRITE_FILE_OR_OUTPUT) && $WRITE_FILE_OR_OUTPUT=='file') {
       if(!( $fp=fopen($tfile,'ab'))) {  // open by append mode 
          csnwrite('"'.basename($tfile).'",  ');
          csnwrite("Can not open file! exit.\n");
          return ;
       }
       if(!flock($fp,LOCK_EX|LOCK_NB)) {  // lock file 
          csnwrite('"'.basename($tfile).'",  ');
          csnwrite("Can not lock file! exit.\n");
          fclose($fp);
          return ;
       }
       ftruncate($fp,0); // clear file, for write 
    } else {
       $fp=fopen('php://output','w');
    }
    fwrite($fp,'<!doctype html>
<html>
<head>'.BASE_HREF.'
<meta charset="UTF-8"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes, minimum-scale=0.5, maximum-scale=2.0" />
<title> '.((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']==='on')?'SSL-':'').$rootname.' </title>
<style>
table{border:0px;margin:0px;padding:0px;border-collapse:collapse;}
td{border:0px;margin:0px;padding:0px;font-size:12px;}
img{vertical-align:middle;border:0px;}
.out{
	font-family:Verdana,Arial,Helvetica,sans-serif;
	font-size:12px;color: #666666;
}
body {
	font-family:Georgia,"Times New Roman",Times,serif;
	font-size: 12px;color: #666666;
}
.cap{ }
.capAct{color:#000000;background-color:#FFEECC;}
.capHL{color: #FFFFFF;background-color:#003366;}
A{COLOR:#000088;TEXT-DECORATION:none;TEXT-TRANSFORM:none;}
A:hover{COLOR:#880000;FONT-SIZE:9pt;TEXT-DECORATION:underline;}
</style>
<script>
function Display(rItems)
{
  child=document.getElementById(\'child\'+rItems);
  img1=document.getElementById(\'img1\'+rItems);
  img2=document.getElementById(\'img2\'+rItems);
  //alert((img1.src));
  if ((child.style.display=="") || (child.style.display=="none")) {
    child.style.display="block";
    img2.src="'.$imgfolder1.'";
    if(img1.src.match("1.gif$"))
       img1.src="'.$imgminus1.'";
    else
       img1.src="'.$imgminus.'";
  } else {
    child.style.display="none";
    img2.src="'.$imgfolder.'";
    if(img1.src.match("1.gif$"))
       img1.src="'.$imgplus1.'";
    else
       img1.src="'.$imgplus.'";
  }
  return false;
}
function HL(th,sf){
  th.className="capAct";
  //try{sf.onmouseover()}catch(e){}//必须加上
}
function NL(th,sf){
  th.className="cap";
  //try{sf.onmouseout()}catch(e){}//必须加上
}
</script>
</head>
<body bgcolor="#FDFDFD">
 <table width="100%">
   <tr><td>
    ');
    if(is_file($readmefile) && is_readable($readmefile)) {
       //$readmefp=fopen('readme','rb');
       fwrite($fp,file_get_contents($readmefile));
       //fclose($readmefp);
    }
    $tnow=new DateTime();
    fwrite($fp,'
   <hr>
   </td></tr>
   <tr align="top">
    <td width="100%" align="top">

  <div>
      <table><tr>
        <td><img src="'.$imgbase.'"/></td>
        <td>'.$rootname.'</td>
        <td width="40"></td>
        <td bgcolor="#5389BC" width="20"></td>
        <td bgcolor="#5389BC"><span onclick="Expand(true)" style="padding:5px;color:#FFFFFF;cursor:pointer;">Expand</span></td>
        <td bgcolor="#5389BC" width="30"></td>
        <td bgcolor="#5389BC"><span onclick="Expand(false)" style="padding:5px;color:#FFFFFF;cursor:pointer;">Minimize</span></td>
        <td bgcolor="#5389BC" width="20"></td>
        <td width="20"></td>
        <td width="190">'.$tnow->format('Y-m-d H:i:s O D').'</td>
      </tr></table>
  </div>
      ');
    $files=array();
    if($handle=opendir($f)){
       while(false !== ($file=readdir($handle))) {
          if($file[0]=='.') continue; // 去掉 . 开始的文件名 
          $files[]=$file;
       }
       closedir($handle);
       {
          $files=hidefile_sort($files,$f);
          $countfiles=count($files);
          for ($i=0;$i<$countfiles;$i++) {
             csnwrite($files[$i]);
             $ct=array(array($i,$countfiles), );
             printpath($fp,$f,$files[$i],  $ct,  $tt,$start_url);
             csnwrite("\n");
          }
       }
    } else { // 权限问题, 或其他问题 
       fwrite($fp, '<file lv="'.($tt->dirtreeid).'" caption="(access deny!)(无权限)" size="" mtime=""/>'."\n");
       $tt->dirtreeid+=1;
    }
    $runtime=sprintf('%.3f',getmicrotime()-$runtime);
    csnwrite( "\n".'----('.$runtime.'")----'."\n");
    if(isset($WRITE_FILE_OR_OUTPUT) && $WRITE_FILE_OR_OUTPUT=='file') {
       $runtime='   <br>.. End.<br>';
    } else {
       $runtime='    <br>.. End. ('.$runtime.'&quot;)<br>';
    }
    fwrite($fp,'
      </td>
    </tr>
  </table>   '.$runtime.'
  <script>
function Expand(exp)
{
  for(i=1;i<'.($tt->dirtreeid).';i++){
  child=document.getElementById(\'child\'+i.toString());
  img1=document.getElementById(\'img1\'+i.toString());
  img2=document.getElementById(\'img2\'+i.toString());
  if(exp==true){
    child.style.display="block";
    img2.src="'.$imgfolder1.'";
    if(img1.src.match("1.gif$"))
       img1.src="'.$imgminus1.'";
    else
       img1.src="'.$imgminus.'";
  } else {
    child.style.display="none";
    img2.src="'.$imgfolder.'";
    if(img1.src.match("1.gif$"))
       img1.src="'.$imgplus1.'";
    else
       img1.src="'.$imgplus.'";
  }
  }
  return false;
}
  </script>
  <br/>
</body>
</html>
    ');
    flock($fp,LOCK_UN);
    fclose($fp);
}
    
function printpath($fp,$orgpath,$onefile,$ct,$tt,$orgurl) {
   global $imgplus1,$imgplus,$imgfolder,$imgjoin,$imgjoin1,$imgfile;
    if ($onefile[0]=='.')
        return;
    csnwrite('.');
    fwrite($fp,'
  <table>
    <tr><td>
    <table>
    <tr><td nowrap="noWarp">
    ');
    showimg($fp,$ct);
    $currentpath=$orgpath.'/'.$onefile;
    $currenturl=$orgurl.'/'.rawurlencode($onefile);
    if (is_dir($currentpath)) {   // 是目录 
        $buf=$onefile.'  ';
        $mystat=stat($currentpath);
        $mymtime=date('Y-m-d H:i:s',$mystat['mtime']);
        $last=array_slice($ct,-1,1);
        if ($last[0][1]-$last[0][0]==1) { 
            fwrite($fp,'<img id="img1'.$tt->dirtreeid.'" src="'.$imgplus1.'" onclick="Display(\''.$tt->dirtreeid.'\')"/>');
        } else {
            fwrite($fp,'<img id="img1'.$tt->dirtreeid.'" src="'.$imgplus.'" onclick="Display(\''.$tt->dirtreeid.'\')"/>');
        }
        fwrite($fp,'<img id="img2'.$tt->dirtreeid.'" src="'.$imgfolder.'" onclick="Display(\''.$tt->dirtreeid.'\')"/>');
        fwrite($fp,'
      </td></tr>
     </table>
    </td>
    <td width="900">
    <table width="100%" onmouseover="HL(this,self);" onmouseout="NL(this,self);">
        ');
        if(($mystat['mode']&5)==5) { // other 有权限 r-x
           fwrite($fp,'<tr>');
        } else {
           fwrite($fp,'<tr bgcolor="#ffdddd">');
        }
        fwrite($fp,'
    <td align="left" nowrap="noWarp">
      <span>
        ');
        fwrite($fp,$onefile);
        fwrite($fp,'
      </span>
    </td>
    <td width="170" nowrap="noWarp">'.$mymtime.'
    </td>
    <td width="40"></td>
    </tr>
    </table>
    </td></tr>
   </table>
        ');
        fwrite($fp,'<div id="child'.$tt->dirtreeid.'" style="color:black;display:none;">');
        $tt->dirtreeid+=1;
        $dirs=array();
        if($handle=opendir($currentpath)){
           while(false !== ($file=readdir($handle))) {
              if($file[0]=='.') continue; // 去掉 . 开始的文件名 
              $dirs[]=$file;
           }
           closedir($handle);
           {
              if (count($dirs)<1) {
                 empty_accdeny($fp,$ct,'(Empty)(空)');
              } else {
                 $dirs=hidefile_sort($dirs,$currentpath);
                 $countdirs=count($dirs);
                 for ($i=0;$i<$countdirs;$i++) {
                    printpath($fp,$currentpath,$dirs[$i], array_merge($ct,array(array($i,$countdirs),)), $tt, $currenturl);
                 }
              }
           }
        } else { // 权限问题, 或其他问题 
           empty_accdeny($fp,$ct,'(access deny!)(无权限)');
        }
        fwrite($fp, "</div>\n");
    } else {  // 是普通文件 
        $last=array_slice($ct,-1,1);
        if ($last[0][1]-$last[0][0]==1) { // 增加一级缩进 
            fwrite($fp,'<img src="'.$imgjoin1.'"/>');
        } else {
            fwrite($fp,'<img src="'.$imgjoin.'"/>');
        }
        fwrite($fp,'<img src="'.$imgfile.'"/>');
        fwrite($fp,'
      </td></tr>
     </table>
    </td>
    <td width="900">
    <table width="100%" onmouseover="HL(this,self);" onmouseout="NL(this,self);">
        ');
        $mystat=stat($currentpath);
        if(($mystat['mode']&4)==4) { // other 有权限 r--
           fwrite($fp,'<tr>');
        } else {
           fwrite($fp,'<tr bgcolor="#ffdddd">');
        }
        fwrite($fp,'
    <td align="left" nowrap="noWarp">
        ');
        fwrite($fp,'<a href="'.$currenturl.'" target="_blank">');
        fwrite($fp,$onefile);
        fwrite($fp,'</a>');
        fwrite($fp,'
     </td>
     <td align="right" width="120" style="color:#C03000">
        ');
        $mysize=$mystat['size'];
        $mymtime=date('Y-m-d H:i:s',$mystat['mtime']);
        //$mymode=sprintf('%o' , $mystat['mode']);
        fwrite($fp,$mysize);
        fwrite($fp,'
     </td>
     <td width="15"> </td>
     <td width="170" nowrap="noWarp">
        ');
        fwrite($fp,$mymtime);
        fwrite($fp,'
    </td></tr>
    </table>
    </td></tr>
   </table>
        ');
    }
}

function empty_accdeny($fp,$ct,$val){
   global $imgempty,$imgline,$imgjoin1,$imgfile;
   fwrite($fp,'
  <table>
    <tr><td>
    <table>
    <tr><td nowrap="noWarp">
    ');
   showimg($fp,$ct);
   $last=array_slice($ct,-1,1);
   if ($last[0][1]-$last[0][0]==1) { // 增加一级缩进 
      fwrite($fp,'<img src="'.$imgempty.'"/>');
   } else {
      fwrite($fp,'<img src="'.$imgline.'"/>');
   }
   fwrite($fp,'<img src="'.$imgjoin1.'"/>');
   fwrite($fp,'<img src="'.$imgfile.'"/>');
   fwrite($fp,'
      </td></tr>
     </table>
    </td>
    <td width="900">'. $val .'
    </td></tr>
   </table>
   ');
}
            
function showimg($fp,$ct){  // 显示前导图 
    global $imgempty,$imgline;
    array_pop($ct);
    foreach ($ct as $v){
        if ($v[1]-$v[0]==1) {
            fwrite($fp,'<img src="'.$imgempty.'"/>');
        } else {
            fwrite($fp,'<img src="'.$imgline.'"/>');
        }
    }
}

function hidefile_sort($files,$f){
      $tmpfile=$files;
      foreach($files as $i => $v){
          if ($v[0]=='.' || strcmp('readme',$v)==0 || strcmp('wget-log',$v)==0 || strpos($v,'index.')===0 )
             unset($tmpfile[$i]); // 删除一个元素 
      }
      $tmpfile=array_values($tmpfile); // 重建下标 
      //sort($tmpfile,SORT_STRING);
      //$callback=create_function('$x,$y','$a=(is_dir("'.$f.'"."/".$y)-is_dir("'.$f.'"."/".$x)); if($a==0) return strcmp($x,$y); else return $a;');
      //eval('$callback=function($x,$y){ $a=(is_dir("'.$f.'/".$y)-is_dir("'.$f.'/".$x)); if($a==0) return strcmp($x,$y); else return $a; };');
      $callback=function($x,$y)use($f){ $a=(is_dir($f."/".$y)-is_dir($f."/".$x)); if($a==0) return strcmp($x,$y); else return $a; };
      usort($tmpfile,$callback);
      return $tmpfile;
}

function main(){
    $workdir=START_DIR;
    $tt=new MyClass();
    writefile($workdir,$tt);
}
function vars(){
    global $imgfolder,$imgfolder1,$imgempty,$imgline,$imgjoin,$imgjoin1,$imgfile,$imgbase,$imgminus,$imgminus1,$imgplus,$imgplus1;
    $p = ICON_PATH;
    $imgfolder = $p . 'folder.gif';
    $imgfolder1 = $p . 'folder1.gif';
    $imgempty = $p . 'empty.gif';
    $imgline = $p . 'line.gif';
    $imgjoin = $p . 'join.gif';
    $imgjoin1 = $p . 'join1.gif';
    $imgfile = $p . 'file.gif';
    $imgbase = $p . 'base.gif';
    $imgminus = $p . 'minus.gif';
    $imgminus1 = $p . 'minus1.gif';
    $imgplus = $p . 'plus.gif';
    $imgplus1 = $p . 'plus1.gif';
}
function csnwrite($s){
   global $WRITE_FILE_OR_OUTPUT;
   if(isset($WRITE_FILE_OR_OUTPUT) && $WRITE_FILE_OR_OUTPUT=='file') {
      echo $s;
   }
}
function getmicrotime(){ 
   list($usec, $sec) = explode(" ",microtime()); 
   return ((float)$usec + (float)$sec); 
} 

if (1) {
    vars();
    main();
}

