"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.loginUser = exports.registerUser = void 0;
const bcryptjs_1 = __importDefault(require("bcryptjs"));
const jsonwebtoken_1 = __importDefault(require("jsonwebtoken"));
const db_1 = __importDefault(require("../config/db"));
const config_1 = __importDefault(require("../config/config"));
const registerUser = (req, res) => __awaiter(void 0, void 0, void 0, function* () {
    const { username, password } = req.body;
    if (!username || !password) {
        res.status(400).json({ error: "Username and password are required" });
        return;
    }
    try {
        const [existingUser] = yield db_1.default.execute("SELECT * FROM users WHERE username = ?", [
            username,
        ]);
        const existingUserRows = existingUser;
        if (existingUserRows.length > 0) {
            res.status(409).json({ error: "Username already exists" });
            return;
        }
        const hashedPassword = yield bcryptjs_1.default.hash(password, 10);
        const [result] = yield db_1.default.execute("INSERT INTO users (username, password) VALUES (?, ?)", [
            username,
            hashedPassword,
        ]);
        res.status(201).json({
            message: "User registered successfully",
            userId: result.insertId,
        });
    }
    catch (err) {
        console.error(err);
        res.status(500).json({ error: "Server error" });
        return;
    }
});
exports.registerUser = registerUser;
const loginUser = (req, res) => __awaiter(void 0, void 0, void 0, function* () {
    const { username, password } = req.body;
    if (!username || !password) {
        res.status(400).json({ error: "Username and password are required" });
        return;
    }
    try {
        const [user] = yield db_1.default.execute("SELECT * FROM users WHERE username = ?", [username]);
        const userRows = user;
        if (userRows.length === 0) {
            res.status(401).json({ error: "Invalid credentials" });
            return;
        }
        const isMatch = yield bcryptjs_1.default.compare(password, userRows[0].password);
        if (!isMatch) {
            res.status(401).json({ error: "Invalid credentials" });
            return;
        }
        if (!config_1.default.jwtSecret) {
            res.status(500).json({ error: "JWT secret is not defined" });
            return;
        }
        const token = jsonwebtoken_1.default.sign({ userId: userRows[0].id, username: userRows[0].username }, config_1.default.jwtSecret, { expiresIn: "1h" });
        res.status(200).json({ message: "Login successful", token });
    }
    catch (err) {
        console.error(err);
        res.status(500).json({ error: "Server error" });
        return;
    }
});
exports.loginUser = loginUser;
