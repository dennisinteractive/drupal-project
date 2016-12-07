#!/bin/bash

case "$1" in
    PHP_CodeSniffer)
        cd $TRAVIS_BUILD_DIR
        ./vendor/bin/phpcs
        exit $?
        ;;
    Behat)
        cd $TRAVIS_BUILD_DIR/tests
        ./behat
        exit $?
        ;;
    *)
        echo "Unknown test '$1'"
        exit 1
esac
