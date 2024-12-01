document.addEventListener("DOMContentLoaded", function () {
    // Attach event listeners to all submit buttons for comments
    document.querySelectorAll(".submit-comment").forEach((button) => {
        button.addEventListener("click", function () {
            const form = this.closest(".comment-form");
            const postId = form.getAttribute("data-post-id");
            const commentText = form.querySelector("textarea").value;

            if (commentText.trim() === "") {
                alert("Comment cannot be empty!");
                return;
            }

            const formData = new FormData();
            formData.append("submit_comment", postId);
            formData.append("comment", commentText);

            fetch("../../blog/public/comment_handler.php", {
                method: "POST",
                body: formData,
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        // Clear the comment textarea
                        form.querySelector("textarea").value = "";

                        // Update comments section dynamically
                        const commentSection = document.getElementById(
                            `comments-${postId}`
                        );
                        const newComment = document.createElement("div");
                        newComment.classList.add("comment");
                        newComment.innerHTML = `
                            <strong>${data.full_name}:</strong> 
                            ${data.comment} 
                            <small>${data.created_at}</small>`;
                        commentSection.prepend(newComment);
                    } else {
                        alert("Failed to post comment. Please try again.");
                    }
                })
                .catch((error) => console.error("Error:", error));
        });
    });
});
