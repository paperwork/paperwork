Paperwork
=========

## OpenSource note-taking & archiving

[<img src="https://about.riot.im/wp-content/themes/riot/img/tiny-riot.svg" width="22"/> Join the chat](https://riot.im/app/#/room/#paperwork:matrix.org)

<img src="https://raw.githubusercontent.com/twostairs/paperwork/master/paperwork-logo.png" width="250"/>

Paperwork is an open-source, self-hosted alternative to services like Evernote ®, Microsoft OneNote ® or Google Keep ®.

### Version 2

This branch contains the second iteration of Paperwork, which is a complete rewrite. Not only is it based on another framework - it is based on a completely different technology stack. **It is in its very early development phase and not yet usable**.

If you were looking for the Laravel-based version 1 of Paperwork, please check [out this branch](https://github.com/twostairs/paperwork/tree/1).

#### Background

The very first version of Paperwork was started in July 2014 as a pet-project by [this guy](https://twitter.com/mrusme), mainly out of frustration about the existing services (Evernote & others), fear ignited by the Snowden revelations and curiosity about whether the effort would lead to something people would be interested in. And apparently it did. :) Soon, more [great](https://github.com/Liongold) [people](https://github.com/joshlemer) [joined](https://github.com/JamborJan) the project and [contributed](https://github.com/twostairs/paperwork/graphs/contributors).

However, originally the tech that was used to build the very first version on top (mainly PHP 5, MySQL, Laravel 4, Angular & Bootstrap) was chosen to keep things simple and allow iterating quickly. The primary goal for the project was the actual result, rather than any sort of technological finesse.

Over the time, two observations concerning the chosen technology were made:

- The percentage of code share between PHP (as in the Laravel back-end) and JavaScript (as in the Angular front-end) shifted from an initial 80:20-ratio to roughly 50:50 by today
- Most of the time, the biggest pain-points during the implementation of new features were not within the front-end but rather on the back-end side

With us basically struggling to implement heavily requested features, not solely but also due to technical debt that was caused by poor technical decisions in first place, the project slowly became dormant.

With the effort to revamp Paperwork in its current form (e.g. clean the code on the front- and the back-end, upgrade to the latest Laravel version, upgrade to the latest PHP version, clean the database schema, refactor the API, ...) being **significant** and a clear force on the JavaScript-side of the project being observable, it seems to make more sense to rebuild Paperwork from ground up, on top of an architecture that allows for more flexibility, quicker iteration, a better structure and ultimately a higher ease of use/contribute.

#### So, what now?

This branch contains a very first suggestion, of how the second iteration of Paperwork could look like. As you might notice, one major change is the clear separation of components, making this branch (and hopefully soon the whole repository) only one piece of the puzzle. Currently, it only contains of the back-end component — or better, one of them — and does not include front-end components whatsoever. The idea is to build the second iteration in a more modular and diversified manner, picking the right tool for the task rather than building a monolith that is harder to maintain the bigger it grows.

Everyone who is interested in getting their feet wet is highly welcome to [join the discussion](https://riot.im/app/#/room/#paperwork:matrix.org) and [planning](https://github.com/twostairs/paperwork/projects/1?) around Paperwork 2.

#### Okay, cool. But what took you so long to get to this point?

Funding. Basically this point was planned and headed towards sometime in mid 2016. Since then, different attempts were made to get funding for this project, through individuals but also programs like [Prototypefund](https://prototypefund.de). The general idea was to accelerate development by paying you, the contributors, using a bounty-source-like approach. Unfortunately none of the attempts led to an actual funding or investment whatsoever. At this point putting the effort into the actual development, instead of pursuing further discussions and applications for such programs seems to make more sense.

#### I would love to help!

Feel free to check out this branch and get involved with what's there already to get an idea of where Paperwork is heading. Also check out the [project board](https://github.com/twostairs/paperwork/projects/1) to see what needs to be done or suggest what and how should be done.

Feel free to actively participate in the [chatroom](https://riot.im/app/#/room/#paperwork:matrix.org) or [shoot an email](mailto:paperwork-dev@googlegroups.com) to the [Paperwork dev mailinglist](https://groups.google.com/forum/#!forum/paperwork-dev).

### Usage

This repository is structuring and unifying all required components for Paperwork.

```bash
$ git clone git@github.com:twostairs/paperwork.git
```

#### Docker Compose

The setup is split into separate compose files that can be run individually of each other. In order for the `service` compose-files to work, the `infrastructure` compose-file needs to be running, though.

The compose-setup depends on an encrypted overlay network to be created. For that, your docker environment needs to have swarm activated. You can do so by running:

```bash
$ docker swarm init
```

There is no need to join any more members to it. Only with swarm enabled the `infrastructure` can be launched:

```bash
$ docker-compose -f ./docker-compose.infrastructure.yml up --build
```

After the `infrastructure` is up and running all the services can be started individually.

##### Users Service

In order to start the users service (`service-users`), run the following `docker-compose` command:

```bash
$ docker-compose -f ./docker-compose.service-users.yml up --build
```

This allows running each service either as fully built docker container or as development instance. For example, `service-users` could also be run locally, via `npm run dev`, alongside the `infrastructure` compose-file. This would make `service-kong` (inside `infrastructure`) reach out to the local development instance of `service-users` and allow for easy development on individual services.

In order to make a local service available inside docker, the `devproxy` is being required. The `devproxy` automatically runs inside the `infrastructure`, exposes port `2222` on the host and provides a way to forward local development ports into the docker environment. In order to forward the local `service-users` port into the docker environment, an SSH port forward is required:

```bash
$ ssh -o "UserKnownHostsFile /dev/null" -o "StrictHostKeyChecking=no" -p 2222 -R 3000:127.0.0.1:3000 root@127.0.0.1
```

The *root password* is `root`. This forwards the local port `3000` into the `devproxy`, so that `service-kong` could reach `service-users` through `devproxy:3000`. In order to do so, the locally running `service-users` needs to have the `SERVICE_USERS_URL` environment variable set to `http://devproxy:3000`, as it uses this variable to set up the kong upstream for `service-users`.

### Developing / contributing

Please refer to [the components' repositories](https://github.com/paperworkco) in order to get more information on how to contribute.

#### List of components

- [service-lbx](https://github.com/paperworkco/service-lbx) [![Build Status](https://travis-ci.org/paperworkco/service-lbx.svg?branch=master)](https://travis-ci.org/twostairs/paperwork)
- [service-kong](https://github.com/paperworkco/service-kong) [![Build Status](https://travis-ci.org/paperworkco/service-kong.svg?branch=master)](https://travis-ci.org/twostairs/paperwork)
- [service-nats](https://github.com/paperworkco/service-nats) [![Build Status](https://travis-ci.org/paperworkco/service-nats.svg?branch=master)](https://travis-ci.org/twostairs/paperwork)
- [service-users](https://github.com/paperworkco/service-users) [![Build Status](https://travis-ci.org/paperworkco/service-users.svg?branch=master)](https://travis-ci.org/twostairs/paperwork)

