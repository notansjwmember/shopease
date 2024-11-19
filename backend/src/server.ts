import express, { Request, Response } from "express";
import config from "./config/config";

// Import routes
import authRoutes from "./routes/authRoutes";

const app = express();
app.use(express.json()); 

// Use the routes
app.use("/api/auth", authRoutes);

app.get("/", (req: Request, res: Response) => {
  res.send("Server is running");
});

const PORT = config.port || 5000;
app.listen(PORT, () => {
  console.log(`Server running at http://localhost:${PORT}`);
});
