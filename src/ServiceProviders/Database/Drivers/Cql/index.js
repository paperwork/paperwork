//@flow


const Driver = require('paperframe').ServiceProviders.Database.Driver;

const cql = require('cassandra-driver');

module.exports = class CqlDriver extends Driver {
    _connection:                Object
    _client:                    Function

    initialize(): boolean {
        if(typeof process.env.DATABASE_CONNECTION === 'undefined'
        || process.env.DATABASE_CONNECTION === null) {
            throw new Error('Database: (CqlDriver) No connection configured! Please define DATABASE_CONNECTION in your environment.');
        }

        try {
            this._connection = JSON.parse(process.env.DATABASE_CONNECTION);
        } catch(err) {
            throw new Error('Database: (CqlDriver) Could not parse connection configuration: ' + err);
        }

        this.connect();

        return true;
    }

    async connect() {
        this.logger.debug('Database: Connecting ...');

        this._client = new cql.Client(this._connection);
        this._client.on('log', (level: string, className: string, message: string, furtherInfo: any) => {
            const loggerMethod = (level === 'verbose' ? 'debug' : level);
            this.logger[loggerMethod]('Database: (CqlDriver) (%s) %s %j', className, message, furtherInfo);
        });
    }
};
