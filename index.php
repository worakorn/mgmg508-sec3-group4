<?php
    
    $found = 0;
    $database = "data.db";
    $db = new SQLite3($database);

    $id=$_GET['q'];
    $q1 = false;

    $smell = $_POST['smell'];
    $taste = $_POST['taste'];
    $clearly = $_POST['clearly'];

    
    $res = $db->query("SELECT id,nick,fname,lname FROM userinfo WHERE upper(id)=upper(\"$id\") limit 0,1");
    $result = $res->fetchArray();
    if($result[0])
    {
        $found = 1;
        $nick = $result[1];
        $fname = $result[2];
        $lname = $result[3];
    }
        //echo "FOUND ? [ $found ]";
    // check post with form values
    if(($_SERVER['REQUEST_METHOD']=="POST") && ($_POST['age']) && ($_POST['gender']) && ($_POST['alergies']) && ($_POST['cmd']=="register") && !($db->querySingle("SELECT distinct id FROM q1 WHERE upper(id)=upper(\"$id\")")))
    {
      if ($_POST['alergies']=="Yes") { $alergies = 1; } else {$alergies=0;}
      if ($_POST['pregnant']=="Yes") { $pregnant = 1; } else {$pregnant=0;}
      if ($_POST['supplement']=="Yes") { $suppl = 1; } else {$suppl=0;}
      
      if ($_POST['supplement_t'])
      {
        $n_sup = sizeof($_POST['supplement_t']);
        //print "N_SUP = $n_sup<br>";
        for ($i=0; $i<$n_sup; $i++)
        {
          $v_sup += $_POST['supplement_t'][$i];
        }
        //print "V_SUP = $v_sup<br>";
      }
      if ($_POST['purpose'])
      {
        $n_pur = sizeof($_POST['purpose']);
        //print "N_PUR = $n_pur<br>";
        for ($i=0; $i<$n_pur; $i++)
        {
          $v_pur += $_POST['purpose'][$i];
        }
        //print "V_PUR = $v_pur<br>";
      }
      $SQL = "INSERT INTO q1 VALUES(\"$id\",".$_POST['age'].",\"".$_POST['gender']."\",".$alergies.",".$pregnant.",".$suppl.",".$v_sup.",".$v_pur.");";
      //print $SQL;
      $result=$db->querySingle($SQL);
      ?>
      <pre>
      <?php // print_r($_POST); ?>
      </pre>
      <?php
    }
    if(($_SERVER['REQUEST_METHOD']=="POST") && (sizeof($_POST['clearly'])==1) && (sizeof($_POST['taste'])==1) && (sizeof($_POST['smell'])==1) && ($_POST['cmd']=="tasting") && !($db->querySingle("SELECT distinct id FROM q2 WHERE upper(id)=upper(\"$id\")")))
    {
      $SQL="INSERT INTO q2 VALUES(\"$id\",\"".$_POST['clearly']."\",\"".$_POST['taste']."\",\"".$_POST['smell']."\");";
      $result=$db->querySingle($SQL);
    }

    if ($db->querySingle("SELECT distinct id FROM q1 WHERE upper(id)=upper(\"$id\")"))
    {
      $q1=true;
    }
    else
    {
      $q1=false;
    }

    
    if ($db->querySingle("SELECT distinct id FROM q2 WHERE upper(id)=upper(\"$id\")"))
    {
      $q2=true;
    }
    else
    {
      $q2=false;
    }
?>
<?php

function Form2()
{
  global $id,$smell,$taste,$clearly;
  
  //print "ID = $id, SMELL = $smell, CLEARLY = $clearly, TASTE = $taste";
?>
<div class="container">
    
    จากการทดสอบ Blind Tasting ของ เครื่องดื่มคอลลาเจน แบรนด์ A และ B ท่านคิดว่า ยี่ห้อใด ดีกว่ากัน ในแต่ละหัวข้อ ดังนี้
    <p>
    1. ความใสของเครื่องดื่ม
    <form method=post action="<?php echo $_SERVER['REQUEST_URI'] ?>" class=was-validate>
      <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="clearly" id="exampleRadios1" value="A">
      <label class="form-check-label" for="exampleRadios1">
        A
      </label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="clearly" id="exampleRadios2" value="B">
      <label class="form-check-label" for="exampleRadios2">
        B
      </label>
    </div>
    <p>
    <p>
    <p>
    2. กลิ่นของเครื่องดื่ม
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="smell" id="exampleRadios3" value="A">
      <label class="form-check-label" for="exampleRadios3">
        A
      </label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="smell" id="exampleRadios4" value="B">
      <label class="form-check-label" for="exampleRadios4">
        B
      </label>
    </div>
    <p>
    <p>
    <p>
    3. รสชาติของเครื่องดื่ม
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="taste" id="exampleRadios5" value="A">
      <label class="form-check-label" for="exampleRadios5">
        A
      </label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="taste" id="exampleRadios6" value="B">
      <label class="form-check-label" for="exampleRadios6">
        B
      </label>
    </div>
    <p>
    <p>
    <p>
    <div class="form-check form-check-inline">
  <input type="hidden" class="form-check-input" id="control-value" name=cmd value="tasting">
</div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
<p>
<p>
<p>
<?php
}

