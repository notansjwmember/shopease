import mysql from "mysql2/promise";
import config from "../config/config";

const dbConnection = mysql.createPool({
  host: config.db.host,
  user: config.db.user,
  password: config.db.password,
  database: config.db.database,
});

export default dbConnection;
