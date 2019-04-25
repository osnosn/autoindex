<?xml version="1.0" encoding="UTF-8"?>
<xsl:transform version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="/">
<html>
<head>
<title>
<xsl:call-template name="rootname"/>
</title>
<style>
table{border:0px;margin:0px;padding:0px;border-collapse:collapse;}
td{border:0px;margin:0px;padding:0px;font-size:12px;}
img{vertical-align: middle;border:0px;}
.out{
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #666666;
}
body {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 12px;
	color: #666666;
}
.cap{
}
.capAct{
	color: #000000;
	background-color: #FFEECC;	
}
.capHL{
	color: #FFFFFF;
	background-color: #003366;
}
</style>
<script>
function Display(rItems)
{
  child=document.getElementById('child'+rItems);
  img1=document.getElementById('img1'+rItems);
  img2=document.getElementById('img2'+rItems);
  //alert((img1.src));
  if ((child.style.display == "") || (child.style.display == "none")) {
    child.style.display = "block";
    img2.src=".DirTrees/folder1.gif";
    if(img1.src.match("1.gif$"))
       img1.src=".DirTrees/minus1.gif";
    else
       img1.src=".DirTrees/minus.gif";
  } else {
    child.style.display = "none";
    img2.src=".DirTrees/folder.gif";
    if(img1.src.match("1.gif$"))
       img1.src=".DirTrees/plus1.gif";
    else
       img1.src=".DirTrees/plus.gif";
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
    <tr align="top">
      <td width="100%" align="top">
         <xsl:apply-templates select="root"/>
      </td>
    </tr>
  </table>
  <br/>
</body>
</html>
</xsl:template>

<xsl:template name="rootname">
  <xsl:value-of select="root/@caption"/>
</xsl:template>

<xsl:template match="root">
  <div>
      <table>
        <td><img src=".DirTrees/base.gif"/></td>
        <td><xsl:value-of select="@caption"/></td>
	<td width="40"></td>
        <td bgcolor="#5389BC" width="20"></td>
        <td bgcolor="#5389BC"><span onclick="Expand(true)" style="padding:5px;color:#FFFFFF;cursor:pointer;">Expand</span></td>
        <td bgcolor="#5389BC" width="30"></td>
        <td bgcolor="#5389BC"><span onclick="Expand(false)" style="padding:5px;color:#FFFFFF;cursor:pointer;">Minimize</span></td>
        <td bgcolor="#5389BC" width="20"></td>
      </table>
    <xsl:apply-templates/>
  </div>
</xsl:template>

<xsl:template match="file">
  <table>
    <td>
    <table>
    <td nowrap="noWarp">
    <xsl:call-template name="loop">
      <xsl:with-param name="mynode" select=".."/>
    </xsl:call-template>

    <xsl:choose>
    <xsl:when test="node()">
      <xsl:choose>
      <xsl:when test="count(./following-sibling::file)=0">
        <img id="img1{@id}" src=".DirTrees/plus1.gif" onclick="Display('{@id}');"/>
      </xsl:when>
      <xsl:otherwise>
        <img id="img1{@id}" src=".DirTrees/plus.gif" onclick="Display('{@id}');"/>
      </xsl:otherwise>
      </xsl:choose>
      <img id="img2{@id}" src=".DirTrees/folder.gif" onclick="Display('{@id}');"/>
    </xsl:when>
    <xsl:otherwise>
      <xsl:choose>
      <xsl:when test="count(./following-sibling::file)=0">
        <img src=".DirTrees/join1.gif"/>
      </xsl:when>
      <xsl:otherwise>
        <img src=".DirTrees/join.gif"/>
      </xsl:otherwise>
      </xsl:choose>
      <img src=".DirTrees/file.gif"/>
    </xsl:otherwise>
    </xsl:choose>
    </td>
    </table>
    </td>

    <td width="900">
    <table width="100%" onmouseover="HL(this,self);" onmouseout="NL(this,self);">
  <xsl:choose>
  <xsl:when test="node()">
    <td align="left">
    <span> <xsl:value-of select="@caption"/> </span>
    </td>
    <td width="170"><xsl:value-of select="@mtime"/></td>
    <td width="40">
    </td>
  </xsl:when>
  <xsl:otherwise>
    <td align="left">
    <xsl:value-of select="@caption"/>
    </td>
    <td align="right" width="120" style="color:#C03000">
    <xsl:value-of select="@size"/>
    </td>
    <td width="15">
    </td>
    <td width="170">
    <xsl:value-of select="@mtime"/>
    </td>
  </xsl:otherwise>
  </xsl:choose>
  </table>
  </td>
  </table>

  <xsl:choose>
  <xsl:when test="@id">
  <div id="child{@id}" style="color:black;display:none;">
    <xsl:apply-templates/>
  </div>
  </xsl:when>
  <xsl:otherwise>
    <xsl:apply-templates/>
  </xsl:otherwise>
  </xsl:choose>

</xsl:template>

<xsl:template match="endfile">
  <script>
function Expand(exp)
{
  for(i=1;i&lt;<xsl:value-of select="@count"/>;i++){
  child=document.getElementById('child'+i.toString());
  img1=document.getElementById('img1'+i.toString());
  img2=document.getElementById('img2'+i.toString());
  if(exp==true){
    child.style.display="block";
    img2.src=".DirTrees/folder1.gif";
    if(img1.src.match("1.gif$"))
       img1.src=".DirTrees/minus1.gif";
    else
       img1.src=".DirTrees/minus.gif";
  } else {
    child.style.display="none";
    img2.src=".DirTrees/folder.gif";
    if(img1.src.match("1.gif$"))
       img1.src=".DirTrees/plus1.gif";
    else
       img1.src=".DirTrees/plus.gif";
  }
  }
  return false;
}
  </script>
</xsl:template>

<xsl:template name="loop">
  <xsl:param name="mynode"/>
  <xsl:variable name="nodename">file</xsl:variable>
  <xsl:if test="name($mynode)=$nodename">
    <xsl:call-template name="loop">
	    <xsl:with-param name="mynode" select="$mynode/.."/>
    </xsl:call-template>
    <xsl:choose>
    <xsl:when test="count($mynode/following-sibling::file)=0">
      <img src=".DirTrees/empty.gif"/>
    </xsl:when>
    <xsl:otherwise>
      <img src=".DirTrees/line.gif"/>
    </xsl:otherwise>
    </xsl:choose>
  </xsl:if>
</xsl:template>
</xsl:transform>
