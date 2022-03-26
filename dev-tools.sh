#!/bin/bash

if [ -f .env ]
then
  export $(cat .env | sed 's/#.*//g' | xargs)
fi


title="Select a tool to execute: 1 => TestServer 2 => Exit"

echo $title

# Operating system names are used here as a data source
select opt in Serve Exit
do

case $opt in
# Case 1
"TestServer")
cd /workspace/test/server
php -S localhost:8080 public/index.php
break
;;
# Last Case
"Exit")
echo "Bye"
break
;;
esac

echo $title
done
