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

    public function savingNotes() {

    }

    public function displayingNotes() {

    }
}