// Dynamic background tracking
document.addEventListener('mousemove', (e) => {
    document.documentElement.style.setProperty('--mouse-x', `${e.clientX}px`);
    document.documentElement.style.setProperty('--mouse-y', `${e.clientY}px`);
  });
  
  // Modal functionality for note cards
  document.addEventListener('DOMContentLoaded', () => {
    const noteCards = document.querySelectorAll('.note-card');
    const modal = document.getElementById('noteModal');
    const modalNoteTitle = document.getElementById('modalNoteTitle');
    const modalNoteModule = document.getElementById('modalNoteModule');
    const modalNoteContent = document.getElementById('modalNoteContent');
    const closeModal = document.querySelector('.close-modal');
  
    if (noteCards) {
      noteCards.forEach(card => {
        card.addEventListener('click', () => {
          const title = card.getAttribute('data-note-title');
          const module = card.getAttribute('data-note-module');
          const content = card.getAttribute('data-note-content');
          modalNoteTitle.innerText = title;
          modalNoteModule.innerText = "Module: " + module;
          modalNoteContent.innerText = content;
          modal.style.display = 'block';
        });
      });
    }
    
    if (closeModal) {
      closeModal.addEventListener('click', () => {
        modal.style.display = 'none';
      });
    }
    
    window.addEventListener('click', (e) => {
      if (e.target == modal) {
        modal.style.display = 'none';
      }
    });
  });