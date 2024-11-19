import { Request, Response, NextFunction } from "express";
import jwt from "jsonwebtoken";
import config from "../config/config";

interface AuthenticatedRequest extends Request {
  userId?: number;
  username?: string;
}

const authMiddleware = (req: AuthenticatedRequest, res: Response, next: NextFunction) => {
  const token = req.headers["authorization"]?.split(" ")[1];

  if (!token) {
    return res.status(401).json({ error: "No token provided" });
  }

  try {
    if (!config.jwtSecret) {
      res.status(500).json({ error: "JWT secret is not defined" });
      return;
    }

    const decoded = jwt.verify(token, config.jwtSecret);

    req.userId = (decoded as any).userId;
    req.username = (decoded as any).username;
    next();
  } catch (err) {
    return res.status(401).json({ error: "Invalid or expired token" });
  }
};

export default authMiddleware;
