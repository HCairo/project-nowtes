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

    public function savingNotes($note) {
        $this->notesModel->saveNotes($note);
    }

    public function displayingNotes() {
        $notes = $this->notesModel->displayNotes();
        $this->notesView->renderNotes($notes);
    }

    public function displayFormAndNotes() {
        // Display the form
        $this->notesView->initForm();
        // Display the notes
        $this->displayingNotes();
    }
}