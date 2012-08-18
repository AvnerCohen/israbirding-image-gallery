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


$REQ_URI = explode("?" , $_SERVER["REQUEST_URI"]);
$QUERY_STRING_ARR =explode("::", $REQ_URI[1]);


$FILE_NAME = $QUERY_STRING_ARR[0];
$PATH = $QUERY_STRING_ARR[1];
$REQUESTED_CATEGORY = $QUERY_STRING_ARR[2];


//Read list of Images from the gallry folder:
				$myFile = "../gallery/gallery_images.txt";
				$fh = fopen($myFile, 'r'); 
				$DATA = fread($fh, filesize($myFile));
				fclose($fh);

				$all_Images = explode("\n", $DATA);

				$all_number_of_lines =  count($all_Images);


				$Images = Array();//Create a specific, minimized Category Array
				for ($x=0; $x < $all_number_of_lines; $x++)
				{
						$imageData = explode("||", $all_Images[$x]);
						if (trim($imageData[8]) == $REQUESTED_CATEGORY)
							{
								$Images[] = $all_Images[$x];
							}
				}

				$number_of_lines =  count($Images);


//Find the Image in the DB

$CURRENT_LINE = getImageInArray($FILE_NAME);
$imageData = explode("||", $Images[$CURRENT_LINE]);


echo "<script>";
echo ";\nvar sImage = '", $PATH, $imageData[2], "'";
echo ";\nvar iCurrentLine =", $CURRENT_LINE ;
echo ";\nvar sCategory = '", $REQUESTED_CATEGORY ,"'";





if ($CURRENT_LINE == ($number_of_lines-1))
	{
		$bHavePrev = "false";
		$PrevFileData = "";
	}
	else
	{
		$bHavePrev = "true";
		$PrevimageData = explode("||", $Images[$CURRENT_LINE+1]);
		echo ";\nvar sPrev = '" , $PrevimageData[2] , "::" , $PrevimageData[1], "'";
	}


if ($CURRENT_LINE == 0)
	{
		$bHaveNext = "false";
		$NextFileData = "";
	}
	else
	{
		$bHaveNext = "true";
		$NextimageData = explode("||", $Images[$CURRENT_LINE-1]);
		echo ";\nvar sNext = '" , $NextimageData[2] , "::" , $NextimageData[1], "'";
	}


echo ";\nvar bHavePrev = ", $bHavePrev;//(iLocation == (iLen-1))? false : true;
echo ";\nvar bHaveNext =", $bHaveNext  ;// (iLocation == 0) ? false : true;
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
      self.location.href = "/gallery/index.php?ct=" +  sCategory;
}
//-->
</script>

<script>


function getNext()
{
if (bHaveNext)
	{
		document.write("<b><a href='javascript:DisplayImage(false)'><span style='color: #D66F00;'>&laquo;</span>&nbsp;Next&nbsp;Image</a></b>");
	}
}
function getPrev()
{
if (bHavePrev)
	{
		document.write("<b><a href='javascript:DisplayImage(true)'>&nbsp;Previous&nbsp;Image&nbsp;<span style='color: #D66F00;'>&raquo;</span></a></b> ");
	}

}


function DisplayImage(bFetchPrev)
{
var sText = (bFetchPrev) ? sPrev : sNext;
var sGalleryAdd =   "::" + sCategory;

	self.location.href="/photo_album/gallery-image.php?" + sText + sGalleryAdd;
}

</script>

<div style="height:85%;padding-top:40px;text-align:center;vertical-align:center;">
			<table style="border: 2px ridge;" cellspacing="0"  align="center">
				<tr>
				<td class="image_title"  style="font-size:11px;text-align:left;">&nbsp;</td> <!-- Location for Next -->
					<td class="image_title" style="font-size:18px;text-align:center;"><?PHP echo $imageData[0], " <i style='font-weight:normal;font-size:14px;'>", $imageData[3] , "</i>"; ?></td>
				<td class="image_title"  style="font-size:11px;text-align:right;">&nbsp;</td> <!-- Location for Prev -->
			</tr>
			<tr>
					<td style="background-color:#333333;margin:10px;padding:10px;text-align:center;" colspan="3">	
<script>document.write("<img src='"+sImage +"'>");</script>	
				</td>
			</tr>
			<tr>
				<td class="image_title"  style="border:0px;font-size:11px;text-align:left;">&nbsp;<script>getNext()</script></td> <!-- Location for Next -->
					<td class="image_title" style="border:0px;font-size:18px;text-align:center;">&nbsp;</td>
				<td class="image_title"  style="border:0px;font-size:11px;text-align:right;">&nbsp;<script>getPrev()</script></td> <!-- Location for Prev -->				
			</tr>
			</table>
			<br/>			
			<a href="javascript:gotoReport()" style="font-size:12px;font-weight:bolder;">Back to gallery</a>	
						

</div>
<?php
  include ("template2.html");
?>