#!/bin/bash

if [ -z ${1} ]; then
	echo "Usage: ${0} {source-file}"
	exit
fi

export doc_root=../../../.. app_path=../../.. core_path=../../../../core package_path=../../../../packages FUEL_ENV=test

BOOTSTRAP="$(dirname ${0})/../bootstrap_phpunit.php"
TARGET_PHP_FILE=$(cd $(dirname "${1}") && pwd)/$(basename ${1})
CLASS_NAME=`echo $(basename "${TARGET_PHP_FILE}") | sed "s%\(.*\).php$%\1%"`

TESTCLASS_NAME="${CLASS_NAME}Test"
TEST_PATH=`echo "${TARGET_PHP_FILE}" | sed 's%/src/%/test/%' | sed 's%[^/]*.php$%%'`
TEST_FILE="${TEST_PATH}/${TESTCLASS_NAME}.php"

if [ ! -d "${TEST_PATH}" ]; then
	mkdir -p "${TEST_PATH}"
fi

echo "generating test: ${TARGET_PHP_FILE} > ${CLASS_NAME} > ${TEST_FILE}"
#echo phpunit-skelgen --bootstrap ${BOOTSTRAP} --test -- ${CLASS_NAME} ${TARGET_PHP_FILE} ${TESTCLASS_NAME} ${TEST_FILE}
phpunit-skelgen --bootstrap ${BOOTSTRAP} --test -- ${CLASS_NAME} ${TARGET_PHP_FILE} ${TESTCLASS_NAME} ${TEST_FILE}
