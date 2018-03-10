//@flow

const Base = require('paperframe').Base;

const axios = require('axios');
const HttpStatus = require('http-status-codes');

module.exports = class Kong extends Base {
    _kongApiUrl:                string

    constructor(options: Object) {
        super();

        this.logger = options.logger;
    }

    async execute(method: string, url: string, payload: ?Object): Promise<Object> {
        let responseCode = 200;
        let responseData = {};

        this.logger.debug(`Kong: Executing ${method} on ${url}...`);

        try {
            const response = await axios[method](url, payload);

            responseCode = response.code;
            responseData =  response.data;

            this.logger.debug(`Kong: Executed ${method} on ${url} successfully.`);
        } catch(response) {
            responseCode = response.response.status;
            responseData = response.response;

            this.logger.debug(`Kong: Execution of ${method} on ${url} returned response code ${responseCode}.`);
        }

        if(responseCode !== HttpStatus.OK && responseCode !== HttpStatus.CONFLICT) {
            throw new Error(`Kong: ${JSON.stringify(responseData)}`);
        }

        return responseData;
    }

    async initialize(): Promise<boolean> {
        // Kong API URL
        this._kongApiUrl = this.getEnv('KONG_API_URL');
        if(typeof this._kongApiUrl === 'undefined') {
            throw new Error('Kong: Could not initialize, KONG_API_URL not set!');
        }

        let response = {};

        response = await this.execute('post', `${this._kongApiUrl}/consumers`, {
            'custom_id': '00000000-0000-0000-0000-000000000000',
            'username': '00000000-0000-0000-0000-000000000000'
        });

        let guestId = null;

        if(response === {}) {
            response = await this.execute('get', `${this._kongApiUrl}/consumers/00000000-0000-0000-0000-000000000000`);
            guestId = response.id;
        } else {
            guestId = response.id;
        }

        response = await this.execute('post', `${this._kongApiUrl}/apis`, {
            'uris': '/users',
            'strip_uri': true,
            'name': 'service-users',
            'upstream_url': `http://service-users:${this.getEnv('SERVER_PORT')}`
        });

        response = await this.execute('post', `${this._kongApiUrl}/apis/service-users/plugins`, {
            'name': 'jwt',
            'config.anonymous': guestId,
            'config.claims_to_verify': [
                'exp',
                'nbf'
            ]
        });

        return true;
    }
};
