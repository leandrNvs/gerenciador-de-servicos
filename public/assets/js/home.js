const overlay = document.querySelector('div.overlay');
const tbody = document.querySelector('tbody');
const menu = document.querySelector('div.menu');

const deleteItem = document.querySelector('div.menu a.delete-item');
const deleteForm = document.querySelector('form.delete-form');

const updateItem = document.querySelector('div.menu a.update-item');

const search = document.querySelector('form.search input');
const complete = document.querySelector('form.search div');

const URL = window.location.href;

window.addEventListener('click', function(e) {
    if(!e.target.classList.contains('menu')) {
    menu.style.display = 'none';
    if(trMarked) trMarked.removeAttribute('style');
    }
});

window.addEventListener('load', () => {
    selectLines();
})

let trMarked = null;

function selectLines()
{
    const items = document.querySelectorAll('tbody tr');

    items.forEach((item) => {
    item.addEventListener('contextmenu', function(e) {
        e.preventDefault();

        if(trMarked) trMarked.removeAttribute('style');

        const x = e.pageX;
        const y = e.pageY;

        menu.style.top = y + 'px';
        menu.style.left = x + 'px';
        menu.style.display = 'grid';

        this.style.background = '#F0F0F0';

        trMarked = this;

        updateItem.href = '/cliente/' + trMarked.dataset.id + '/alterar';
    });
    });

    deleteItem.addEventListener('click', function() {
    overlay.classList.add('active');

    const name = trMarked.children[0].textContent;
    const id = trMarked.dataset.id;

    deleteForm.id.value = id;
    deleteForm.action = '/cliente/' + id + '/apagar';

    deleteForm.querySelector('b').textContent = name;
    });

    deleteForm.querySelector('button:last-of-type').addEventListener('click', function() {
    overlay.classList.remove('active');
    });
}

search.addEventListener('keyup', async function() {
    const req = await fetch(URL + 'search', {
    method: 'POST',
    body: this.value
    });

    const res = await req.text();

    tbody.innerHTML = res;

    selectLines();
});