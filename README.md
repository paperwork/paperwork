Paperwork
=========

## OpenSource note-taking & archiving

[<img src="https://about.riot.im/wp-content/themes/riot/img/tiny-riot.svg" width="22"/> Join the chat](https://riot.im/app/#/room/#paperwork:matrix.org)
[![Build Status](https://travis-ci.org/twostairs/paperwork.svg?branch=2)](https://travis-ci.org/twostairs/paperwork)

<img src="https://raw.githubusercontent.com/twostairs/paperwork/2/paperwork-logo.png" width="250"/>

Paperwork is an open-source, self-hosted alternative to services like Evernote ®, Microsoft OneNote ® or Google Keep ®.

### Version 2

This branch contains the second iteration of Paperwork, which is a complete rewrite. Not only is it based on another framework - it is based on a completely different technology stack.

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

### Docker Compose

```bash
$ docker-compose up
```
