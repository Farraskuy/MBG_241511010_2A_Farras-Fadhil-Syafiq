window.addEventListener('DOMContentLoaded', () => {

    document.querySelector('.btn-toggle-sidebar').addEventListener('click', () => {
        document.querySelector('.layout-wrapper').classList.toggle('hide-sidebar');
    })

});