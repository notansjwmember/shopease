import { Request, Response } from "express";
import { RowDataPacket } from "mysql2";

import bcrypt from "bcryptjs";
import jwt from "jsonwebtoken";
import db from "../config/db";
import config from "../config/config";

export const registerUser = async (req: Request, res: Response): Promise<void> => {
  const { username, password } = req.body;

  if (!username || !password) {
    res.status(400).json({ error: "Username and password are required" });
    return;
  }

  try {
    const [existingUser] = await db.execute("SELECT * FROM users WHERE username = ?", [
      username,
    ]);

    const existingUserRows = existingUser as RowDataPacket[];

    if (existingUserRows.length > 0) {
      res.status(409).json({ error: "Username already exists" });
      return;
    }

    const hashedPassword = await bcrypt.hash(password, 10);

    const [result] = await db.execute("INSERT INTO users (username, password) VALUES (?, ?)", [
      username,
      hashedPassword,
    ]);

    res.status(201).json({
      message: "User registered successfully",
      userId: (result as any).insertId,
    });
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: "Server error" });
    return;
  }
};

export const loginUser = async (req: Request, res: Response): Promise<void> => {
  const { username, password } = req.body;

  if (!username || !password) {
    res.status(400).json({ error: "Username and password are required" });
    return;
  }

  try {
    const [user] = await db.execute("SELECT * FROM users WHERE username = ?", [username]);

    const userRows = user as RowDataPacket[];

    if (userRows.length === 0) {
      res.status(401).json({ error: "Invalid credentials" });
      return;
    }

    const isMatch = await bcrypt.compare(password, userRows[0].password);
    if (!isMatch) {
      res.status(401).json({ error: "Invalid credentials" });
      return;
    }

    if (!config.jwtSecret) {
      res.status(500).json({ error: "JWT secret is not defined" });
      return;
    }

    const token = jwt.sign(
      { userId: userRows[0].id, username: userRows[0].username },
      config.jwtSecret,
      { expiresIn: "1h" }
    );

    res.status(200).json({ message: "Login successful", token });
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: "Server error" });
    return;
  }
};
