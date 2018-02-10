//@flow

const dotenv = require('dotenv');
dotenv.config();

const Koa = require('koa');
const cors = require('kcors');
const KoaRouter = require('koa-router');
const KoaPassport = require('koa-passport');
const bodyParser = require('koa-bodyparser');
const KoaJwt = require('koa-jwt');

const paperframe = require('paperframe');
const Base = require('paperframe').Base;
const Router = require('paperframe').Router;
const bunyan = require('bunyan');

const packageJson = require('../package.json');

class Server extends Base {
    _server:                    Function
    _router:                    Router
    _logger:                    Function

    constructor() {
        super();
        process.env.SERVICE_DIRNAME = __dirname;

        this.logger = bunyan.createLogger({
            'name': process.env.SERVER_NAME,
            'level': parseInt(process.env.SERVER_LOGLEVEL, 10)
        });

        this.logger.info('████╗  ███╗ ████╗ ██████╗████╗ █╗    █╗ ████╗ ████╗ █╗  █╗');
        this.logger.info('█╔══█╗█╔══█╗█╔══█╗█╔════╝█╔══█╗█║    █║█╔═══█╗█╔══█╗█║ █╔╝');
        this.logger.info('████╔╝█████║████╔╝████╗  ████╔╝█║ █╗ █║█║   █║████╔╝███╔╝ ');
        this.logger.info('█╔══╝ █╔══█║█╔══╝ █╔══╝  █╔══█╗█║███╗█║█║   █║█╔══█╗█╔═█╗ ');
        this.logger.info('█║    █║  █║█║    ██████╗█║  █║╚██╔██╔╝╚████╔╝█║  █║█║  █╗');
        this.logger.info('╚╝    ╚╝  ╚╝╚╝    ╚═════╝╚╝  ╚╝ ╚═╝╚═╝  ╚═══╝ ╚╝  ╚╝╚╝  ╚╝');
        this.logger.info('                                                    v%s', packageJson.version);
        this.logger.info('                                                          ');

        this._server = new Koa();
        this._router = new Router({
            'koaRouter': KoaRouter,
            'jwtHandler': KoaJwt,
            'logger': this.logger
        });
    }

    initialize() {
        this.logger.debug('Server: Initializing Router ...');
        this._router.initialize();

        this.logger.debug('Server: Initializing CORS ...');
        this._server.use(cors());

        this.logger.debug('Server: Initializing BodyParser ...');
        this._server.use(bodyParser({
            'formLimit': process.env.SERVER_BODYPARSER_FORMLIMIT,
            'jsonLimit': process.env.SERVER_BODYPARSER_JSONLIMIT,
            'textLimit': process.env.SERVER_BODYPARSER_TEXTLIMIT
        }));

        this.logger.debug('Server: Initializing Passport ...');
        this._server.use(KoaPassport.initialize());

        const routesAcl: Object = this._router.routesAcl();
        this._server.use(this._router.authorization(routesAcl));

        this.logger.debug('Server: Applying routes ...');
        this._server.use(this._router.routes());
    }

    run() {
        this.logger.info('Server: Starting on port %s', process.env.SERVER_PORT);
        this._server.listen(process.env.SERVER_PORT);
    }
}

const paperworkCore = new Server();
paperworkCore.initialize();
paperworkCore.run();
