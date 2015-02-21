Paperwork - OpenSource note-taking & archiving
==============================================

[![Join the chat at https://gitter.im/twostairs/paperwork](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/twostairs/paperwork?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Build Status](https://travis-ci.org/twostairs/paperwork.svg?branch=master)](https://travis-ci.org/twostairs/paperwork)

![paperwork-logo](https://raw.githubusercontent.com/twostairs/paperwork/master/paperwork-logo.png)

Paperwork aims to be an open-source, self-hosted alternative to services like Evernote (R), Microsoft OneNote (R) or Google Keep (R).

Paperwork is written in PHP, utilising the beautiful Laravel 4 framework. It provides a modern web UI, built on top of AngularJS & Bootstrap 3, as well as an open API for third party integration.

For the back-end part a MySQL database stores everything. With such common requirements (Linux, Apache, MySQL, PHP), Paperwork will be able to run not only on dedicated servers, but also on small to mid-size NAS devices (Synology (R), QNAP (R), etc.).

## Screenshots (might not be up to date, please use the demo below!)

![01](https://raw.githubusercontent.com/twostairs/paperwork/gh-pages/images/screenshots/01.png)
![02](https://raw.githubusercontent.com/twostairs/paperwork/gh-pages/images/screenshots/02.png)
![03](https://raw.githubusercontent.com/twostairs/paperwork/gh-pages/images/screenshots/03.png)
![04](https://raw.githubusercontent.com/twostairs/paperwork/gh-pages/images/screenshots/04.png)
![05](https://raw.githubusercontent.com/twostairs/paperwork/gh-pages/images/screenshots/05.png)
![06](https://raw.githubusercontent.com/twostairs/paperwork/gh-pages/images/screenshots/06.png)
![07](https://raw.githubusercontent.com/twostairs/paperwork/gh-pages/images/screenshots/07.png)

## Demo (yes, there is one!)

At [demo.paperwork.rocks](http://demo.paperwork.rocks) you can actually see the current development status of Paperwork. Every night at 3am (CET) the database is being dropped and newly created, and the latest sources from GitHub are being deployed on the machine.

Feel free to create/modify/delete accounts, notebooks and notes. This demo can be used for heavy playing without regrets. Just try not to take down that thing. :)

## Initial installation (quick & dirty documented)

First of all, you need to clone this project to your machine.
After that, make sure that you have PHP >= 5.4.

Currently, we don't ship any prebuilt versions, so you need to build the app yourself.
To do this you must install [composer](http://getcomposer.org) and npm (nodejs package manager,
on how to install npm read [here](http://blog.npmjs.org/post/85484771375/how-to-install-npm))

Composer is needed to install third-party application components,
without them application will not run.

After you have finished the installation of npm and composer run:

    cd frontend
    composer install

At the point, you now have php dependencies installed.
It is now time to install tools to build the frontend files. We are using [gulp](http://gulpjs.com)
to build our frontend dependencies.

First you need to install gulp cli globally:

    sudo npm install -g gulp

And then npm dependencies inside project

    npm install

Then you just run the default task

    gulp

After these steps, you have all components installed and styles and js build,
it is time to configure your database.

Database settings are stored in frontend/app/config/database.php
If you'd like to use the default DB settings (MySQL/MariaDB), you'll just need
to have the database server running on port 3306 and create a database named
"paperwork". You could use the following SQL:

```
DROP DATABASE IF EXISTS paperwork; CREATE DATABASE IF NOT EXISTS paperwork DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
```

In addition, you need the "paperwork" user to have full access to this database:

```
GRANT ALL PRIVILEGES ON paperwork.* TO 'paperwork'@'localhost' IDENTIFIED BY 'paperwork' WITH GRANT OPTION; FLUSH PRIVILEGES;
```

With these settings, you won't need to modify the database.php configuration file.

After completing these steps, run the migration jobs, that fill the database:

```
php artisan migrate
```

If anything here should fail, it's most likely an authentication/connection issue, so check your database setup again.

Now, for the last step, make sure that your webserver has the right to create/modify/delete files within the `frontend/app/storage/attachments/`, the `frontend/app/storage/cache/`, the `frontend/app/storage/logs/` and the `frontend/app/storage/sessions/` folders.

Also, be sure to set the document root (docroot) of your webserver to the folder `frontend/public/`. If you don't have access to or don't want/know how to do this, you can use .htaccess to set up temporary rewrite rules to experience Paperwork fully. In the example below, it is assumed that you have all your papaerwork files in a folder named paperwork folder as child of the document root folder.

1. Create a new file named `.htaccess`
2. Copy and paste this code in it:

```
RewriteEngine on
RewriteCond %{REQUEST_URI} !paperwork/frontend/public/
RewriteRule (.*) /paperwork/frontend/public/$1 [L]
```

3. Save the file

You can access Paperwork by going to http://localhost or any URL you use to access your machine.

When you need to access any other files from the document root (all folders will be inaccessible), rename the file to something different from `.htaccess`.

That's pretty much it. From here on, you should be able to access your paperwork instance through the web.

## Run using Docker

Basically you just have to:

    fig up

To run the migrations (once):

    fig run web php artisan migrate --force

## Upgrading

Upgrading to the latest GIT version of Paperwork is fairly easy. Update your local repository running `git pull`, then `cd` into the `frontend/` directory and run `php artisan migrate`. In most cases this should work. If you're experiencing issues, you might need to clear the database completely and re-run the initial installation.

## API documentation

The API documentation can be found at [docs.paperwork.apiary.io](http://docs.paperwork.apiary.io/) or built using the ``apiary.apib`` file from this repository. It's not yet complete and could change at any time!

## Developing

Developing on Paperwork is fairly easy for anyone who's familiar with Laravel 4. Within `frontend/app/` all internal code can be found, including all source LESS and JavaScript files that are being used to generate the output files that lie in `frontend/public/css/` and `frontend/public/js`.

If you need to modify the stylesheet or JavaScript, *DO NOT TOUCH ANY OF THE FILES IN `frontend/public/`*, as they will be overwritten by the generator process. Instead, modify the files in `frontend/app/less/` and `frontend/app/js/`. For building, you'll need Gulp.js.

Switch into `frontend` directory on a command line and execute the following:

```
npm install
```

npm will install all dependencies required through the `package.json`, so that you'll be able to run the generator process yourself. For doing so, simply run the command `gulp` within your `frontend` directory.

## Contributing

We're using [this style of git branching](http://nvie.com/posts/a-successful-git-branching-model/). So for development, you should clone the Paperwork repository here on Github, and checkout a new feature branch off from the develop branch (rather than master) such as issue-48-feature. Commit your changes to that branch and then send us pull-requests back into the develop branch.

The exception to this rule is urgent hotfixes to master. To perform a hotfix, make a new branch off of master. When you're ready to submit the changes, make a pull request to both the master and develop branches.

## Some last words

The current development status is far from being worth called "version 1.0". However, if I could get you interested in this project and you feel like contributing, don't hesitate to ping me by e-mail ([marius@paperwork.rocks](mailto:marius@paperwork.rocks)) or twitter ([@devilx](https://twitter.com/devilx)) so we can talk. :-)

There is a #paperwork IRC channel on freenode.net and there is a [gitter](https://gitter.im/twostairs/paperwork) group as well.

## FAQ

### Can I run Paperwork on a shared host environment, where I'm not able to set `frontend/public` as document root?

Basically you can. This has nothing to do with Paperwork specifically, though. The foundation ontop of which Paperwork is built up (Laravel) needs to be reconfigured to support a shared host environment. [Here](https://www.google.com/search?q=laravel+4+shared+host) you can find more info about how to do so.

### Are you planning to implement ... into Paperwork soon?

Maybe. Check out more detailed information about the features we are currently working on [here](https://github.com/twostairs/paperwork/issues).

### I would like to join Paperwork development, what's the best way to do so?

In addition to contributing, make sure to shoot us an e-mail at [paperwork-dev@googlegroups.com](mailto:paperwork-dev@googlegroups.com), or hop on the [gitter group](https://gitter.im/twostairs/paperwork) and inform us about your interest in joining the team. We will then make sure to give you the required access to our [GitHub Issues](https://github.com/twostairs/paperwork/issues) as well.

