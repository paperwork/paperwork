# ╔════════════════════════════════════════════════════════════════════════════╗
# ║                                                                            ║
# ║                      \  |       |          _|_) |                          ║
# ║                     |\/ |  _` | |  /  _ \ |   | |  _ \                     ║
# ║                     |   | (   |   <   __/ __| | |  __/                     ║
# ║                    _|  _|\__,_|_|\_\\___|_|  _|_|\___|                     ║
# ║                                                                            ║
# ║           * github.com/paperwork * twitter.com/paperworkcloud *            ║
# ║                                                                            ║
# ╚════════════════════════════════════════════════════════════════════════════╝
.PHONY: help init deploy undeploy status

ORCHESTRATOR ?= swarm  ##@Variables The Docker orchestrator to use, default: swarm
STACK_NAME ?= paperwork  ##@Variables The Docker stack name, default: paperwork
COMPOSE_FILE ?= paperwork.yml  ##@Variables The Docker stack compose file to use, default: paperwork.yml

FN_HELP = \
	%help; while(<>){push@{$$help{$$2//'options'}},[$$1,$$3] \
		if/^(\w+)\s*(?:).*\#\#(?:@(\w+))?\s(.*)$$/}; \
	print"$$_:\n", map"  $$_->[0]".(" "x(20-length($$_->[0])))."$$_->[1]\n",\
	@{$$help{$$_}},"\n" for keys %help; \

help: ##@Miscellaneous Show this help
	@echo "Usage: make [target] <var> ...\n"
	@perl -e '$(FN_HELP)' $(MAKEFILE_LIST)

init: ##@Init Initialize Docker Swarm
	docker service ls || docker swarm init

deploy: ##@Deployment Deploy Paperwork
	docker stack ps --orchestrator=${ORCHESTRATOR} ${STACK_NAME} > /dev/null && $(error Paperwork already deployed! Run `make undeploy` first.)
	docker stack deploy --orchestrator=${ORCHESTRATOR} --prune --compose-file ${COMPOSE_FILE} ${STACK_NAME}

undeploy: ##@Deployment Undeploy Paperwork
	docker stack rm --orchestrator=${ORCHESTRATOR} ${STACK_NAME}

status: ##@Deployment Check Paperwork deployment status
	docker stack ps --orchestrator=${ORCHESTRATOR} ${STACK_NAME}
