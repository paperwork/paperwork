//@flow

const dotenv = require('dotenv');
dotenv.config();

const Koa = require('koa');
const cors = require('kcors');
const KoaRouter = require('koa-router');
const KoaPassport = require('koa-passport');
const bodyParser = require('koa-bodyparser');
const Kong = require('./Kong');

const paperframe = require('paperframe');
const Base = require('paperframe').Base;
const Router = require('paperframe').Router;
const bunyan = require('bunyan');

const packageJson = require('../package.json');

class Server extends Base {
    _server:                    Function
    _router:                    Router
    _kong:                      Kong
    _logger:                    Function

    constructor() {
        super();
        process.env.SERVICE_DIRNAME = __dirname;

        this.logger = bunyan.createLogger({
            'name': this.getEnv('SERVER_NAME'),
            'level': parseInt(this.getEnv('SERVER_LOGLEVEL'), 10)
        });


        this.logger.info('██╗   ██╗███████╗███████╗██████╗ ███████╗');
        this.logger.info('██║   ██║██╔════╝██╔════╝██╔══██╗██╔════╝');
        this.logger.info('██║   ██║███████╗█████╗  ██████╔╝███████╗');
        this.logger.info('██║   ██║╚════██║██╔══╝  ██╔══██╗╚════██║');
        this.logger.info('╚██████╔╝███████║███████╗██║  ██║███████║');
        this.logger.info(' ╚═════╝ ╚══════╝╚══════╝╚═╝  ╚═╝╚══════╝');
        this.logger.info('                                   v%s', packageJson.version);
        this.logger.info('                                         ');

        this._server = new Koa();
        this._router = new Router({
            'koaRouter': KoaRouter,
            'logger': this.logger
        });
    }

    async initialize(): Promise<boolean> {
        try {
            this.logger.debug('Server: Initializing Router ...');
            this._router.initialize();

            this.logger.debug('Server: Initializing CORS ...');
            this._server.use(cors());

            this.logger.debug('Server: Initializing BodyParser ...');
            this._server.use(bodyParser({
                'formLimit': this.getEnv('SERVER_BODYPARSER_FORMLIMIT'),
                'jsonLimit': this.getEnv('SERVER_BODYPARSER_JSONLIMIT'),
                'textLimit': this.getEnv('SERVER_BODYPARSER_TEXTLIMIT')
            }));

            this.logger.debug('Server: Initializing Passport ...');
            this._server.use(KoaPassport.initialize());

            const routesAcl: Object = this._router.routesAcl();
            this._server.use(this._router.authorization(routesAcl));

            this.logger.debug('Server: Applying routes ...');
            this._server.use(this._router.routes());

            this._kong = new Kong({
                'logger': this.logger
            });

            await this._kong.initialize();

            return true;
        } catch(error) {
            this.logger.error(error);
            return false;
        }
    }

    async run() {
        const status = await this.initialize();

        if(status === false) {
            const exitCode = -1;
            process.exit(exitCode);
        }

        this.logger.info('Server: Starting on port %s', this.getEnv('SERVER_PORT'));
        this._server.listen(this.getEnv('SERVER_PORT'));
    }
}

const service = new Server();
service.run();
