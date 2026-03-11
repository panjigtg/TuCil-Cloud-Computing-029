#!/bin/bash

URL="http://localhost"
JUMLAH_REQUEST=10000 
DELAY=0.1       

for ((i=1; i<=JUMLAH_REQUEST; i++))
do
    NAMA="batch_$i"

    curl -s -X POST "$URL/api/login" \
         -H "Content-Type: application/json" \
         -d "{\"username\":\"$NAMA\"}" \
         -c "cookies_$i.txt" > /dev/null

    PASLON=$(( ( RANDOM % 3 )  + 1 ))

    RESPONSE=$(curl -s -X POST "$URL/api/vote" \
         -H "Content-Type: application/json" \
         -d "{\"paslon\":$PASLON}" \
         -b "cookies_$i.txt")

    echo "[$i/$JUMLAH_REQUEST] $NAMA memilih Paslon 0$PASLON -> $RESPONSE"
    rm "cookies_$i.txt"

    sleep 0
done