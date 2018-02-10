//@flow

import type {
    ControllerParams
} from 'paperframe';

const JsonController = require('paperframe').JsonController;

const Joi = require('joi');
const HttpStatus = require('http-status-codes');
const busboy = require('async-busboy');

module.exports = class PaperworkController extends JsonController {
    validate(params: ControllerParams, schema: Object): ControllerParams {
        const validationResult = Joi.validate(params.body, schema);
        if(validationResult.error === null) {
            params.body = validationResult.value;
            return params;
        }

        this.response(HttpStatus.BAD_REQUEST, module.exports.RS_REQUEST_VALIDATION_FAILED, validationResult.error.details);
        throw validationResult.error;
    }
};
