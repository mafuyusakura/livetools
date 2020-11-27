
var t = row+1;
function addForm() {
  if (t >= 13) {
    alert('これ以上増やせません。');
    exit;
  }

  let table = document.getElementById('memberform');
  let newRow = table.insertRow();
  newRow.id = t;

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

  t++; //カウンタ増

}

function dltForm() {
  // row = "";
  rows = row+4; //現在の行数+デフォルト5行
  var table = document.getElementById('memberform');
  var row_num = table.rows.length;
  if (rows<row_num) {
      table.deleteRow(row_num - 1);
  }else{
    alert('これ以上減らせません。');
    exit;
  }

  t--; //カウンタ減

}

function dltrow() {
  let row_now = document.getElementById('memberform');
  rows = row+4; //現在の行数+デフォルト5行
  var table = document.getElementById('memberform');
  var row_num = table.rows.length;
  if (rows<row_num) {
      table.deleteRow(row_num - 1);
  }else{
    alert('これ以上減らせません。');
    exit;
  }

  t--; //カウンタ減

}
