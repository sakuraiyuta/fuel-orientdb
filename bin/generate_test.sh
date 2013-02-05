#!/bin/bash

if [ -z ${1} ]; then
	echo "Usage: ${0} {source-file}"
	exit
fi

TARGET_PHP_FILE=${1}
CLASS_NAME=`echo ${1} | sed "s%^.*/\([^/]*\).php$%\1%g"`
TEST_PATH=`echo ${1} | sed "s%^src%test%g" | sed "s%\.php$%Test\.php%g"`

echo "generating test: ${TARGET_PHP_FILE} > ${CLASS_NAME} > ${TEST_PATH}"

phpunit-skelgen --bootstrap ../../../../../public/index.php --test -- ${CLASS_NAME} ${TARGET_PHP_FILE} tests/
