const checkboxes = Array.from(document.querySelectorAll('input[type="checkbox"]'));

document.querySelector('form').addEventListener('submit', (event)=>{
  event.preventDefault();
  const postsToDelete = checkboxes
    .filter(checkbox=>checkbox.checked)
    .map(checkbox=>checkbox.value);
  if(postsToDelete.length === 0)
    alert('Please select some posts for deletion');
  else if(
    confirm(
      `Are you you want to delete the following posts?\n${postsToDelete.join('\n')}`
    )
  )
    Promise.all(
      postsToDelete.map(id=>
        fetch(`../post/delete/?id=${id}`)
      )
    )
      .then(()=>{ window.location = '../'; })
      .catch(console.error);
});

