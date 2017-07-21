# What's on Saigon

## Development Setup Guide

### prerequisites

PHPUnit 4.8.x

* NodeJs 6.x.x

* Have `Yarn` installed. See (https://yarnpkg.com/en/docs/install)

* Add `export PATH="$PATH:$(yarn global bin)" `to your `~/.bash_profile`

* Have `gulp` installed at global level with `yarn add global gulp`

### October CMS

* Have the project hosted on local Apache server and accessible at `http://localhost/whatsonsaigon/`.

* ave a mysql database named `whatsonsaigon` created. Have user `whatsonsaigon` with password `whatsonsaigon` accessible to the database with the same name.

* Open terminal, `cd` to the root of the project.

* run `php artisan october:up` to create tables.

### Semantic UI

* Open terminal, `cd` to the root of the project.

* Run `npm run semantic-build` to build semantic UI.

### react

* Open terminal, `cd` to the root of the project.

* Enter `yarn` command to pull external dependencies. This might take a while.

* Enter `gulp`. This should start the development server and watching files at `themes/default/assets/scripts` to recompile.

* The react development server should now be started at `http://localhost:5000`.

* Enjoy coding!

## Urls

Backend url: `http://localhost/whatsonsaigon/backend/urbn8/wos/eventcategories` username/pass: `admin/admin`

## October CMS Minimum System Requirements

October CMS has a few system requirements:

* PHP 5.5.9 or higher
* PDO PHP Extension
* cURL PHP Extension
* MCrypt PHP Extension
* ZipArchive PHP Library
* GD PHP Library

As of PHP 5.5, some OS distributions may require you to manually install the PHP JSON extension.
When using Ubuntu, this can be done via ``apt-get install php5-json``.

https://api.graph.cool/simple/v1/cj4jiyyppztzv0130z9strhq4

## Relay:
https://github.com/lvarayut/relay-fullstack
https://sourcegraph.com/github.com/stems/join-monster-demo@master/-/blob/schema-basic/Post.js

https://dev-blog.apollodata.com/exploring-relay-modern-276f5965f827
https://sourcegraph.com/github.com/apollographql/relay-modern-hello-world/-/blob/schema.graphql

https://sourcegraph.com/github.com/jscomplete/learning-graphql-and-relay/-/blob/schema/main.js#L34:4

### Mutations

https://sourcegraph.com/github.com/soonlive/relay-cart@master/-/blob/data/mutations/addToCartMutation.js#L41:49
https://sourcegraph.com/github.com/chrisbolin/understanding-relay-mutations@master/-/blob/examples/todo/server.js

### pagination
https://sourcegraph.com/github.com/stems/join-monster-demo@master/-/blob/schema-paginated/QueryRoot.js?utm_source=chrome-extension

## Apollo:
https://sourcegraph.com/github.com/Quadric/perfect-graphql-starter@master/-/blob/package.json#L37:6-37:18

https://sourcegraph.com/github.com/apollographql/apollo-tutorial-kit/-/blob/server.js

https://sourcegraph.com/github.com/apollographql/apollo-server-tutorial@master/-/blob/data/schema.js#L16:2
https://github.com/apollographql/apollo-server-tutorial/pull/6/files

# TODO
sample graphsql mutation on organisers
- create
- update

react consumes graphql server
- create
- update 

intergate mobx-state-tree with relay

routing and server rendering

react login, register

how to handle user visit page requires login? response body? status code?

pagination with connection type?

# How to Setup Watchman on Ubuntu 16.04

```
$ cd ~
$ git clone https://github.com/facebook/watchman.git
$ cd watchman/
$ git checkout v4.7.0
$ sudo apt-get install -y autoconf automake build-essential python-dev
$ ./autogen.sh 
$ ./configure 
$ make
$ sudo make install

$ watchman --version
$ echo 999999 | sudo tee -a /proc/sys/fs/inotify/max_user_watches  && echo 999999 | sudo tee -a  /proc/sys/fs/inotify/max_queued_events && echo 999999 | sudo tee  -a /proc/sys/fs/inotify/max_user_instances && watchman  shutdown-server
```