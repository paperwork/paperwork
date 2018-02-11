//@flow

import type {
    ControllerParams,
    ControllerDependenciesDefinition,
    ControllerActionReturn,
    ControllerRouteAclTable,
    EventId,
    EventPackage
} from 'paperframe';

const PaperworkController = require('../../../Library/PaperworkController');
const PaperworkStatusCodes = require('../../../Library/PaperworkStatusCodes');

const HttpStatus = require('http-status-codes');

module.exports = class UserController extends PaperworkController {
    static get dependencies(): ControllerDependenciesDefinition {
        return ['database'];
    }

    static get resource(): string {
        return 'user';
    }

    static get route(): string {
        return '/users';
    }

    get eventListener(): string {
        return '**';
    }

    onEvent(eventId: string, eventPackage: EventPackage) {
        console.log(eventId);
        console.log(eventPackage);
    }

    async index(params: ControllerParams): ControllerActionReturn {
        const user = this.$C('user');
        return this.response(HttpStatus.OK, PaperworkStatusCodes.OK, {});
    }

    async show(params: ControllerParams): ControllerActionReturn {
        const user = this.$C('user');
        return this.response(HttpStatus.OK, PaperworkStatusCodes.OK, {});
    }
};
