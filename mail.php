<?php
//var_dump($_POST);

// 変数の初期化
$page_flag = 0;

if( !empty($_POST['btn_confirm']) ) {
  $page_flag = 1;
} elseif( !empty($_POST['btn_submit']) ) {
  $page_flag = 2;

  // 変数とタイムゾーンを初期化
  $header             = null;
  $auto_reply_subject = null;
  $auto_reply_text    = null;
  date_default_timezone_set('Asia/Tokyo');

  // ヘッダー情報を設定
	$header = "MIME-Version: 1.0\n";
	$header .= "From: GRAYCODE <noreply@gray-code.com>\n";
	$header .= "Reply-To: GRAYCODE <noreply@gray-code.com>\n";

  // 件名を設定
  $auto_reply_subject = 'お問い合わせありがとうございます。';

  // 本文を設定
  $auto_reply_text = "この度は、お問い合わせ頂き誠にありがとうございます。下記の内容でお問い合わせを受け付けました。\n\n";
  $auto_reply_text .= "お問い合わせ日時:" . date("Y-m-d H:i") . "\n";
  $auto_reply_text .= "氏名" . $_POST['name'] . "\n";
  $auto_reply_text .= "メールアドレス:" . $_POST['mail'] . "\n\n";
  $auto_reply_text .= "Myano株式会社";

  // メール送信
  mb_send_mail( $_POST['mail'], $auto_reply_subject, $auto_reply_text, $header );

  // 運営側へ送るメールの件名
  $admin_reply_subject = "お問い合わせを受け付けました";

  // 本文を設定
	$admin_reply_text = "下記の内容でお問い合わせがありました。\n\n";
	$admin_reply_text .= "お問い合わせ日時：" . date("Y-m-d H:i") . "\n";
	$admin_reply_text .= "氏名：" . $_POST['name'] . "\n";
  $admin_reply_text .= "メールアドレス：" . $_POST['mail'] . "\n\n";

  // 運営側へメール送信
	mb_send_mail( 'chelsea.tm20@gmail.com', $admin_reply_subject, $admin_reply_text, $header);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title></title>
</head>
<body>
  <h1>お問い合わせフォーム</h1>

  <?php if( $page_flag === 1 ): ?>

  <form action="" method="post">
    <label>氏名</labal><br>
    <p><?php echo $_POST['name']; ?></p><br>
    <label>メールアドレス</label><br>
    <p><?php echo $_POST['mail']; ?><p><br>
    <label>性別</label><br>
    <p>
      <?php
      if( $_POST['gender'] === "male" ){ echo '男性'; }
      else{ echo '女性'; }
      ?>
    </p><br>
    <label>年齢</label><br>
    <p>
      <?php
      if( $_POST['age'] === "1" ){ echo '〜19歳'; }
      elseif( $_POST['age'] === "2" ){ echo '20歳〜29歳'; }
      elseif( $_POST['age'] === "3" ){ echo '30歳〜39歳'; }
      elseif( $_POST['age'] === "4" ){ echo '40歳〜49歳'; }
      elseif( $_POST['age'] === "5" ){ echo '50歳〜59歳'; }
      elseif( $_POST['age'] === "6" ){ echo '60歳〜'; }
      ?>
    </p><br>
    <label>お問い合わせ内容</label><br>
    <p><?php echo nl2br($_POST['contact']); ?></p><br>
    <label>プライバシーポリシーに同意する</label>
    <p>
      <?php
      if( $_POST['agreement'] === "1" ){ echo '同意する'; }
      else{ echo '同意しない'; }
      ?>
    </p>
    <input type="submit" name="btn_back" value="戻る">
    <input type="submit" name="btn_submit" value="送信">
    <input type="hidden" name="name" value="<?php echo $_POST['name']; ?>">
    <input type="hidden" name="mail" value="<?php echo $_POST['mail']; ?>">
    <input type="hidden" name="gender" value="<?php echo $_POST['gender']; ?>">
    <input type="hidden" name="age" value="<?php echo $_POST['age']; ?>">
    <input type="hidden" name="contact" value="<?php echo $_POST['contact']; ?>">
    <input type="hidden" name="agreement" value="<?php echo $_POST['agreement']; ?>">
  </form>

  <?php elseif( $page_flag === 2 ): ?>

  <p>送信が完了しました。</p>

  <?php else: ?>

  <form action="" method="post">
    <label>氏名</labal><br>
    <input type="text" name="name" value="<?php if( !empty($_POST['name']) ){ echo $_POST['name']; } ?>"><br>
    <label>メールアドレス</label><br>
    <input type="text" name="mail" value="<?php if( !empty($_POST['name']) ){ echo $_POST['mail']; } ?>"><br>
    <label>性別</label><br>
    <label for="gender_male"><input id="gender_male" type="radio" name="gender" value="male">男性</label>
    <label for="gender_female"><input id="gender_female" type="radio" name="gender" value="female">女性</label><br>
    <label>年齢</label><br>
    <select name="age">
      <option value="">選択してください</option>
      <option value="1">〜19歳</option>
      <option value="2">20歳〜29歳</option>
      <option value="3">30歳〜39歳</option>
      <option value="4">40歳〜49歳</option>
      <option value="5">50歳〜59歳</option>
      <option value="6">60歳〜</option>
    </select><br>
    <label>お問い合わせ内容</label><br>
    <textarea name="contact"></textarea><br>
    <label for="agreement"><input id="agreement" type="checkbox" name="agreement" value="1">プライバシーポリシーに同意する</label><br>
    <input type="submit" name="btn_confirm" value="入力内容を確認する">
  </form>

  <?php endif; ?>
</body>
</html>
