function check() {
  if (window.confirm('登録しますか？')) {
    return true;
  }else{
    window.alert('キャンセルされました。');
    return false;
  }

}

function prereset() {
    return confirm('リセットしますか？');
  }

