const express = require("express");
const router = express.Router();
const pool = require("../config/database");

// GET semua mahasiswa
router.get("/", async (req, res) => {
  try {
    const connection = await pool.getConnection();
    const [rows] = await connection.query("SELECT * FROM mahasiswa");
    connection.release();
    res.json(rows);
  } catch (error) {
    res.status(500).json({ message: error.message });
  }
});

// GET mahasiswa berdasarkan ID
router.get("/:id", async (req, res) => {
  try {
    const connection = await pool.getConnection();
    const [rows] = await connection.query(
      "SELECT * FROM mahasiswa WHERE id = ?",
      [req.params.id]
    );
    connection.release();
    if (rows.length === 0) {
      return res.status(404).json({ message: "Mahasiswa tidak ditemukan" });
    }
    res.json(rows[0]);
  } catch (error) {
    res.status(500).json({ message: error.message });
  }
});

// POST tambah mahasiswa baru
router.post("/", async (req, res) => {
  const { nim, nama, email, jurusan } = req.body;
  try {
    const connection = await pool.getConnection();
    await connection.query(
      "INSERT INTO mahasiswa (nim, nama, email, jurusan) VALUES (?, ?, ?, ?)",
      [nim, nama, email, jurusan]
    );
    connection.release();
    res.status(201).json({ message: "Mahasiswa berhasil ditambahkan" });
  } catch (error) {
    res.status(500).json({ message: error.message });
  }
});

// PUT update mahasiswa
router.put("/:id", async (req, res) => {
  const { nim, nama, email, jurusan } = req.body;
  try {
    const connection = await pool.getConnection();
    await connection.query(
      "UPDATE mahasiswa SET nim = ?, nama = ?, email = ?, jurusan = ? WHERE id = ?",
      [nim, nama, email, jurusan, req.params.id]
    );
    connection.release();
    res.json({ message: "Mahasiswa berhasil diperbarui" });
  } catch (error) {
    res.status(500).json({ message: error.message });
  }
});

// DELETE mahasiswa
router.delete("/:id", async (req, res) => {
  try {
    const connection = await pool.getConnection();
    await connection.query("DELETE FROM mahasiswa WHERE id = ?", [
      req.params.id,
    ]);
    connection.release();
    res.json({ message: "Mahasiswa berhasil dihapus" });
  } catch (error) {
    res.status(500).json({ message: error.message });
  }
});

module.exports = router;
