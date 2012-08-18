<html>
<head>
		<title>The Israeli Birding Website - Photo album</title>
		<meta http-equiv="Pragma" content="no-cache"></meta>
		<meta name="Description" content=""></meta>
		<meta name="Keywords" content=""></meta>
			<meta name="default_language" content="en">
			<meta name="page_language" content="en">
                                                <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
			<link type="text/css" rel="stylesheet" href="/israbirding.css" />
			<script src="/israbirding.js"></script>
</head>
<?php

  include ("template1.html");
  
	$IMAGES_PER_PAGE = 15;


$REQ_URI = explode("?" , $REQUEST_URI);

$QUERY_STRING_ARR =explode("::", $REQ_URI[1]);


$FILE_NAME = $QUERY_STRING_ARR[0];
$PATH = $QUERY_STRING_ARR[1];
$IS_GALLERY = $QUERY_STRING_ARR[2];
$GALLERY_PAGE = $QUERY_STRING_ARR[3];


//Read list of Images from the gallry folder:
				$myFile = "gallery_images.txt";
				$fh = fopen($myFile, 'r'); 
				$DATA = fread($fh, filesize($myFile));
				fclose($fh);

				$Images = explode("\n", $DATA);
				$number_of_lines =  count($Images);
				//READ START LOCATION
				$ORIG_START_POINT =$GALLERY_PAGE;

				$START_POINT = (($ORIG_START_POINT * $IMAGES_PER_PAGE) -$IMAGES_PER_PAGE ) ;


//Find the Image in the DB

$CURRENT_LINE = getImageInArray($FILE_NAME);
$imageData = explode("||", $Images[$CURRENT_LINE]);


echo "<script>";
echo ";\nvar sImage = '", $PATH, $imageData[2], "'";
echo ";\nvar iCurrentLine =", $CURRENT_LINE ;
echo ";\nvar iItemNumber =", $GALLERY_PAGE;



if ($CURRENT_LINE == ($number_of_lines-1))
	{
		$bHaveNext = "false";
		$NextFileData = "";
	}
	else
	{
		$bHaveNext = "true";
		$NextimageData = explode("||", $Images[$CURRENT_LINE+1]);
		echo ";\nvar sNext = '" , $NextimageData[2] , "::" , $NextimageData[1], "'";
	}


if ($CURRENT_LINE == 0)
	{
		$bHavePrevious = "false";
		$PreviousFileData = "";
	}
	else
	{
		$bHavePrevious = "true";
		$PreviousimageData = explode("||", $Images[$CURRENT_LINE-1]);
		echo ";\nvar sPrev = '" , $PreviousimageData[2] , "::" , $PreviousimageData[1], "'";
	}


echo ";\nvar bHaveNext = ", $bHaveNext;//(iLocation == (iLen-1))? false : true;
echo ";\nvar bHavePrevious =", $bHavePrevious  ;// (iLocation == 0) ? false : true;
echo ";\n</script>";


function getImageInArray($FILE_NAME)
{
		global $Images;
		global $number_of_lines;
		$RETURN_LINE = -1;

	for($i=0; $i< $number_of_lines; $i++)
	{
		 $imageData = explode("||", $Images[$i]);
		 //Compare file name;
		if ($imageData[2] == $FILE_NAME)
			{
				$RETURN_LINE = $i;
			}
		
	}

return $RETURN_LINE;
}

?>
<style>
.image_title {background-color:#d9b683;border-bottom:2px ridge;padding-left:10px;padding-right:10px;}
</style>
<script language="JavaScript">
<!--


function gotoReport()
{
      self.location.href = "/gallery/index.php?pg=" +  iItemNumber;
}
//-->
</script>

<script>


function getPrevious()
{
if (bHavePrevious)
	{
		document.write("<b><a href='javascript:DisplayImage(false)'><span style='color: #D66F00;'>&laquo;</span>&nbsp;Previous&nbsp;Image</a></b>");
	}
}
function getNext()
{
if (bHaveNext)
	{
		document.write("<b><a href='javascript:DisplayImage(true)'>&nbsp;Next&nbsp;Image&nbsp;<span style='color: #D66F00;'>&raquo;</span></a></b> ");
	}

}


function DisplayImage(bFetchNext)
{
var sText = (bFetchNext) ? sNext : sPrev;
var sGalleryAdd =   "::GALLERY::" +iItemNumber;

	self.location.href="/photo_album/gallery.php?" + sText + sGalleryAdd;
}

</script>

<div style="height:85%;padding-top:40px;text-align:center;vertical-align:center;">
			<table style="border: 2px ridge;" cellspacing="0"  align="center">
				<tr>
				<td class="image_title"  style="font-size:11px;text-align:left;">&nbsp;</td> <!-- Location for Previous -->
					<td class="image_title" style="font-size:18px;text-align:center;"><?PHP echo $imageData[0], " <i style='font-weight:normal;font-size:14px;'>", $imageData[3] , "</i>"; ?></td>
				<td class="image_title"  style="font-size:11px;text-align:right;">&nbsp;</td> <!-- Location for Next -->
			</tr>
			<tr>
					<td style="background-color:#333333;margin:10px;padding:10px;text-align:center;" colspan="3">	
<script>document.write("<img src='"+sImage +"'>");</script>	
				</td>
			</tr>
			<tr>
				<td class="image_title"  style="border:0px;font-size:11px;text-align:left;">&nbsp;<script>getPrevious()</script></td> <!-- Location for Previous -->
					<td class="image_title" style="border:0px;font-size:18px;text-align:center;">&nbsp;</td>
				<td class="image_title"  style="border:0px;font-size:11px;text-align:right;">&nbsp;<script>getNext()</script></td> <!-- Location for Next -->				
			</tr>
			</table>
			<br/>			
			<a href="javascript:gotoReport()" style="font-size:12px;font-weight:bolder;">Back to gallery</a>	
						

</div>
<?php
  include ("template2.html");
?>