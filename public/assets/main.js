document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.js-delete-image').forEach(item => {
        item.addEventListener('click', onDeleteImage);
    });
});

function onDeleteImage () {
    const $this = this;

    const formData = new FormData();
    formData.append('id', $this.dataset.imageId);
    fetch('/products/delete_image', {
        method: 'POST',
        body: formData
    }).then(response => {
        return response.json();
    }).then(response => {
        if (response != 1) {
            return false;
        }

        const $parent = $this.closest('.edit-image-item');
        $parent.parentNode.removeChild($parent);
    })
}