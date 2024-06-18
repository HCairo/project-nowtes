<?php
namespace Models;

class NotesModel {
    public function saveNotes($note) {
        // Save note to cookies
        $notes = isset($_COOKIE['notes']) ? unserialize($_COOKIE['notes']) : [];
        $notes[] = $note;
        setcookie('notes', serialize($notes), time() + (86400 * 30), "/"); // Expires in 30 days
    }

    public function displayNotes() {
        // Retrieve notes from cookies
        return isset($_COOKIE['notes']) ? unserialize($_COOKIE['notes']) : [];
    }
}