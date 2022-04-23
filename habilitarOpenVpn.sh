#!/bin/bash

mkdir -p /dev/net
mknod /dev/net/tun c 10 200
chmod 600 /dev/net/tun

sysctl net.ipv6.conf.all.disable_ipv6=0