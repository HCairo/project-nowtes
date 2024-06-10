// Function to save notes to local storage
function saveNotes() {
    // Get the notes from the textarea
    let notes = document.getElementById('notes').value;
    
    // Store the notes in local storage
    localStorage.setItem('notes', notes);
    
    alert('Notes saved successfully!');
}

// Function to retrieve notes from local storage
function getNotes() {
    // Retrieve the notes from local storage
    let notes = localStorage.getItem('notes');
    
    // Check if notes exist in local storage
    if(notes) {
        // Display the notes in the textarea
        document.getElementById('notes').value = notes;
    }
}

// Call getNotes function when the page loads
window.onload = getNotes;
