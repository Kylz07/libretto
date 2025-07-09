document.addEventListener('DOMContentLoaded', function() {
    var deleteModal = document.getElementById('deleteAuthorModal');
    var deleteAuthorForm = document.getElementById('deleteAuthorForm');
    var modalAuthorName = document.getElementById('modalAuthorName');

    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var authorIdToDelete = button.getAttribute('data-author-id');
        var authorName = button.getAttribute('data-author-name');
        deleteAuthorForm.action = "/authors/" + authorIdToDelete;
        modalAuthorName.textContent = authorName;
    });
});