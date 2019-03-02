# Simple LAMP app
This was forked from https://github.com/qyjohn/simple-lamp, but hugely modified to read and print out employees from the famous employees sample database (https://dev.mysql.com/doc/employee/en/)

## Usage
You need to have Docker installed. Clone this repo and do:
```
docker-compose up
```
It takes a while to populate the database from the dump file in `test_db` directory.

Load http://localhost:8080

To get more or less than 10 records do http://localhost:8080?count=3

Pretty output with curl and jq:
```
curl -s http://localhost:8080?count=3 | jq
```

To request random records between 0 and 100, and generate load on the docker container do:
```
while true
do
    count=$((RANDOM%100))
    curl -s http://localhost:8080?count=$count | jq
done
```

To stop the stack:
```
docker-compose down
```