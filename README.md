# DQL-Server
A server side application that can receive and process Domain Query Language (DQL) statements, leading to a fully working, event-sourced, domain.

[![Build Status](https://travis-ci.org/domain-query-language/dql-server.svg?branch=master)](https://travis-ci.org/domain-query-language/dql-server)



## Status
This project is still in development. This document will be updated as development progresses.

For a more in depth understanding of the current state of the project, have a look at the open and closed Github issues.

## Development Installation
To install DQL-Server for development, you need to complete the following steps:

1. Copy "Homestead.template.yaml" to "Homestead.yaml"
2. Add the missing fields to "Homestead.yaml" 
    1. [IP Address that you want] should be come the IP address you want your VM to use, eg "192.168.10.22"
    2. [Path/to/your/DQL/install] should be the folder path to the root dir of this repo, on your local machine
3. Run "composer install" from the commandline in the root of this project
4. Run "vagrant up"
5. Add an entry to your hosts file ("/etc/hosts" on mac/linux), point the url "dql-server.app" at the IP address you entered above
6. Go to http://dql-server.app/server-test.php to test that it's working
7. Grab a coffee/tea/beer, you're done

## Issuing commands
To issue a command, go to http://dql-server.app/dql/form. This is the interface for sending commands to your DQL server.