#!/bin/bash

if [ -z ${1} ]; then
	echo "Usage: ${0} {source-file}"
	exit
fi

TARGET_PHP_FILE=${1}
BOOTSTRAP="$(dirname ${0})/../../../../../../public/index.php"
CLASS_NAME=`echo ${1} | sed "s%^.*/\([^/]*\).php$%\1%g"`
TESTCLASS_NAME="${CLASS_NAME}Test"
TEST_FILE="$(dirname ${0})/../test/${TESTCLASS_NAME}.php"

echo "generating test: ${TARGET_PHP_FILE} > ${CLASS_NAME} > ${TEST_PATH}"
echo "phpunit-skelgen --bootstrap ${BOOTSTRAP} --test -- ${CLASS_NAME} ${TARGET_PHP_FILE} ${TEST_FILE}"
phpunit-skelgen --bootstrap ${BOOTSTRAP} --test -- ${CLASS_NAME} ${TARGET_PHP_FILE} ${TESTCLASS_NAME} ${TEST_FILE}
