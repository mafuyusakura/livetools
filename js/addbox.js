
var t = 2 ;
function addForm() {
  if (t >= 13) {
    alert('これ以上増やせません。');
    exit;
  }

  let table = document.getElementById('memberform');
  let newRow = table.insertRow();
  
  let newCell = newRow.insertCell();
  let newText = document.createTextNode('メンバー');
  newCell.appendChild(newText);
  
  newCell = newRow.insertCell();
  var select_data = document.createElement('select');
  select_data.name = 'part_' + t;
  select_data.id = 'option_' + t;
  select_data.required = 'select_data.';
  newCell.appendChild(select_data);

  for (let i = 0; i < js.length; i++) {
    var option = document.getElementById('option_' + t);
    var option_data = document.createElement('option');
    option_data.text = js[i];
    option_data.value = js[i];
    option.appendChild(option_data);
  }

  newCell = newRow.insertCell();
  var input_data = document.createElement('input');
  input_data.type = 'text';
  input_data.name = 'member_' + t;
  input_data.placeholder = '名前';
  newCell.appendChild(input_data);

  t++;

}

function dltForm() {
  var table = document.getElementById('memberform');
  var row_num = table.rows.length;
  if (row_num>5) {
      table.deleteRow(row_num - 1);
  }

  t--;

}