function Form1()
{
  global $nick,$fname,$lname,$id; 

  if(preg_match("/^Mr\.\ /","$fname"))
  {
    $gender="M";
  }
  else
  {
    $gender="F";
  }
?>
<div class="container">
    
เราขอทราบข้อมูลบางอย่าง เพื่อใช้เป็นข้อมูลในการศึกษา
<form method=post action="<?php echo $_SERVER['REQUEST_URI'] ?>">
    <div class="form-group">
        <label for="exampleFormControlSelect1">คุณ <?php echo $nick; ?> อายุประมาณเท่าไร </label>
        <select class="form-control" id="exampleFormControlSelect1" name="age" require>
        <option value=1>20 - 25</option>
        <option value=2>26 - 30</option>
        <option value=4>30 - 35</option>
        <option value=8>36 - 40</option>
        <option value=16>40 ขึ้นไป</option>
    </select>
  </div>
  <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="gender" id="exampleRadios1" value="M" <?php if($gender=="M") echo "checked"; ?>>
  <label class="form-check-label" for="exampleRadios1">
    ชาย
  </label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="gender" id="exampleRadios2" value="F" <?php if($gender=="F") echo "checked"; ?>>
  <label class="form-check-label" for="exampleRadios2">
    หญิง
  </label>
</div>
<p>
<p>
คุณแพ้อาหารใด ๆ ดังต่อไปนี้หรือไม่ [ นมวัว ไข่ ถั่ว เนย งา กุ้ง อาหารทะเล ]
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="alergies" id="exampleRadios4" value="Yes">
  <label class="form-check-label" for="exampleRadios4">
    มีอาการแพ้
  </label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="alergies" id="exampleRadios5" value="No" checked>
  <label class="form-check-label" for="exampleRadios5">
    ไม่มีอาการแพ้
  </label>
</div>
<p>
<p>
คุณอยู่ในภาวะตั้งครรภ์หรือให้นมบุตรหรือไม่
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="pregnant" id="exampleRadios7" value="Yes">
  <label class="form-check-label" for="exampleRadios7">
    ใช่
  </label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="pregnant" id="exampleRadios8" value="No" checked>
  <label class="form-check-label" for="exampleRadios8">
    ไม่
  </label>
</div>

<p>
<p>
คุณทานอาหารเสริมหรือไม่
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="supplement" id="exampleRadios9" value="Yes">
  <label class="form-check-label" for="exampleRadios9">
    ใช่
  </label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="supplement" id="exampleRadios10" value="No" checked>
  <label class="form-check-label" for="exampleRadios10">
    ไม่
  </label>
</div>

<p>
<p>
ประเภทอาหารเสริมที่คุณรับประทาน
<div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox" name="supplement_t[]" id="checkbox1" value="1">
  <label class="form-check-label" for="checkbox1">
    โปรตีน
  </label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox" name="supplement_t[]" id="checkbox2" value="2">
  <label class="form-check-label" for="checkbox2">
    วิตามิน
  </label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox" name="supplement_t[]" id="checkbox3" value="4">
  <label class="form-check-label" for="checkbox3">
    คอลลาเจน
  </label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox" name="supplement_t[]" id="checkbox4" value="8">
  <label class="form-check-label" for="checkbox4">
    น้ำมันปลา/น้ำมันตับปลา
  </label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox" name="supplement_t[]" id="checkbox5" value="16">
  <label class="form-check-label" for="checkbox5">
    เครื่องยา/สมุนไพรจีน/รังนก/ถั่งเช่า
  </label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox" name="supplement_t[]" id="checkbox6" value="32">
  <label class="form-check-label" for="checkbox6">
    สารสกัดจากสาหร่าย
  </label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox" name="supplement_t[]" id="checkbox7" value="64">
  <label class="form-check-label" for="checkbox7">
    ซุปไก่สกัด
  </label>
</div>
<p>
<p>
คุณใช้อาหารเสริมเหล่านั้นเพื่ออะไร
<div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox" name="purpose[]" id="checkbox9" value="1">
  <label class="form-check-label" for="checkbox9">
    เสริมสร้างสุขภาพ
  </label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox" name="purpose[]" id="checkbox10" value="2">
  <label class="form-check-label" for="checkbox10">
    เสริมความงาม
  </label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox" name="purpose[]" id="checkbox11" value="4">
  <label class="form-check-label" for="checkbox11">
    เพื่อนแนะนำ
  </label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox" name="purpose[] " id="checkbox12" value="8">
  <label class="form-check-label" for="checkbox12">
    อยากลอง
  </label>
</div>
    <p>
    <p>
<div class="form-check form-check-inline">
  <input type="hidden" class="form-check-input" id="control-value" name=cmd value="register">
</div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

<?php
} 
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet"> 
<title>Welcome to the Party [CMMUxQtyCare]</title>
<style type=text/css>
body  {font-family: 'Kanit', sans-serif;}
</style>
</head>
<body class=body>
<p>
<div class="container">
    <div class="row">
        <div class="col-*-*">
            <img name=cmmu align=center src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKMAAABVCAYAAAAlp1SEAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAACqlJREFUeNrsXc112zgQhvftPdoKQl33IroCURVYriByBY5ve5N125vtCixXYLkCURWYvuzVTAVhKtgF/AarCUL8kYQEijPv8TkhIQAEPs58HwCCjJGRkZGRkZGRkZGRkZGRkZGRkZGRkZGRkZGRkZ2onfWlon/O/lrwP1N+JPxI+VHyo+LHCz/W/2z/rjzymkNeKRwjfuT8KPjxwPMqIY249hnKFNe+8WMjrnvWXeR1gerOID9R9w3cR6aUt4PzTuXxMrY1pz/uhx+Lmms5zzdv0hc/luP00+q9GBwYeSOLDnqGDtKZ6LQZb9zCIa9HBAhTfiPDddGJl7YHgJeXQXlJy/LW/LjRlQflbDW/20EdVJu1AONXDsb7rvv6tx4AcevQmaIjtzz9yOKdtg5AZBZgMPBiWwdP7lJ3l/IWlvJ09ySAONFca+PZJiH6O2owgkccOaYV6eYaYCTgHUYd1i0FwJk8MOu4vLknOAoNUEsfWlNjCfeOo8GAERo+8W0kzfllx0CUNtWcvwvULKnPeaAtmYZmhKrLSXrGCwNfWxm4V51XXGjS3zt0zAbEkhP4obzMUJ4tPK7r7qMBMHLgknX2RmDs5mafDL8pNPyuNi33HDfAq3Qmwtmlocy6384t5b2Y6s/TXIEC9uHVurqlAfiiK88dBBgLT1JuS/vZoppNaUqP0P1iue6SpuiinZqq6NAWJRgNT7vkQXXXKw0pTy1ezRRudjbv6gkOW3m2NLnHw5YH5IvJYMBo6gwYvkk8Qo8WSJCXERyG8ip1XNOQVuaVWMJbDg/iyEMBpwaP7dNOBMaOhipq+ZuBwJs8rIsa9fWKJcyiZBZ+Wnl6Rd3DZqp3K/HyYznOBhWmDR3yZmjk0sfDWrwmTuMMfgfgThxC9NQVREcSL+nQwJgFFi87BzFhS1N4iJedA/htHNaXn05dqEUDmxoe/tMCI/Aq77CpaeRDi4lg5WkUsEktp4H4YhYKjL/3ULwUjiHalpdNTBQ+YsKUnwCHib86pMk97s9U711LvjhH+RZDBmMBAJg5etjMJBQM87z/Cw7d3HNAr+gjlphh6CYUX5SzYuWn1XvVdcfHyBmdCXwL3tm5mHAI51MHsTTpQLy8MfPYYxubd5RPb8DY1VNtEy+msPnWoC7ThnnhND5h2gT+zIVaeIboBQrRuxAdH1WYBk6o410FhM2k5tptx2EzNw2Ia8REZuCepsFwmUbHOSvNSu+JLq3Ga7YN0dfo35sheEZbqBNLs5bKcaEBddJGTPioaEPIrCwD5y5pfMVLZokITbxihsrbhOCLMYIxa+A5vFbqBBITXYgXZ75oqF+owe4l+vdLqM6PDYymDtE18reOxYRNvOwa8FOXwXVnz2jwxLmurBbvu2SoblWoEB0jGHW8qmR+g89txESTmRCbF80cwN/VzEvXfBG/PrEOFaJ7wxnhqe5kjR+E+67FhGlw3TaXa+KwhUYBTwztkHQFRu4Vb5X8HkJ2fjRgNHWIoZF9ZkKqDlbq5B71tq3CcUlT+IgXQ713DYCYKApaeMVyEGC0eDOdOvbxUk5DOg3ExKH5qS7sv3UsXtS3KVehARATGJuIl50HXwwiJhyA2yk/bShevMAoXtJX2mAV2iv2xjN2PMzSWExoFKnNo9tWkms5rM9KJAMFyT2BKPLAr9oKGnF/CABED0YAwMSgsl2VrYuYKBy4K/ZStlkaGz/Nmf/K7sRwb61W6sCL+c/K6auQCjpmNf0L2AwdXvcOStpSTJQdeeHcwwv78sWpph7PHfBFdU8jMduyOVRnxzQ3Xbf5kWiY75r0D4HExMQDHFnDvHCduhAd2jl913y4V3xU7kf0x9UhARCTZ/R5AksNj2kjJpqs1LGVlzmU5yOWJEhcLXfZTg/GExfK6ctDhecYwbhybGiRRrcdXdZCTOQGMVF5vtbgs5LcRCtcI4KpTW1AFCBcqr/jQMwPDYBowAhP8IyZ360QDTQ2DFWEEhN14sUE3NLiFZu8BovreeX4wOYOQFR3SxM88fYYGIhqPSN00BjtGovDskvImRnCWsnsrywUmjSlJl9TebmhvApRE593emQ7rXkbifzlDrwj9DvBbTe2hbQaIBaH5onYerONMll3pgGiAO/40DwxSs+IOF0Fq7plGJQvR8nrBbxQpf4/A88wQo2bKOENDwGN8Hn5e9X72sqBuv6fRt6DuI7yThXliz2gqoRlOZgGqGUnhhAu76WW54JYWdZ5+WMCMSrPCKH5GRr7nB/v0EkzWJ29BY51L7aWQ+n/gCy+Q4i5hhApd7ItEFDE9nZbtt9Qfo7C93fgWRulXh9ehJ8/A4C8Q/o7yPcc8rkAwfAMf0WHjyGbVxAeS6hHhcTIHQKmrOcK6nkP9zyCe9vCtSkCfQnHAur1Berzyx7nMHyz0ACxODYGOhcwsNqjiUnvIX7/VVGdt3B9w/ZvqMkxw2e23+9aihC5DYr4CsIMOj2DjhD5n8M+iDds/8UDnXCYsl+nCbEHfIQhHnlOAGON1P0jXMs1giyB6yXKW3pKea+Xsmzxvg/ck0gjvswwg3vJ2X7P8nMMRDGzwo/XmIEYSk1nML/pa1M0drhEHZSy/TbIH1srQxhK2X4X20IJyzKU7cCbXSBvWSE1fM32c9+6tYoJ8mRf2M8LfSVI5vAATCGklpCv9J5X6Dc3UOcbdO4F6lDCtWu4fgXlLwHwOAyrY5FyyOcS3wf0xWvNSEFUQAwCRn5z6xpO4mo7aOB7qQqhY1YiTIqD/fyS+hPwpG/gjWT4reDvNfJMl0i9focOwupZeOAtHNiDiF1rxebu/wIwLuHvBsq+gbJkuS8IHB/qFIEjZz+/TJbAKMEa8q0QtViCpyvQGOwL4p25EoZHTPlmDKy+ea3hmGVsQAzGGYEkVyG+FULm1P4jeAjnuuGrY4uVQ4VpBp5t2TBck7UDYgbesA6I61iBGFRNg3cUHOs81ps/QW+4VMQfttWxZlaiGNrhDfQeyxjWiQNxDmKpbiTjY2rwGHPNsYRpaVJFbkN8UYlAOBZfqnpm+m8rCgCO+wDE4J4RhetlzMS5pyH5q2XU4qZvAvLsQI0nZ08IkO3bUoLQtJj2KrZhm5jA+PHVU7aftZj1sbGODMIF249NMg03fIhdpBwdjDWA7IW6iyQczy0gFLaBsFz2+X7PjtC4GJC9DSkH4oTXzLxavIT2y0/hvs+O1NDqR8jvwVNWAweh4NVibHZhSVpCe61P6f7Pjtjw6nKmD84jgDkkUMLDuQAvmFiS954XRglG6AjBh9Q9XU4elIgLXjD9J4FVTyjaZH3KD+pZBB0jvMEd08+lPp0CJ2oAQMmpH04tHEcLRsVL6qa0SlCMT30SO2jX1wvm9829k3kIewlG1IG3FhUpgCk6Sazty2MJW+D5UgDflFleVR1qKO4VGBuQegnONwhrRejOhKVxCYBvAn+TBln10uMPCow14fuLB8+SJkPcDnV86fF7vKvXBP6dMvO4HwHwlMGoCB0JzL4t2t3AQ5ETAE8AjDXAlMIg68BbdWkVog350ETI4MCo4XCYv2UHKlq+wYj5akmwGjAYLeo2QeJC3Z8xqREeeY2ne1N4Z0mgIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjI3O2/wQYALR1GTIV6rLmAAAAAElFTkSuQmCC">
        </div>
        <div class="col-*-*">
            <font size=30 color=2222FF>X&nbsp;&nbsp;&nbsp;</font>
        </div>
        <div class="col-*-*">
            <img name=qty height=100 align=center src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAANAAAAEICAYAAAAuvnqCAAAgAElEQVR4nO2df2hbV9rnv3Vv1WpiDb15G2lWO1ao7ryVZ53aZqJ3G5v6jc1Gf7jGeRtDFYhLTGq6DhMPZOuSthACLYW2mXYaSDLEDCY4JIaou06JST1U2bWDQ+wB5cVxY2oVrtnIXXWsLtXwysV9lQvZP7xXY1tXP67uPfdeyc/nr0SWzjm27vec5zzneZ7z2KNHjx6BYE48HkcqlUIsFsv8/6efftrwHlEUC7bjdDrhcDg2vObxeMBxHHieB8/z2LlzJziO02/wRE4eIwHpRyqVQiKRQDwex8rKCmKxWOY1o7Hb7XC73dixYwccDgc8Hg8cDgfcbrfhY6lkSEAaSCaTiEajWFxchCiKSKVSZg+pKARBgNfrhdfrhSAIZg+nrCEBqSCVSm0QTDKZNHtImuE4LiMoQRDg8XjMHlJZQQIqQDQaxfz8PBYXF00xxYzGbrfD6/XC5/Ohrq4ua79FbIQEpEA8HsfMzAzm5+fLxixjRV1dHRoaGrBr1y5yTChAAvr/JJNJzM7O4u7du1tipVELx3FobGxEQ0MDfD6f2cOxDFtaQKurq7h37x4ikUjGvUwUxuFwoLGxES+88AKcTqfZwzGVLSmgZDKJ27dvY3p6GpIkmT2cskYQBOzbt2/LevO2lICSySTC4TAikYjZQ6k43G43AoEA6urqzB6KoWwJAcXjcdy+fZuEYwButxutra1obGw0eyiGUNECisfjCIfDmJ+fN3soWw6e5xEIBOD3+80eClMqUkCJRAJjY2OIRqNmD2XLw/M82tvbK3ZFqigBSZKEcDiMqakpcg5YDEEQcODAgYrz2lWMgKLRKEZHRysivKaSaWtrQ2trK+x2u9lD0YWyF1AqlUIoFCJzrYxwOBzo6uqqCI9dWQtoYmIC4XCYzLUyxefzobOzs6zNurIUUCwWQygUopCbCoDjOLS0tKC9vd3soZRE2QloYmIC4+PjZg+D0BmPx4Oenp6yi/4uGwGtrq5iZGSE9joVjN1ux6FDh8oqWLUsBBSLxTA8PLzlUwu2Cm1tbWVj0lleQGSybU3KxaSzrIC2gsmWr8KOEpsr+Tx8+LCi0zDKwaSzpIDi8TiGhoYqwmRzOBxwOp2Z6jherzdTMUcv5Mo/33//PVKpFBYXF7G6uop4PK5bH2ZiZZPOcgKKRqMYGRnB6uqq2UMpCbfbDUEQ8Nxzz0EQBNPToOPxOERRxDfffANRFMv2zMzv96Orq8v0v+dmLCWg2dlZhEKhsvqSnU5npgiHvLpYmVgstkFQ5YTP50NPT4+lRGQZAU1NTWFsbMzsYRSF0+nE7t270djYCJ7nzR5OyUiShPv37+PevXtlk/LhdrvR19dnmYnKEgIaHx/HxMSE2cPIi91uR0NDA/x+f0XWTkulUpidncVf/vIXy0d4OJ1O9Pb2WmLyMl1AoVDI0pmiclmnSs1nUSKRSOD27duWLuvF8zx6enpML1VsmoAkScLw8LBl3dR+vx+BQMASs5xZSJKE6elpTE5OWlJIdrsdvb29ploEpgjIyuIh4WRjZSFxHIeenh7TzopMEdDw8LClNq0cx6GpqQmtra2WP/k2m0gkgnA4bKnERbvdjr6+PlPMOcMFZLU9j9/vR3t7OwlHJTMzMxgfH7fMeZ3D4UB/f7/hloOhAgqHwwiHw0Z1lxen04lgMFiRHjWjWF1dxdjYmGUmRJ7ncfz4cUNd3IYJaGZmBqOjo0Z0lRe73Y7W1la0tbWZPZSKIRaLYXR01BKhQ0afExkioPn5eQwPD7PupiB1dXXo6uoic40RExMTmJycNN2sMzJigbmAotEohoeHTQ3PcTgcCAaDlo7qrRRSqRRGRkZMDxNqbGzEoUOHmPfDVECJRALnz583dUYSBAGHDh2iVcdgrLDfbWlpQWdnJ9M+mAlIkiScOXPG1LCQQCCAQCBgWv9bHVEUMTIyYurZUU9PD9PyWcwEZKa72uFw4NChQ1v2yg0rYbZJZ7fbcfz4cWbubSYCikQiCIVCejdbFGSyWRMzTTqPx4OjR48ycSpU6d1gIpEwzV3t9/vR19dH4rEggUAAvb29puTyxGIxZnU1dBWQJEm4dOmSKR63trY2BINBw/slisfn8+Ho0aOm5PJMTU0xCR/TVUCjo6OmOA26urosmzNPbMTj8eDYsWOmBOuGQiHdY/h0E1AkEjHcacBxHA4dOoQ9e/YY2i+hDafTiaNHjxoe/Lm6uoorV67oaiHpIiAz9j1yLshWSnSrJHieR19fn+GeUr33Q7oI6Nq1a4bueziOM+WPT+iLPAka/T1OTU3pFrenWUCRSMRQH7+cQGV2Ki+hDxzH4fDhw4Z/n3ods2gSUCqVMrzsbldXF8W0VRh2ux09PT2GOhbi8TimpqY0t6NJQOFw2NAwja1w6/NWhed5w13cN2/e1Pz8liygWCyGmZkZTZ2rYc+ePRTXVuHIjgWjDlvlhEAtlCwgI71uch4PUfm43W5Dq4/Ozs5qKm5TkoD09GIUwul0oru725C+CGvg8/kMPRgfGxsr2YusWkBGOg5kD42VaiETxtDS0mLYLd6JRKLkyriqBWTkrdhdXV1lfYMzoY1gMGiYZ25iYqIkh4IqAaVSKcPCdfx+P3nctjh2ux3d3d2GWCCSJGFyclL151QJaHJy0pDVx+PxkNOAALD2LBi1H5qenlZdfqBoAaVSKUxPT6selFqMnHWI8sCo/ZAkSaotrKIFZNTq09nZSXWpiSyMKkem9jkvSkClKLMUPB4P7XsIRRwOhyEH6WotraIEVIptqBaO42jfQ+Rlz549hpRiVrMKFRRQqd4JtTQ1NVGENVEQIyZZNatQQQFNT08zDxh1OByUkk0UhdvtRktLC/N+7t69W9T7Cgro9u3bmgdTiM7OTvK6EUWzb98+5g6FeDxeVBGSvAISRZH5RUo+n4/SsglV2O125iV7AeDevXsF35NXQMU0oBUy3YhSaGxsZL5nvn//fkHnWU4BSZLEXEB1dXXkOCBKhrVbuxgN5BRQMerTCiXIEVowYgIudP6ZU0DFeiFKRRAEWn0Izbz44otM24/FYnmLhSoKKJVKMb+CnvUvTmwNGhsbmXvk8plxigKanZ1lNhhgzZdvVLIUUdlwHIfW1lamfeQz4xQFxNp8o70PoSdNTU1MV6FkMpmz9mGWgBKJBNN6BzzP0+pD6ArHcczro+daVLIExHrvQ9HWBAtYP1dFr0DffPMN04GQgAgW8DzPtMZ2MplUjMrZICBJkpjWufZ4PJQsRzCjoaGBafv379/Pem2DgB48eMA065RWH4IlDQ0NTIOSFxcXs16rKvQGveA4jvkMQWxt7HY7du3axax9UwW0a9cuU+7GJLYWu3fvZtb26upqloc6IyBJkvDgwQNmndPqQxiBz+djOlFv9hFkDEbW+x+v18usbSI/04spLP7fn3Rts8nrgPeZp3RtUy+8Xi+TG7mBNSttfUYst/4HrBAEgcw3E5n53ysIf/03Xdt0/vwJywrI5/MxFdB6MiYcywNUWn0II2F5g+HmfVBGQN9//z2zTklAhJHwPM/0vDEWi2X+XQWspS+wSp7jOA47d+5k0jZB5IJ1VIJMFYC8CUNa2blzJ1XcIQyHpdWzXi9VAJlvROXBcgVarxfmAjKiFCtBbIbneWY5Qj/88EPm31WbX9AbumGOMAtWz54kSRkzjukKxHEcRV8TprFjxw5mbcuOhKr1atIbWn0IM2EpoMwKxNJ8o9WHMJPt27cza1u22qpYOhBoBSLMhOUKlBEQy+qjtAIRZsJyBZIttyqWty9Q5VHCTDiOY24FqbrmXi1GXApLEPlg9QzKl85V/fSTvnki63nqKWuGuxNbB1bPoJw7x3QPRDlAhNmwfgarWGWhUgApYQVYP4dVrC4Qpv0PYQVYP4dMnQgEUenQCkRUNMxXoIcPHzJp+IknnmDSLkGogfkeiGnrBFHhkIAIQgNVrEwtVqYhQaiBZbFQAKhiHepAEGbC+jkkE44gNEArEFHRsMw2AIAqVm4+1rYnQViBKpbBdiwDVQmiGJjvgVimHLBMlSCIYmDuhWPZOO2DCLNhbQVVsaxbsPk6PIIwGlYl22TdMN0DsfaAEEQ+EokEMxNOLlhSZUTxOYIwA5Yl22TdVLEs/UMrEGEmLCfwjAnHsvQPrUCEmXz33XfM2s4ICGBXwVGSJFqFCNNgOYHLi04VwLaCI61ChFkYYsIBbGsIr7+QlSCMgqUHzm63Z8plcQBbAS0uLjJr2wqEF/6G/7nwb2YPIy9LyX/Xvc3//q8/WPr33v3LJ9HX18ek7fU5dBzA9haFBw8eQJKkiq0Tl/i3h5j7Pz+aPQzDWUr+OxNh6kV73dMQBBfzfqqAtcolrA5UJUnCgwcPmLRNEErYHn8Mfs82Q/rKxMKRGUdUCrW/+Bm2Pfm4IX1lBOTz+Zh1QgIijGTPs9WG9ZURkNfrZdaJKIqUG0QYRpPXuKKeGQHt3LmT6UafViHCCGr4J+FyGFfUMyMgjuOwc+dOZh3du3ePWdsEIfPPvzK2pPSGhDqWZtz9+/fJjCOYs9tj3P4HMFBAkiTRKkQwhf8Zh9pfGHup2wYBsd4HRSIRZm0ThH+nsasPsElAHMdBEARmncViMYrOJpjR/p+eNrzPrKIizz33HNMOaRUiWOB95inDzTdAQUAsD1QBEhDBhu5/esaUfrME5HQ64Xa7mXWYTCYxPz/PrH1i6+H6+ROGHp6uR7Eu3O7du5l2Gg6HmbZPbC3+pZ5dQmghFAXU2NjItNN4PE6rEKEL/M84vLSLXW3DQigKyOFwMN8L0SpE6MHef/w5bI8/Zlr/OUv7sjbj4vE4otEo0z6Iysb2+GN45Tf/YOoYcgpo165dzJLsZGZmZpi2T1Q2+379NPifmZvpnFNAHMehoaGBaefz8/NUP5somZfqjD843cxjjx49epTrh6IoYnBwkOkAPB4P+vv7mfax1fn0f32H8Nd/07XN//Zf/gMCteY9wJFIBKFQiGkfdXV16OnpyfuevNebCIIAlrc3AGvhPXS4SqghlUphfHyceT979uwp+J6C9wO9+OKLugwmH+Pj45TqQBTN+Pg487un3G53UZ7oggJqamoCq4uIZYyaUYjyJxqNGmKxtLa2FvW+ggLiOK7oxrQwMzNDDgUiL5IkYXR0lHk/DocDu3btKuq9RV3x2NTUxNylDYD5ppAob8LhsCHpMK2trUXnxRUlII7j4Pf7NQ2qGOLxOJ0NEYrE43FMTEww74fjOFWhbEVfMqxGlVq4fv063ehAZGGUdaJ2z1+0gBwOB5qamkoalBokScKlS5eYX09OlA8TExOG7I9L2e+ruubeqFUokUgYslkkrE8ymTQs8Li9vV21x1mVgBwOhyF7IWDtpJkOWLc2q6urGB4eNsQaKdXCUiUgAAgEAoZdVTI6Okr7oS2KJEkYGRkx7GijVOtKtYAcDgfa29tVd1QKtB/auly/ft2wdBee50ve36sWEAC0tLQwrZuwnkQigeHhYUP6IqzBxMSEoccZ+/fvL9mqKklAANDV1VXqR1UTjUbpkHWLMDs7a2hYlyAIqKurK/nzJQvI4/EUFa2qF5FIhNLAKxxRFA2dKDmOQzAY1NRGyQIC1hwKrANN1xMOhylSoUJJJBKG73cDgYDmdB1NAjLSoSAzOjpKFX0qjFQqhaGhIUNTWtxuN9ra2jS3o0lAAOD3+5nW01biypUrVJCkQlhdXcXQ0JChNdP1MN1kNAsIAA4cOGDoNfaSJGF4eJhEVOYkk0kMDg4ansaipxdZFwE5nU5DvXLAmoiGhoYoWqFMicfjuHDhguHicTqdCAQCurWni4CANVOOdUVTJUKhEKampgzvlyidaDSKwcFBw6+64TgOhw8f1tVa0k1AwJopx7oIiRJjY2OUEl4mRCIRwx0GMl1dXXA6nbq2qauA7HY7uru7Dd0PyUxMTNBhq8UZHx837Tvy+/1MAqF1FRCwdsBqtGtbJhKJ4Ny5c8wrthDqkANDjcgoVYLlHl13AQFrXg4t4RFaiMVi+Pjjj8lDZxFkN/Xs7Kwp/bPY96yHiYAAIBgMmrIfAv7+pY2Pj1Mkt4nEYjGcP38eoiiaNobt27czjZZhJiAz90MyExMTuHDhAl1sbDCSJGF8fBznzp0zPZ8rkUhgZGSEWfvMBASs7YcK1RZmTSwWw5kzZ0wzIbYa0WgUH3zwgWn7HSWi0SjGxsaYtM1UQMDapcV6hU2UyurqKkZGRjA0NGT6jFiprK6uIhQKYWhoyJJOnKmpKSaByIbYV36/39DiELmIRqMQRREtLS2GpqZXOpFIxJB61Vq5fv06duzYoWvsJvMVSCYQCKClpcWo7nIiSRImJibw+9//njx1GpGjqEOhkOXFA/y9RICee+K89wOxYGRkxFL7EZ/Ph66uLtM8hkag9/1AtscfQ3dtGvcn/kdZ3qrhdDpx7NgxXcpVG7YCyQSDQeYXGKtB3vSGQiHaHxVg25OPo/ufnsHFw7/Co8RCWYoH0NczZ7iAOI5DT0+PYUVJiiUSieDjjz/G8PAw3RKxCdfPn8B/fdGFK0f+Ed3/eYfp95LqgV6eOVP+EhzHoa+vD5cuXTL1kE2J+fl5zM/Po66uDoFAwHJCNxLvM0/hXxp4U69yZMnU1BR27NihqbaHaVOJ3W5Hb28vrly5YskUbVlIgiBg9+7dqKurM+SKFytQ/x+34ZXfbMduT7XZQ2GOVs+c4U4EJUZHRy1fLITjOOzatQu7d++21B6uGIpxItTwT2K3Zxva655GDf9kwTZDoVDFJDPa7XYcP368JEeSJYzZrq4uOBwO08+J8iFJEmZnZzE7OwuHw4HGxka88MILuueXGEntL+z451/9HLs924oSTaUix06W4pmzhICAv5cYKoecnlQqhampKUxNTcHhcMDn88Hr9Rpyq7kWbI8/hiavA7/xbEPzsw5se/Jxs4dkGWTPXG9vr6rPWcKEW8/8/DyuXLlStlHUPM9vEJSRdfM2k0wm8cMPP2AhyWH79u1o8uo3lkoy4dbT0tKCzs7Oot9vOQEBaxUqL126VLbnDJvxeDxwOBxwu93geR48z2Pnzp26hRLJQllcXEQymUQymdzg3QwGg7pnY1aqgIC1LUWxnjnLmHDrEQQBb775JoaHhxGLxcwejmbk30HJ2+hwOLL2UTt27NiwckmSlPV3SCQSZRE+U46o8cxZUkDA2oPV39+P8fFxS4XG600qlcoSgtXOxrYacsxcMZ45wyMR1NLe3o7e3t4tcwZDWAPZM1doG2F5AQFrAZ9vvvkmPB6P2UMhGGK32xEMBtHf32+JVJNiYubKQkDA3006PQqCE9ZDniT9fj88Ho/pSZgyhWLmzJe5Strb2+H1essmB4XIj8PhUIzQb2xsxHfffWeJ/e/U1BSefvppxXy2slmB1uPz+fDOO++gra3NEks9URp+vx9vvvlmztCo9vZ208qjbWZsbEwxAbMsBQSsxaa1t7fj+PHjhl+vQmjD6XSir68PwWCwoHOou7vbMuFSIyMjWTljZSsgmfVfhpmn/kRxtLW1qZr0OI6zjBdWyTNX9gKSkc0BK9RdILLxeDzo7+9He3u7arOb53mm1UXVkEwmN1xFWTECAtbcoJ2dnejv7yezziK43W709PSgv79f0zGEIAjYv3+/jiMrHVEUcf36dQBl6IUrBo/Hg76+PoiiiJs3b9LJvgl4PB60tbXp6gTYs2cPvv/+e0vcBzUzM4Ourq7KFJCMIAgQBAGiKOL27duWzHytNARBwL59+5hZAJ2dnYjH46ZPivJqWtECkpGFFI/HEQ6HSUgM8Pl8aG1tNcR0Pnz4MM6cOWNazfPGxsbMQe+WEJCMbI8nEglMTk5WbDi+kZhRfEWup3H+/HnDU17a2to23H9lyXwgo0gmk5idncXdu3cruiYci3ygSCQCt9ttatWiaDSKoaEhQ/riOA7BYDDrHuAtLaD1xONxzMzMYH5+vuJChFgIyCpMTU0xu3lBxuFwoLe3V3GyIAEpMD8/j3v37lmqBLEWKllAANvsWPmKnlyH9CSgPKyuruLevXuYn5+HKIplW6eh0gUkSRIuXLige/bynj17sH///rwHuCQgFcRiMYiiiG+++cZ0N6oaKl1AwFpm77lz53TxzHEch66urqL+ZiQgDUSjUSwuLkIURUvXbtgKAgLW9rHnzp3TZCnwPK+qdjsJSCdWV1cRj8czVXFisRhSqZTpheoFQUBra2vZVVMtlfn5eQwPD5f0WUEQcPjwYVWBqyQgA5Ar6CwuLuKnn37aIKpUKqXJhS5X9ZHLZbndbjz11FO6ls0qN8LhsOoqt2rrwcmQgCyIUskqpfJXRG6Gh4eLijiR6zCUGrNHAiIqEkmScO7cubwmtMfjQXd3t6ZyzCQgomJJJpM4d+6c4sF4S0tLSblJmyEBERVNLBbDhQsXMp45u92OQ4cO6eZUIQERFU8kEkEoFCoYVVAKJCBiSyBf26k3JCCC0EBF1UQgCKMhARGEBkhABKEBEhBBaIAERBAaIAERhAZIQAShARIQQWiABEQQGiABEYQGSEAEoQESEEFogAREEBogARGEBkhABKEBEhBBaIAERBAaIAERhAZIQAShARIQQWiABEQQGiABEYQGSEAEoQHD7r9IJpO4c+cOpqenIYpi5iax6upqeL1eCIKAffv2QRCEotss5RqLXAiCgL6+PszNzeHy5cuK7xkYGIDL5Sq6zTt37uDzzz/Pet1ms+Htt99GdXV1yeNdXl5GJBLBV199hb/+9a9YWFgAANTU1KC+vh7PP/88GhoaNBVOB5R/h1Iv7FLzfcnPRX19PWpqaor6PeQKpFpQ+7sxF9DKygo+++wzXLt2Del0WvHnc3NzmJubw7Vr11BbW4ujR4+itra2YNvLy8uYm5vTdbz19fUAoNjuJ598gtOnTxfVzsrKCs6ePat45eCRI0dKFs/y8jIuX76c80FcWlrC0tISbty4AQA4cOAAgsFgyUK6cuVK1nWWNputJAGp/b7u3LmT+ffBgwfR3d0Nm82W8/3JZFLz8xAIBFS9n6kJt7CwgNdffx1Xr15VFE+uzxw/fjznKmAEAwMDil/U3Nxc5sEsxODgoKJ4amtrcfDgwZLGNTc3h2PHjqlada9du4bXX38dk5OTqvsTRVHxLthIJGL4HbFXr17FsWPHLHc3LTMBRSIRnDhxouRLXy9fvowPP/ywaOHpicvlQl9fn+LPcgljPZFIRPEht9lsGBgYKGlMN27cwIkTJ7CysqL6sysrK/jwww9x9epVVZ/77LPPcv7s5s2bqsehlaWlJdOeiVwwEdDCwgLee+89zb/o5OQkzp49q9Oo1NHR0ZEx59aTTqfxySef5PxcOp3OOebu7m7U1NSoHsvg4KAuf4evvvqq6PfKe9Zc3Lhxw5QHeWlpSfM+R0903wMtLy/j3XffzfvHFQQBtbW14HkeCwsLWFhYyDmzhsNh1NbWoqOjI+tnr776Kl599VXFz12+fDnLDKyvry96DwOsmXKvv/561u8irzBK9vLFixexvLyc9XqpptudO3dw7dq1nD+vqanB3r17wfM8tm3bhm+//TbjYFi/UrpcLrz99ttF9/vll1/m/Q7T6TRu3LiBAwcOFN2mErm+k7m5Ody6dUvRZA6FQnj55ZeL3kf++c9/1jTGfOguoHwmjt/vx8DAgOKGNhwO4+zZs4pf2uDgIJqbmzV7lNQim3JKs//g4CD8fv+GMS0sLCg+7KWabvlWs5qaGgwMDOR1tty5cycj6FOnTqlyXCh5Dzdz8+ZNzQLKRX19Perr61FbW5u14qfTaXz77bdFOZpYo6sJJ4pizmW/r68P77//fk4RBAIBnD9/XtHESafTpi3buUy5lZWVDV9sPtOuVNPtypUripORy+XCp59+WvABam5uxvnz53H69GlVxwN37twpau8qiiIikUjR7ZZCU1NTzr6tgK4CyrXpDAQCRc1UNTU1Oc2McDhs2ubxnXfeUZy91zsLQqEQlpaWst4jCEJJs/Ty8nJO0y3XeJSw2WyqZ+ovvvgi67WamhrFSUDpvUZgFUeCbgJKp9OKs1F1dTVee+21otsRBAGtra1Zr6+srGQOC42G5/m8XrlcB3g2mw1vvPFG3rOLXOSaMA4ePMjUdFlaWlL8Hl966SW89NJLWa8Xu1qVSi6XvZoVlSW67YFyOQICgYDqvcsrr7yieG4xPT2taE4ZQSAQwK1bt7IerpWVFZw8eVLxM8FgsOQvOteB4CuvvFJSe8WitKLYbDYEAgE8fPgQFy9ezBL2559/jiNHjug6jpWVFXz++eeK54E2mw1er7fotoo5XHW5XKqiTGR0E5CS5wkAfvnLX6puK9d+QclEMhLZK1fMWYwgCAgGgyX3tbi4mPWay+XSFP5TiHQ6rTjjBwKBTL979+7Nes+XX35ZMEogF3JkhcyPP/4IURSxsLCQ00zr7u5W9Xc4ceJEwffk8+jmg7mASjE3bDYbBEHI2iiWcoioJ7Ipl+8cCNBmugFrD7LS78rabAmHw4r9rjfdOjo6sgSUTCZx69Yt1WEwQLaAClFbW8vM81cKzKOxS50xt23blvXajz/+qHU4mgkEAgXjwLSYbgBy7ilKMTHUoGS+1dbWbvhdNv9fphi3t1aam5tx+vTpkicmFugmoCeeeELx9WLNruXl5Q2zn9JDVIormAUDAwM5JwatphuQWygsXbdzc3OK7b/88stZr+3bty/rtVxxc3rgcrkwMDCAU6dOWUo8gI4m3Pbt2xVfF0Wx4Iy9vLyMEydOoLq6Gh999FHmtc1YRUA8z6Ojo0MxtuzIkSO6fMkulyvrb6C0L9ILpRWE53k0Nzdnvd7R0ZHTmVBqrF8+Tp06pWlFL8bxVOrqrpuAcg3yq6++yhvCIooiTp48iWQyieXlZbz11lvYt2+f4gby2S1W4dwAAAOOSURBVGef1Wu4msm14uo1Q9bX12ftNVZWViCKou57oWQyqei6TiaT2L9/f9Ht3Lp1C6+99poqr6scypNOp/Hee+8pjuPkyZP44x//WHIkiprwLbXoZsK5XC7FFSISieSMThBFEW+99dYGc00URQwODiq+3yq+fyPINSHlCnfSgl6Boel0Gl9++WVJn7XZbDh16pSitZJMJvHBBx9oHR4TdHUiKNnGwNpho9YvqLm52TImnBHs3btX0axYWFhQHdaU76BTDgrVCy3OBFlESpOHmlwsI9FVQAcOHFBcZpeXl3Hs2LEsh4IgCPjoo4+K8tR1d3frNs5ywGaz5Yx+yJeRupmLFy/it7/9bc5jhs1R21oplAZRCJvNljNUaXBwMOfvYRa6Cshms+U8jFpaWsKxY8dw8eLFrJPhvXv35m23ubl5S5lvMs3NzYqbeGAtvfzkyZOKe4bl5WXcuHEjkw0sm0BKVgAL97PW+Die5/HGG29kvV4oF8sMdE9n6OjowN27dxVnoXQ6jatXr6rOjEyn00in05ZzYRpBX18fIpGI4sMfiUQyApLN21zHBgsLCzh79uwGL5koiophLgcPHiw6NEcp70pO+dYy6TU3NyMQCGSttHNzc5icnFSMl8w3xmJpampSNW4mRUXeeOONTHELPYhEInjvvfcseQ7AGpfLhdOnT+Pdd9/Na2qV8rfOlZatFDSai46ODsUH9ObNm5qtBnny2Px7y7lYxR7SqxGQy+VSNW4mkQjV1dX49NNPdQ38jEQi+MMf/qBbe+VEbW0tzpw5o+mBDAQCG1afXM4Dv9+v6kwk11mRHp69XJH8yWQSFy9e1NS2XjAL5amursb777+PgwcPql416uvrFWeXyclJy9nARuFyufDRRx/l3BPlorq6Gn19fVkHnLke8Fye1HwofUYv714gEFCMp7xx44Zp6S3rYRoLZ7PZcOTIEZw/f35DRG8u5EO106dPK3rneJ7PROtuRaqrq3Hq1CmcOXMGra2teSemmpoaHDhwAH/6058Ugy+VNvq5VpNC5Eq316tyz+9+9zvF180qOLOexx49evTIyA7n5ubw9ddf4+HDh5nX6uvrsW3btiwTRRRFfPHFF3j++efx61//WpVpsby8nOXyVOqjVJTaBwCv18s05WAzSmH/hSp5ptNpxdlby99naWkpZx08WehavpNc6Q3r208mk5r33cVWQZX5f+epwPYR5yjbAAAAAElFTkSuQmCC">

        </div>        
    </div>
</div>
<p>

<?php if ($found == 0 )
{
?>
<div class="container">
<div class="row">
  <div id="formContent">
    <!-- Tabs Titles -->

    <!-- Login Form -->
    <form class="was-validate">
    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="login" class="fadeIn second" name="q" placeholder="Enter your ID to access" required>
      <button type="submit" class="btn btn-primary">Let me in</button>
    </form>

  </div>
</div>
</div>
<?php }
      else
      {
?>
<p>
<?php //var_dump($data_arr); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <p>
            <?php print "ยินดีต้อนรับ คุณ $fname $lname ($nick) [$id]" ?>
            <p>
        </div>
    </div>
    <div class="row">
        <div class="col">

            <?php if ($q1 == false) 
                    { 
                      Form1(); 
                    } 
                    else
                    {
                      if (($q2 == false) and (date("YmdHis") > 20200811193000) )
                      {
                        Form2();
                      }
                    ?>


            Your invitation Card:
            <br>
            <?php
                
              $nameoncard = explode(" ",$fname);
                            
              echo "<img class=\"img-fluid\" src=/card.php?n=$nameoncard[1]&q=$id>";
            
                    }

            ?>
   
        </div>
    </div>
</div>
<?php } ?>
<p>
</body>
</html>


