const express = require('express');
const Appointment = require('../models/Appointment');
const router = express.Router();

// Get all appointments
router.get('/', async (req, res) => {
  try {
    const appointments = await Appointment.find().populate('petId');
    res.json(appointments);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// Create an appointment
router.post('/', async (req, res) => {
  const { petId, date, time } = req.body;
  try {
    const appointment = new Appointment({ petId, date, time });
    await appointment.save();
    res.status(201).json(appointment);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

module.exports = router;
