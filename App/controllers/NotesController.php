<?php
namespace Controllers;

use Models\NotesModel;
use Views\NotesView;

class NotesController {
    protected $notesModel;
    protected $notesView;

    public function __construct() {
        $this->notesModel = new NotesModel();
        $this->notesView = new NotesView();
    }

    // Action to handle saving notes
    public function saveNotes() {
        // Get the notes from the POST request
        $notes = $_POST['notes'];

        // Pass the notes to the model to save
        $this->notesModel->saveNotes($notes);

        // Redirect or return response as needed
    }

    // Action to handle displaying notes
    public function displayNotes() {
        // Retrieve notes from the model
        $notes = $this->notesModel->getNotes();

        // Pass notes to the view for rendering
        $this->notesView->renderNotes($notes);
    }
}