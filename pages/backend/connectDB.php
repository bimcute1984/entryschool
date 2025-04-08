<?php

	$regDB = '(DESCRIPTION =(ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.15.5)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = UBUREG)))';

	$regUser="ubudev";			//User for connect to the database

	$regPasswd="esubu";			// Password for connect to the database

	$ubureg = @oci_connect($regUser, $regPasswd, $regDB, 'AL32UTF8') or die("<Table align=center border width=\"70%\"><Tr><Td height=300 align=center bgcolor=ffeeee><font color=aa0000>Database Server is Error..! <br>Please contact Administrator..<br>ไม่สามารถติดต่อฐานข้อมูลได้ การเชื่อต่อล้มเหลว<br>กรุณาติดต่อผู้ดูแลระบบ</font></Td></Tr></Table>");

?>