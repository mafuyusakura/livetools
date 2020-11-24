// エンド時間表示用
function sted() {
    
    // スタート時間取得
    const from_time = document.getElementById("from").value;
    // レンタル時間取得
    const to_time = document.getElementById("to").value;
    
    const startTime = moment(from_time, "HHmm");
    const endTime = startTime.add(to_time, "hour");
    const tTime = endTime.format("HH:mm");
    document.form1.end.value = tTime;
}

// タイムテーブル表示用
function timetable(e) {
    // IDから番号切出
    const check_id = e.id;
    const checked_id = check_id.substr(3);

    if (checked_id == 1) {
        // 最初のみ
        // 各コマ取得
        const obj = document.getElementById(e.id);
        const result = obj.value;
        // ID番号切り出し
        const tes = e.id;
        const num = tes.substr(3);
        const num_b = parseInt(num) + 1;
        // スタート時間取得
        const from_time = document.getElementById("from").value;

        // メイン処理
        const startTime = moment(from_time, "HHmm");
        const beforeTtime = startTime.add(result, "minutes");
        const before = beforeTtime.format("HH:mm");

        // 出力先1
        const t1 = "target" + num;
        document.form1[t1].value = from_time;
        // 出力先2
        const t2 = "target" + num_b;
        document.form1[t2].value = before;
    }else{
        // 2行目以降
        // 各コマ取得
        const obj = document.getElementById(e.id);
        const result = obj.value;
        // ID番号切り出し
        const tes = e.id;
        const num = tes.substr(3);
        const num_b = parseInt(num) + 1;
        // 自分の時間取得
        const t1 = "target" + num;
        const from_time = document.form1[t1].value;
    
        // メイン処理
        const startTime = moment(from_time, "HHmm");
        const beforeTtime = startTime.add(result, "minutes");
        const before = beforeTtime.format("HH:mm");

        // 出力先
        const t2 = "target" + num_b;
        document.form1[t2].value = before;

        // 時間上限チェック
        const time_id = document.getElementById("end");
        const time_check = time_id.value;
        if (before > time_check) {
            // 上限超えていたら色変更
            const item = "tt" + num;
            const col = document.getElementsByName(item);
            col[0].style.backgroundColor = "yellow";
            alert("終了時刻をオーバーしています。");
        }else{
            // 色戻し
            const item = "tt" + num;
            const col = document.getElementsByName(item);
            col[0].style.backgroundColor = "white";
        }
    }
}

// 完全撤収時間表示用
function endtime(e){
    // obj内容取得
    const obj = document.getElementById(e.id);
    const result = obj.value;

    if (result == "完全撤収") {
        // ID番号切り出し
        const tes = e.id;
        const num = tes.substr(3);
        // 出演時間を空白にする
        const erase = "ht_" + num;
        document.form1[erase].value = "";
        // 終了時間取得
        const end = document.getElementById("end");
        const end_time = end.value;
        // 出力先
        const t2 = "target" + num;
        document.form1[t2].value = end_time;

        // 色戻し
        const item = "tt" + num;
        const col = document.getElementsByName(item);
        col[0].style.backgroundColor = "white";
    
    }
}

// 希望時間表示用
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
  