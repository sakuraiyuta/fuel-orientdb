#!/bin/bash

if [ -z ${1} ]; then
	echo "Usage: ${0} {source-file}"
	exit
fi

BIN_PATH=$(dirname ${0})

export \
	doc_root=${BIN_PATH}/../../../.. \
	app_path=${BIN_PATH}/../../../.. \
	core_path=${BIN_PATH}/../../../../../core \
	package_path=${BIN_PATH}/../../../../../packages \
	FUEL_ENV=test

BOOTSTRAP="${BIN_PATH}/../bootstrap_phpunit.php"
TARGET_PHP_FILE=$(cd $(dirname "${1}") && pwd)/$(basename ${1})
#CLASS_NAME=`echo $(basename "${TARGET_PHP_FILE}") | sed "s%\(.*\).php$%\1%"`
NAMESPACE_NAME=`cat ${TARGET_PHP_FILE} | grep "^namespace" | sed "s/\s*namespace\s*\(.*\);$/\1/g"`
CLASS_NAME=`cat ${TARGET_PHP_FILE} | grep "^class" | sed "s/\s*class\s\+\(\S\+\).*$/\1/g"`
FULL_NS_NAME=${NAMESPACE_NAME}\\${CLASS_NAME}

TESTCLASS_NAME="${CLASS_NAME}Test"
TEST_PATH=`echo "${TARGET_PHP_FILE}" | sed 's%/src/%/test/%' | sed 's%[^/]*.php$%%'`
TEST_FILE="${TEST_PATH}/${TESTCLASS_NAME}.php"

if [ ! -d "${TEST_PATH}" ]; then
	mkdir -p "${TEST_PATH}"
fi

echo "generating test: ${TARGET_PHP_FILE} > ${FULL_NS_NAME} > ${TEST_FILE}"
#echo phpunit-skelgen --bootstrap ${BOOTSTRAP} --test -- ${FULL_NS_NAME} ${TARGET_PHP_FILE} ${TESTCLASS_NAME} ${TEST_FILE}
phpunit-skelgen --bootstrap ${BOOTSTRAP} --test -- ${FULL_NS_NAME} ${TARGET_PHP_FILE} ${TESTCLASS_NAME} ${TEST_FILE}
