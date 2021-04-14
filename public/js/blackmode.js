const btnToggle = document.querySelector('.btn-toggle');

btnToggle.addEventListener('click', () => {

    const body = document.body;
    body.classList.add('light');

    if(body.classList.contains('dark')){

        body.classList.add('light');
        body.classList.remove('dark');
        btnToggle.innerHTML = "Go Dark";

    } else if(body.classList.contains('light')){

        body.classList.add('dark');
        body.classList.remove('light');
        btnToggle.innerHTML = "Go Light";

    }

})
