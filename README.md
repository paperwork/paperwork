Paperwork
=========

## OpenSource note-taking & archiving

[<img src="https://about.riot.im/wp-content/themes/riot/img/tiny-riot.svg" width="22"/> Join the chat](https://riot.im/app/#/room/#paperwork:matrix.org)
[![Build Status](https://travis-ci.org/twostairs/paperwork.svg?branch=2)](https://travis-ci.org/twostairs/paperwork)

<img src="https://raw.githubusercontent.com/twostairs/paperwork/2/paperwork-logo.png" width="250"/>

Paperwork is an open-source, self-hosted alternative to services like Evernote ®, Microsoft OneNote ® or Google Keep ®.

### Development

Starting in development mode (with code auto-reload):

```bash
$ git clone git@github.com:twostairs/paperwork.git
$ cd paperwork
$ git checkout 2
$ npm install
$ cp .env.example .env
$ vim .env
$ # adjust the settings accordingly
$ npm run dev
```

Running tests:

```bash
$ npm test
```

### Docker

```bash
$ docker build -t="twostairs/paperwork" .
$ docker run -it --rm --name="paperwork" --env-file .env twostairs/paperwork
```
