function select_ctl(e) {
  // ID番号確認用
  const check_id = e.id;
  const checked_id = check_id.substr(3);
  
  // 親selectID取得
  const name = document.getElementById(e.id);
  const selectname = name.value;

  // controlはPHPからバンド情報を格納。
  for (let i in control ) {
    if (control[i]["BAND_NAME"] === "選択してください"){
      const t1 = "ctlnu" + checked_id;
      const tar1 = document.getElementById(t1);
      const val1 = control[i]["TIME_CONTROL"]; //表示内容取得
      tar1.innerHTML = "0分"; //デフォルトに合わせて0分表示

    }else if(control[i]["BAND_NAME"] === selectname){
      const t2 = "ctlnu" + checked_id;
      const tar2 = document.getElementById(t2);
      const val2 = control[i]["TIME_CONTROL"]; //表示内容取得
      tar2.innerHTML = val2 + "分"; //各バンドの希望時間表示

    }
  }
}
