<!doctype html>
<html lang="en">
<html>
<head>
<title>ThaiCreate.Com PHP & Oracle Tutorial</title>
</head>

<body>
<?php
$objConnect = oci_connect("myuser","mypassword","TCDB");
$strSQL = "SELECT * FROM CUSTOMER";
$objParse = oci_parse($objConnect, $strSQL);
oci_execute ($objParse,OCI_DEFAULT);
?>
<table width="600" border="1">

<tr>
<th width="91"> <div align="center">CustomerID </div></th>
<th width="98"> <div align="center">Name </div></th>
<th width="198"> <div align="center">Email </div></th>
<th width="97"> <div align="center">CountryCode </div></th>
<th width="59"> <div align="center">Budget </div></th>
<th width="71"> <div align="center">Used </div></th>
</tr>
<?php
while($objResult = oci_fetch_array($objParse,OCI_BOTH))
{
?>
<tr>
<td><div align="center"><?php echo $objResult["CUSTOMERID"];?></div></td>
<td><?php echo $objResult["NAME"];?></td>
<td><?php echo $objResult["EMAIL"];?></td>
<td><div align="center"><?php echo $objResult["COUNTRYCODE"];?></div></td>
<td align="right"><?php echo $objResult["BUDGET"];?></td>
<td align="right"><?php echo $objResult["USED"];?></td>
</tr>
<?php
}
?>
</table>
<?php
oci_close($objConnect);
?>
</body>
</html>
