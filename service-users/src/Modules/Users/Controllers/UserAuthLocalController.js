//@flow

import type {
    ControllerConfig,
    ControllerParams,
    ControllerDependenciesDefinition,
    ControllerActionReturn,
    ControllerRouteAclTable
} from 'paperframe';

import type {
    JwtCredentials,
    JwtToken
} from '../../../ServiceProviders/Jwt/Types/Jwt.t';

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

    constructor(config: ControllerConfig) {
        super(config);

        this._auth = passport;
        this._auth.use(new Strategy((username: string, password: string, callback: Function) => {
            if(username === 'test' && password === 'test') { // TODO: This is a mock check, replace with real code!
                callback(
                    null,
                    { // TODO: This is a mock response, replace with real code/response!
                        'id': '00000000-0000-0000-0000-000000000000',
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
                const jwtCredentials: JwtCredentials = await this.$S('jwt').getCredentials(user.id);
                const jwtToken: JwtToken = await this.$S('jwt').getToken(jwtCredentials, { 'session': user });

                const response = {
                    'accessToken': jwtToken,
                    'user': user
                };

                return this.response(HttpStatus.OK, PaperworkStatusCodes.AUTHENTICATION_SUCCEEDED, response);
            } catch(error) {
                return this.response(HttpStatus.INTERNAL_SERVER_ERROR, PaperworkStatusCodes.AUTHENTICATION_ERROR, error);
            }
        })(ctx, next);
    }
};
