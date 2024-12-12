const actionsEl = document.querySelector('div.actions');

window.addEventListener('click', function(e) {

  if(!e.target.classList.contains('actions') && !actionsEl) {
    activeEl.classList.remove('marked');

    actionsEl.classList.remove('active');
    actionsEl.removeAttribute('style');
  }

});

let activeEl = null;

function actions(e, el) {
  e.preventDefault();

  if(activeEl) activeEl.classList.remove('marked');

  const scrollY = window.scrollY;
  const x = e.pageX;
  const y = e.pageY;

  el.classList.add('marked');
  activeEl = el;

  actionsEl.classList.add('active');
  actionsEl.style.top = `${y - scrollY}px`;
  actionsEl.style.left = `${x}px`;

  actionsEl.querySelector('a.actions-update').href = el.dataset.update;
  deleteConfirm.action = el.dataset.delete;
}

const overlay = document.querySelector('div.overlay');
const deleteConfirm = overlay.querySelector('form');
const formLabel = deleteConfirm.querySelector('b.label');

function showConfirmDeleteBox()
{
  overlay.classList.add('active');
  deleteConfirm.id.value = activeEl.dataset.id;
  formLabel.textContent = activeEl.dataset.name;
}

function closeConfirmDeleteBox()
{
  overlay.classList.remove('active');
  deleteConfirm.id.value = null;
  formLabel.textContent = null;
}

const formComplete = document.querySelector('form.form-toggleComplete');

function toggleComplete()
{
  formComplete.id.value = activeEl.dataset.id;
  formComplete.action = activeEl.dataset.completed
  formComplete.submit();
}
