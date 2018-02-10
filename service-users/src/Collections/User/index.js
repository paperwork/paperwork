//@flow


const Collection = require('paperframe').Collection;

const drivers = {
    'cql': require('./Cql')
};

module.exports = class User extends Collection.auto('user', drivers) {
};
