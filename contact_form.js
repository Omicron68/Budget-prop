document.addEventListener('DOMContentLoaded', () => {
    // Get the contact form element
    const contactForm = document.getElementById('contactForm');

    // Add a submit event listener
    contactForm.addEventListener('submit', async (event) => {
        // Prevent the default form submission (page reload)
        event.preventDefault();

        // Get the form data
        const formData = new FormData(contactForm);

        try {
            // Send the data to the PHP backend
            const response = await fetch('submit_form.php', {
                method: 'POST',
                body: formData,
            });

            const result = await response.json();

            // Check the response from the server
            if (result.success) {
                alert('Success: ' + result.message);
                contactForm.reset(); // Clear the form
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            alert('An error occurred. Please try again.');
            console.error('Fetch error:', error);
        }
    });
});