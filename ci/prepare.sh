#!/usr/bin/env bash

# Update apt index
apt-get update -yqq

# Install required packages
# git                           - Not included in PHP image
# openssh-client                - Needed to get ssh-agent for SSH connections
apt-get install git openssh-client -yqq
