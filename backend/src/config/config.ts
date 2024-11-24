import * as dotenv from "dotenv";
dotenv.config();

export default {
  db: {
    host: process.env.DB_HOST,
    user: process.env.DB_USER,
    password: process.env.DB_PASSWORD,
    database: process.env.DB_NAME,
  },
  port: process.env.PORT || 5000,
  jwtSecret: process.env.JWT_SECRET,
};
