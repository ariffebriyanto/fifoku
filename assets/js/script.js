// Wait for the DOM to fully load
document.addEventListener("DOMContentLoaded", function() {
    
    // Example: Toggle visibility of an element when a button is clicked
    const toggleButton = document.getElementById('toggleButton');
    const toggleContent = document.getElementById('toggleContent');
    
    if (toggleButton) {
        toggleButton.addEventListener('click', function() {
            toggleContent.classList.toggle('hidden');
        });
    }

    // Example: Form validation for a simple form
    const form = document.getElementById('myForm');
    
    if (form) {
        form.addEventListener('submit', function(event) {
            const nameInput = document.getElementById('name');
            if (nameInput && nameInput.value.trim() === '') {
                alert('Name is required!');
                event.preventDefault(); // Prevent form submission
            }
        });
    }
    
    // Example: Smooth scroll for anchor links
    const smoothScrollLinks = document.querySelectorAll('a[href^="#"]');
    
    smoothScrollLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            target.scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
    
    // Example: Update the year dynamically in the footer (e.g., copyright)
    const yearElement = document.getElementById('currentYear');
    if (yearElement) {
        const currentYear = new Date().getFullYear();
        yearElement.textContent = currentYear;
    }
});
