// パスワードの表示・非表示切替
$(".toggle-password").click(function () {
    // iconの切り替え
    $(this).toggleClass("zmdi-eye zmdi-eye-off");

    // 入力フォームの取得
    let input = $(this).parent().prev("input");
    // type切替
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});