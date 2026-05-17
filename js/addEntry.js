/**
 * addEntry.js
 * JavaScript for the Add Blog Entry page (addEntry.php)
 *
 * Assessment Criteria 4: Clear button event processing with confirm dialog
 * Assessment Criteria 5: Form validation with preventDefault() and CSS highlighting
 * Extra Feature: Preview button functionality
 */


/**
 * Form Validation Function
 *
 * Validates the blog entry form before submission.
 * Uses preventDefault() to stop submission if fields are blank.
 * Highlights missing fields with CSS styles (red border + background).
 *
 * @param {Event} event - The form submit event
 */
function validateForm(event) {
    const titleInput = document.getElementById('post-title');
    const postInput  = document.getElementById('post-body');
    const titleError = document.getElementById('title-error');
    const postError  = document.getElementById('post-error');

    let isValid = true;

    // Check title field
    if (titleInput.value.trim() === '') {
        titleError.style.display = 'block';
        titleInput.classList.add('field-invalid');
        isValid = false;
    } else {
        titleError.style.display = 'none';
        titleInput.classList.remove('field-invalid');
    }

    // Check post body field
    if (postInput.value.trim() === '') {
        postError.style.display = 'block';
        postInput.classList.add('field-invalid');
        isValid = false;
    } else {
        postError.style.display = 'none';
        postInput.classList.remove('field-invalid');
    }

    // Prevent form submission if validation fails
    if (!isValid) {
        event.preventDefault();
        return false;
    }

    return true;
}


/**
 * Clear Form Function
 *
 * Shows a confirm dialog before clearing the form, as per the spec:
 * "If OK is chosen, the inputs in the text box and text area will be cleared.
 *  If Cancel is clicked, then the content won't be cleared."
 *
 * Assessment Criteria 4: Clear button event processing
 */
function clearForm() {
    // Show confirm dialog - user must explicitly choose OK
    var confirmed = confirm('Are you sure you want to clear the form? All unsaved content will be lost.');

    if (confirmed) {
        // User clicked OK - clear the fields
        document.getElementById('post-title').value = '';
        document.getElementById('post-body').value  = '';

        // Remove error highlights
        document.getElementById('title-error').style.display = 'none';
        document.getElementById('post-error').style.display  = 'none';
        document.getElementById('post-title').classList.remove('field-invalid');
        document.getElementById('post-body').classList.remove('field-invalid');
    }
    // If Cancel, do nothing - content is preserved
}


/**
 * Preview Post Function
 *
 * Validates the form and displays a preview modal of the blog post.
 * Extra Feature: Preview button with functional Publish / Back-to-edit links.
 */
function previewPost() {
    const titleInput = document.getElementById('post-title');
    const postInput  = document.getElementById('post-body');

    // Basic validation before preview
    if (titleInput.value.trim() === '' || postInput.value.trim() === '') {
        alert('Please fill in both the title and post content before previewing.');
        return;
    }

    // Populate preview modal
    document.getElementById('previewTitle').textContent = titleInput.value;
    document.getElementById('previewBody').textContent  = postInput.value;

    // Show current date/time as a preview timestamp
    const now     = new Date();
    const dateStr = now.toLocaleDateString('en-GB', { year: 'numeric', month: 'long', day: 'numeric' });
    const timeStr = now.toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' });
    document.getElementById('previewDate').textContent = 'Posted on ' + dateStr + ' at ' + timeStr;

    // Show the modal
    document.getElementById('previewModal').style.display = 'flex';
}


/**
 * Close Preview Modal
 */
function closePreview() {
    document.getElementById('previewModal').style.display = 'none';
}


/**
 * Submit Form from Preview Modal
 * Allows user to publish after reviewing the preview.
 */
function submitForm() {
    document.getElementById('addEntryForm').submit();
}


// Live input listeners - remove error highlight as soon as user starts typing
document.addEventListener('DOMContentLoaded', function () {

    document.getElementById('post-title').addEventListener('input', function () {
        if (this.value.trim() !== '') {
            document.getElementById('title-error').style.display = 'none';
            this.classList.remove('field-invalid');
        }
    });

    document.getElementById('post-body').addEventListener('input', function () {
        if (this.value.trim() !== '') {
            document.getElementById('post-error').style.display = 'none';
            this.classList.remove('field-invalid');
        }
    });

});
