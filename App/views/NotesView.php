<?php
namespace Views;

class NotesView {
    public function renderNotes() {
        echo '
        <script src="/assets/js/storeMyNotes.js"></script>
        ' . $this->initForm() . '';
    }

    public function initForm() {
        return '
        <form>
            <textarea id="notes" rows="10" cols="50"></textarea><br>
            <button type="button" onclick="localSaveNotes()">Save Notes</button>
        </form>';
    }
}