#!/bin/bash
DATAPATH=/usr/share/nginx/html/cmmu/
REGCOUNT=`echo "select count(*) from q1;" | sqlite3 $DATAPATH/data.db`
NREGCOUNT=$REGCOUNT
REGCOUNT=`echo $REGCOUNT | sed 's/1/1️⃣/g'`
REGCOUNT=`echo $REGCOUNT | sed 's/2/2️⃣/g'`
REGCOUNT=`echo $REGCOUNT | sed 's/3/3️⃣/g'`
REGCOUNT=`echo $REGCOUNT | sed 's/4/4️⃣/g'`
REGCOUNT=`echo $REGCOUNT | sed 's/5/5️⃣/g'`
REGCOUNT=`echo $REGCOUNT | sed 's/6/6️⃣/g'`
REGCOUNT=`echo $REGCOUNT | sed 's/7/7️⃣/g'`
REGCOUNT=`echo $REGCOUNT | sed 's/8/8️⃣/g'`
REGCOUNT=`echo $REGCOUNT | sed 's/9/9️⃣/g'`
REGCOUNT=`echo $REGCOUNT | sed 's/0/0️⃣/g'`


#‼️📢
#♥️1️⃣2️⃣3️⃣4️⃣5️⃣6️⃣7️⃣8️⃣9️⃣0️⃣'

MSG="📢 ‼️ ขณะนี้มีผู้ลงทะเบียนเข้าร่วมงานและลุ้นรับของรางวัล 🎁 🎊แล้วจำนวน $REGCOUNT คน ♥️ อยากร่วมลุ้นรางวัล เชิญลงทะเบียนที่ https://cmmu.hexta.bid"

if [ ! -f $DATAPATH/ext-scripts/log1 ]
then
    echo 0 > $DATAPATH/ext-scripts/log1
fi

if [ "$NREGCOUNT" -eq "`cat $DATAPATH/ext-scripts/log1`" ]
then
    exit;
fi

AUTHCODE=(YOUR TOKEN)
echo "$MSG"
echo $NREGCOUNT >  $DATAPATH/ext-scripts/log1
HEADER="Authorization: Bearer $AUTHCODE"
curl -X POST -H "$HEADER" -F "message=$MSG" https://notify-api.line.me/api/notify
