/**
 * blog.js
 * JavaScript for the homepage (index.php) blog section
 *
 * Functions: deletePost, expandPost
 */


/**
 * Delete Post Function
 *
 * Asks the user to confirm before deleting a blog post.
 * Redirects to deletePost.php with the post ID on confirmation.
 *
 * @param {number} postId - The database ID of the post to delete
 */
function deletePost(postId) {
    if (confirm('Are you sure you want to delete this post? This action cannot be undone.')) {
        window.location.href = 'deletePost.php?id=' + postId;
    }
}


/**
 * Expand Post Function
 *
 * Replaces the truncated preview with the full post body when
 * the "View More" button is clicked.
 *
 * @param {HTMLElement} button   - The clicked "View More" button
 * @param {string}      fullBody - The full text content of the blog post
 */
function expandPost(button, fullBody) {
    var postCard    = button.closest('.blog-post-card');
    var postBodyDiv = postCard.querySelector('.blog-post-body');

    // Replace the truncated preview with the full body
    postBodyDiv.innerHTML = fullBody.replace(/\n/g, '<br>');

    // Remove the "View More" button
    button.remove();
}
