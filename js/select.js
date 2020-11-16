function createMenu(selectGenre){
  
  let b-name = document.getElementById('bname');
  bname.disabled = false;
  bname.innerHTML = '';
  let option = document.createElement('option');
  option.innerHTML = 'バンド名';
  option.defaultSelected = true;
  option.disabled = true;
  bname.appendChild(option);  
  
  js3[selectGenre].forEach( name => {
    let option = document.createElement('option');
    option.innerHTML = name;
    option.value = name;
    bname.appendChild(option);  
  });    
}