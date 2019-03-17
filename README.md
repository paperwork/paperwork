Paperwork
=========

## OpenSource note-taking & archiving

[<img src="https://img.shields.io/matrix/paperwork:matrix.org.svg?color=%2361BCEE&label=JOIN%20THE%20CHAT&server_fqdn=matrix.org&style=for-the-badge"/>](https://riot.im/app/#/room/#paperwork:matrix.org)

<img src="https://raw.githubusercontent.com/paperwork/paperwork/master/paperwork-logo.png" width="250"/>

Paperwork is an open-source, self-hosted alternative to services like Evernote ®, Microsoft OneNote ® or Google Keep ®.

### Version 2

This branch contains the second iteration of Paperwork, which is a complete rewrite. Not only is it based on another framework - it is based on a completely different technology stack. **It is in its very early development phase and not yet usable**.

If you were looking for the Laravel-based version 1 of Paperwork, please check [out this branch](https://github.com/paperwork/paperwork/tree/1).

#### Background

If you're interested in it, [find it here 🤷🏻‍♂️](https://github.com/paperwork/paperwork/blob/c5d4b54e9c92f0cb8239558a6d21de7a5e70d3db/README.md#background).

#### I would love to help!

Feel free to check out this branch and get involved with what's there already to get an idea of where Paperwork is heading. Also check out the [project board](https://github.com/paperwork/paperwork/projects/1) to see what needs to be done or suggest what and how should be done.

Feel free to actively participate in the [chatroom](https://riot.im/app/#/room/#paperwork:matrix.org).

### Usage

This repository is structuring and unifying all required components for Paperwork.

```bash
$ git clone git@github.com:paperwork/paperwork.git
```

#### Docker Compose

The compose-setup depends on an encrypted overlay network to be created. For that, your docker environment needs to have swarm activated. You can do so by running:

```bash
$ docker swarm init
```

There is no need to join any more members to it. Only with swarm enabled the stack can be launched:

```bash
$ docker-compose up --build
```

##### `devproxy` Service

The [`devproxy`](https://github.com/paperwork/paperwork/tree/master/devproxy) automatically runs inside the stack, exposes port `2222` on the host and provides a way to forward local development ports into the docker environment. In order to forward for example the local [`service-users`](https://github.com/paperwork/service-users) port into the docker environment, an SSH port forward is required:

```bash
$ ssh -o "UserKnownHostsFile /dev/null" -o "StrictHostKeyChecking=no" -p 2222 -R 8880:127.0.0.1:8880 root@127.0.0.1
```

**The *root password* is `root`**. This forwards the local port `3000` into the `devproxy`, so that [`service-gatekeeper`](https://github.com/paperwork/service-gatekeeper) could reach `service-users` through `devproxy:8880`.

### Developing / contributing

Please refer to [the individual services' repositories](https://github.com/paperworkco) in order to get more information on how to contribute.
