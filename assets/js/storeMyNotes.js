function localSaveNotes() {
    // Recuperation pour stockage de la note dans le localstorage
    let notes = document.getElementById('notes').value;
    
    // Stockage des notes dans le localstorage
    localStorage.setItem('notes', notes);
    
    alert('Notes saved successfully!');
}

function getNotesFromLocal() {
    // Recuperation des notes depuis localstorage
    let notes = localStorage.getItem('notes');
    
    // Check si les notes existent dans le localstorage
    if(notes) {
        // Affichage des notes dans notre textarea
        document.getElementById('notes').value = notes;
    }
}

// Appel de la fonction pour charger et display les notes au chargement de la page
window.onload = getNotesFromLocal;