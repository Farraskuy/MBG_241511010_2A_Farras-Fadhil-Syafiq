window.addEventListener('DOMContentLoaded', () => {

    // loading icon element
    const loadingIcon = document.createElement('i');
    loadingIcon.classList.add("fa-solid", "fa-spinner-third", "fa-spin");


    function clearAlert(parentElement) {
        if (!parentElement.prepend) {
            return
        }

        parentElement.querySelectorAll('.alert').forEach((alert) => {
            alert.remove();
        });
    }

    function showAlertOn(parentElement, message, type = 'success') {
        if (!parentElement.prepend && !message) {
            return
        }

        clearAlert(parentElement);

        const alert = document.createElement('div');
        alert.classList.add('alert', `alert-${type}`);

        alert.innerHTML = message;

        parentElement.prepend(alert);
    }

    function fillTableData(datas) {
        const tableHeadLength = document.querySelector('table thead').firstElementChild.children.length;
        const tbody = document.querySelector('tbody#tbody');

        tbody.innerHTML = ""
        datas.forEach((data) => {
            const tr = document.createElement('tr');

            tr.innerHTML = rowTableDataTemplate(data);
            tr.querySelector('form')?.addEventListener('submit', submitHandler);

            tbody.appendChild(tr);
        });

        if (datas.length == 0) {
            const tr = document.createElement('tr');
            const td = document.createElement('td');

            td.setAttribute('colspan', tableHeadLength);
            td.style.padding = 0;
            td.innerHTML = `
                <div class="d-flex justify-content-center w-100 bg-white">
                    <img src="${baseURL}assets/img/white-sign-that-says-no-results-found_637684-372.jpg" 
                        class="w-100 object-fit-contain" style="max-height:400px">
                </div>
            `;

            tr.appendChild(td);
            tbody.appendChild(tr);
        }
    }


    /* -------------------------------------------------------------------------- */
    /*                        Form Submit Hanlder                                 */
    /* -------------------------------------------------------------------------- */

    const submitHandler = (e) => {
        e.preventDefault();

        const form = e.target;

        // disabled button
        const button = form.querySelector('button[type="submit"]');
        if (button) {
            button.disabled = true;
            button.appendChild(loadingIcon);
        }

        // celar alert 
        clearAlert(form);

        // form url 
        const url = new URL(form.getAttribute('action') || currentURL);

        // form method 
        let method = form.getAttribute('method') || 'get';
        let inputMethod = form.querySelector('input[name="_method"]')

        if (inputMethod) {
            method = inputMethod.value;
        }

        method = method.toUpperCase();

        // dapatkan form input
        let formInput = form.querySelectorAll('input');
        let formData = {};
        formInput.forEach((input) => {
            formData[input.getAttribute('name')] = input.value;
            input.classList.remove('is-invalid');

            if (method == 'GET') url.searchParams.append(input.getAttribute('name'), input.value);
        });

        // fetch option 
        const fetchOption = {
            method,
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            }
        }

        if (method != 'GET') fetchOption['body'] = JSON.stringify(formData);

        fetch(url, fetchOption)
            .then(response => response.json())
            .then(async (data) => {
                if (data?.data && method == 'GET') {
                    fillTableData(data.data);
                }

                if (data.error && form.hasAttribute('alert')) {
                    showAlertOn(form, data.error, 'danger');
                }

                if (data.validation) {
                    for (let [key, message] of Object.entries(data.validation)) {
                        const input = form.querySelector(`input[name="${key}"]`);
                        input.classList.add("is-invalid");

                        const parentNode = input.parentElement;
                        if (!parentNode.querySelector(".invalid-feedback")) {
                            const invalidFeedback = document.createElement('div');
                            invalidFeedback.classList.add('invalid-feedback');

                            parentNode.append(invalidFeedback);
                        }
                        parentNode.querySelector(".invalid-feedback").innerHTML = message;
                    }
                }

                if (data.closeModal) {
                    const modalEl = form.closest(".modal");
                    if (modalEl) {
                        let bsModal = bootstrap.Modal.getInstance(modalEl);
                        if (!bsModal) {
                            bsModal = new bootstrap.Modal(modalEl);
                        }
                        bsModal.hide();
                    }

                    showAlertOn(document.querySelector("table").parentElement, data.message, 'success');

                    regenerateData()
                }

                if (data.redirect_to) {
                    window.location.assign(data.redirect_to);
                    return
                }
            })
            .catch((err) => {
                console.log(err);
            }).finally(() => {
                if (button) {
                    button.disabled = false;
                    button.querySelector('.fa-spinner-third').remove();
                }
            });
    }

    document.querySelectorAll('form').forEach((form) => {
        form.addEventListener('submit', submitHandler);
    });

    /* -------------------------------------------------------------------------- */
    /*                        Display data handler                                */
    /* -------------------------------------------------------------------------- */


    function regenerateData() {
        fetch(currentURL + '?keyword=' + document.querySelector('.search input[name="keyword"]').value, {
            method: 'GET',
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            },
        })
            .then((response) => response.json())
            .then((data) => {
                fillTableData(data.data);
            });
    }

    if (typeof rowTableDataTemplate === "function") {
        regenerateData();
    }

    // search
    const formSearch = document.querySelector('form.search');
    if (formSearch) {
        const inputSearch = formSearch.querySelector('input');
        let timeOut;
        inputSearch.addEventListener('input', () => {
            clearTimeout(timeOut);

            timeOut = setTimeout(() => {
                formSearch.querySelector('button').click();
            }, 1000);
        });
    }
});