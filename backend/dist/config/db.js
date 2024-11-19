"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const promise_1 = __importDefault(require("mysql2/promise"));
const config_1 = __importDefault(require("../config/config"));
const dbConnection = promise_1.default.createPool({
    host: config_1.default.db.host,
    user: config_1.default.db.user,
    password: config_1.default.db.password,
    database: config_1.default.db.database,
});
exports.default = dbConnection;
