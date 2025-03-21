// script.js
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('commentForm');
    const messageDiv = document.getElementById('formMessage');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form data
        const formData = new FormData(form);
        const data = {
            name: formData.get('name'),
            email: formData.get('email'),
            comment: formData.get('comment')
        };
        
        // Send data to server
        fetch('send-comment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            // Show success message
            messageDiv.textContent = 'Thank you for your comment!';
            messageDiv.className = 'message success';
            messageDiv.style.display = 'block';
            
            // Reset form
            form.reset();
            
            // Hide message after 5 seconds
            setTimeout(() => {
                messageDiv.style.display = 'none';
            }, 5000);
        })
        .catch(error => {
            // Show error message
            messageDiv.textContent = 'There was an error submitting your comment. Please try again.';
            messageDiv.className = 'message error';
            messageDiv.style.display = 'block';
            
            console.error('Error:', error);
        });
    });
});
