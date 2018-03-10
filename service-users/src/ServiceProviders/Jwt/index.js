//@flow

import type {
    JwtCredentials,
    JwtToken
} from './Types/Jwt.t';

const axios = require('axios');
const jwt = require('jsonwebtoken');
const bluebird = require('bluebird');

const jwtSign = bluebird.promisify(jwt.sign);

const ServiceProvider = require('paperframe').ServiceProvider;
const PaperframeCommon = require('paperframe').Common;

module.exports = class JwtServiceProvider extends ServiceProvider {
    _kongApiUrl:                string
    _accessTokenExpiresIn:      number
    _accessTokenNotBefore:      number

    initialize() {
        // Kong API URL
        this._kongApiUrl = this.getEnv('KONG_API_URL');
        if(typeof this._kongApiUrl === 'undefined') {
            this.logger.error('JwtServiceProvider: Could not initialize, KONG_API_URL not set!');
            return false;
        }

        this.logger.debug('JwtServiceProvider: Initialized with KONG_API_URL set to %s.', this._kongApiUrl);

        // JWT Access Token Expiry
        const accessTokenExpiresIn = this.getEnv('SERVER_JWT_ACCESS_EXPIRY');
        if(typeof accessTokenExpiresIn === 'undefined') {
            this.logger.error('JwtServiceProvider: Could not initialize, SERVER_JWT_ACCESS_EXPIRY not set!');
            return false;
        }
        this._accessTokenExpiresIn = parseInt(accessTokenExpiresIn, 10);

        // JWT Access Token not before (unused so far)
        this._accessTokenNotBefore = PaperframeCommon.ZERO;

        this.logger.debug('JwtServiceProvider: Initialized with SERVER_JWT_ACCESS_EXPIRY set to %s.', this._accessTokenExpiresIn);

        return true;
    }

    async getCredentials(userId: string): Promise<?JwtCredentials> {
        let responseData = {};

        try {
            this.logger.debug('JwtServiceProvider: Getting credentials for userId %s ...', userId);

            const response = await axios.post(`${this._kongApiUrl}/consumers/${userId}/jwt`, {
                'algorithm': 'HS256'
            });

            const jwtCredentials: JwtCredentials = response.data;

            this.logger.debug('JwtServiceProvider: Got credentials for userId %s: %j', userId, jwtCredentials);

            return jwtCredentials;
        } catch(error) {
            this.logger.error('JwtServiceProvider: Getting credentials failed:');
            this.logger.error(error);

            return null;
        }
    }

    async getToken(credentials: JwtCredentials, payload: Object): Promise<?JwtToken> {
        try {
            const jwtToken: JwtToken = await jwtSign(payload, credentials.secret, {
                'algorithm': 'HS256',
                'expiresIn': this._accessTokenExpiresIn,
                //'notBefore': this._accessTokenNotBefore, // TODO: Not in use yet.
                'issuer': credentials.key,
                'jwtid': credentials.id,
                'header': {
                    'typ': 'JWT',
                    'alg': 'HS256'
                }
            });

            return jwtToken;
        } catch(error) {
            this.logger.error('JwtServiceProvider: Getting token failed:');
            this.logger.error(error);

            return null;
        }
    }
};
