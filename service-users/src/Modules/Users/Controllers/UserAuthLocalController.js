//@flow

import type {
    ControllerConfig,
    ControllerParams,
    ControllerDependenciesDefinition,
    ControllerActionReturn,
    ControllerRouteAclTable
} from 'paperframe';

const PaperworkController = require('../../../Library/PaperworkController');
const PaperworkStatusCodes = require('../../../Library/PaperworkStatusCodes');

const passport = require('koa-passport');
const Strategy = require('passport-local').Strategy;

const Joi = require('joi');
const HttpStatus = require('http-status-codes');

module.exports = class UserAuthLocalController extends PaperworkController {
    _auth:                      passport

    static get dependencies(): ControllerDependenciesDefinition {
        return ['database', 'jwt'];
    }

    static get resource(): string {
        return 'authLocal';
    }

    static get route(): string {
        return '/auth/local';
    }

    get routeAcl(): ControllerRouteAclTable {
        let acl: ControllerRouteAclTable = {
            'create': {
                'protected': false
            }
        };

        return acl;
    }

    constructor(config: ControllerConfig) {
        super(config);

        this._auth = passport;
        this._auth.use(new Strategy((username: string, password: string, callback: Function) => {
            if(username === 'test' && password === 'test') {
                callback(
                    null,
                    {
                        'username': 'test',
                        'verified': 'true'
                    },
                    {
                        'message': 'Success'
                    }
                );
            } else if(username !== 'test' || password !== 'test') {
                callback(
                    {
                        message: 'Incorrect username or password.'
                    },
                    false,
                    false,
                    {}
                );
            }
        }));
    }

    /**
     * Before CREATE handler
     */
    async beforeCreate(params: ControllerParams): ControllerParams {
        const schema = Joi.object().keys({
            'username': Joi.string().required(),
            'password': Joi.string().required()
        });

        return this.validate(params, schema);
    }

    /**
     * CREATE handler
     */
    async create(params: ControllerParams): ControllerActionReturn {
        const ctx = this.ctx;
        const next = this.next;

        return this._auth.authenticate('local', async (err, user, info) => {
            if(user === false || typeof user === 'undefined') {
                return this.response(HttpStatus.UNAUTHORIZED, PaperworkStatusCodes.AUTHENTICATION_FAILED, err);
            }

            try {
                const { accessToken, refreshToken } = await this.$S('jwt').generateTokens({
                    'session': user
                });

                const body = {
                    accessToken,
                    refreshToken,
                    'user': user
                };

                return this.response(HttpStatus.OK, PaperworkStatusCodes.AUTHENTICATION_SUCCEEDED, body);
            } catch(error) {
                return this.response(HttpStatus.INTERNAL_SERVER_ERROR, PaperworkStatusCodes.AUTHENTICATION_ERROR, error);
            }
        })(ctx, next);
    }
};
