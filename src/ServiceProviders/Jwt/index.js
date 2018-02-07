//@flow

const jwt = require('jsonwebtoken');
const crypto = require('crypto');
const promisify = require('bluebird').promisify;

const signAsync = promisify(jwt.sign, jwt);
const randomBytesAsync = promisify(crypto.randomBytes, crypto);

const ServiceProvider = require('paperframe').ServiceProvider;

module.exports = class JwtServiceProvider extends ServiceProvider {
    _secretToken:               string

    initialize() {
        this.logger.debug('Jwt: Initializing ...');

        let secretToken = process.env.JWT_SECRET;
        if(typeof secretToken === 'undefined'
        || secretToken === null) {
            throw new Error('Jwt: No secret defined! Please set JWT_SECRET in your environment first.');
        }

        this._secretToken = secretToken;

        return true;
    }

    async generateJwtId(): Promise<?string> {
        try {
            const randomSize = 32;
            let jti = await randomBytesAsync(randomSize);
            return Promise.resolve(jti.toString('hex'));
        } catch (e) {
            return Promise.reject(e);
        }
    }

    async generateTokens(payload: any, opts: Object = {}): Promise<?Object> {
        try {
            const accessTokenId = await this.generateJwtId();
            const refreshTokenId = await this.generateJwtId();

            const accessTokenPayload = Object.assign({}, payload, { jti: accessTokenId });
            const refreshTokenPayload = Object.assign({}, {
                jti: refreshTokenId,
                ati: accessTokenId
            });

            const expiresRefresh = parseInt(process.env.SERVER_JWT_REFRESH_EXPIRY, 10);
            const refreshTokenOpts = Object.assign({}, {
                expiresIn: expiresRefresh
            }, opts);

            const expiresAccess = parseInt(process.env.SERVER_JWT_ACCESS_EXPIRY, 10);
            const accessTokenOpts = Object.assign({}, {
                expiresIn: expiresAccess
            }, opts);

            const refreshToken = await signAsync(refreshTokenPayload, this._secretToken, refreshTokenOpts);
            const accessToken = await signAsync(accessTokenPayload, this._secretToken, accessTokenOpts);

            return Promise.resolve({
                accessToken,
                refreshToken
            });
        } catch(e) {
            return Promise.reject(e);
        }
    }

    verifyTokensAndGetUserId(accessToken: string, refreshToken: string): ?string {
        let accessTokenDecoded = null;
        let refreshTokenDecoded = null;

        try {
            accessTokenDecoded = jwt.decode(accessToken, process.env.JWT_SECRET);
            refreshTokenDecoded = jwt.verify(refreshToken, process.env.JWT_SECRET);
        } catch(err) {
            this.logger.debug('Jwt: refreshToken expired already! (%s)', err);
            return null;
        }

        if(refreshTokenDecoded.ati === accessTokenDecoded.jti) {
            return accessTokenDecoded.session.id;
        }

        this.logger.debug('Jwt: accessToken.jti does not match refreshToken.ati');
        return null;
    }

};
