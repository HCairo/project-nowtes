<?php
namespace Views;

class NotesView {
    public function renderNotes($notes) {
        echo '<h2>Saved Notes</h2>';
        if (!empty($notes)) {
            foreach ($notes as $note) {
                echo '<div>' . htmlspecialchars($note) . '</div>';
            }
        } else {
            echo '<div>No notes available.</div>';
        }
    }

    public function initForm() {
        echo '
        <form method="post" action="">
            <textarea name="note" rows="10" cols="50"></textarea><br>
            <button type="submit">Save Notes</button>
        </form>';
    }
}