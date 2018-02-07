//@flow


const UserController = require('./Controllers/UserController');
const UserAuthLocalController = require('./Controllers/UserAuthLocalController');

module.exports.controllers = [
    UserController,
    UserAuthLocalController
];
