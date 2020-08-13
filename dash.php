<?php
    $database = "data.db";
    $db = new SQLite3($database);

    $SQL = "SELECT count(id) FROM userinfo;";
    $allstd = $db->querySingle($SQL);

    $SQL = "SELECT count(id) FROM q1;";
    $q1num = $db->querySingle($SQL);

    $SQL = "SELECT count(id) FROM q2;";
    $q2num = $db->querySingle($SQL);

    $SQL = "SELECT count(id) FROM q2 WHERE clearly=\"A\";";
    $q2clearA = $db->querySingle($SQL);

    $SQL = "SELECT count(id) FROM q2 WHERE taste=\"A\";";
    $q2tasteA = $db->querySingle($SQL);

    $SQL = "SELECT count(id) FROM q2 WHERE smell=\"A\";";
    $q2smellA = $db->querySingle($SQL);

    $SQL = "SELECT count(id) FROM q2 WHERE clearly=\"B\";";
    $q2clearB = $db->querySingle($SQL);

    $SQL = "SELECT count(id) FROM q2 WHERE taste=\"B\";";
    $q2tasteB = $db->querySingle($SQL);

    $SQL = "SELECT count(id) FROM q2 WHERE smell=\"B\";";
    $q2smellB = $db->querySingle($SQL);

    $SQL = "SELECT count(id) FROM q1 WHERE pregnant=1";
    $q1pregnant = $db->querySingle($SQL);

    $SQL = "SELECT count(id) FROM q1 WHERE alergies=1";
    $q1alergies = $db->querySingle($SQL);


?>
<center><h1>Dashboard</h1></center>
<hr>
จำนวน อาจารย์ + นักศึกษาใน Class : <?php echo $allstd; ?>
<br>
คนที่ลงทะเบียนในระบบแล้ว จำนวน: <?php echo $q1num; ?>
<br>
ผู้ที่อยู่ในสภาวะตั้งครรภ์ / ให้นมบุตร จำนวน : <font color=red><b><?php echo $q1pregnant; ?></b></font>
<br>
ผู้มีความเสี่ยงในการแพ้อาหาร จำนวน : <font color=red><b><?php echo $q1alergies; ?></b></font>
<br>

คนที่ทำ Blind Tasting แล้ว จำนวน: <?php echo $q2num; ?>
<p>
สรุปผล Blind Tasting
<br>
<table border=1>
    <th>ประเด็นทดสอบ</th><th>Brand A</th><th>Brand B</th>
    <tr></tr>
    <td>ความใสของเครื่องดื่ม</td><td align=center><?php echo $q2clearA; ?></td><td align=center><?php echo $q2clearB; ?></td>
    <tr></tr>
    <td>กลิ่นของเครื่องดื่ม</td><td align=center><?php echo $q2smellA; ?></td><td align=center><?php echo $q2smellB; ?></td>
    <tr></tr>
    <td>รสชาติของเครื่องดื่ม</td><td align=center><?php echo $q2tasteA; ?></td><td align=center><?php echo $q2tasteB; ?></td>
    <tr></tr>


</table>
