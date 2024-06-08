const express = require('express');
const Pet = require('../models/Pet');
const router = express.Router();

// Get all pets
router.get('/', async (req, res) => {
  try {
    const pets = await Pet.find();
    res.json(pets);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// Create a pet profile
router.post('/', async (req, res) => {
  const { name, ownerName, ownerContact, petType, breed, age } = req.body;
  try {
    const pet = new Pet({ name, ownerName, ownerContact, petType, breed, age });
    await pet.save();
    res.status(201).json(pet);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

module.exports = router;
