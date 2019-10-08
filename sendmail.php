<?php

/*
 * SMTPメール送信サンプルファイル
 *
 * 配布元・解説：
 * https://0o.gs/6/0/55
 *
 * Copyright (C) 2019 総合サービス.com. All Rights Reserved.
*/

/* ライブラリ使用準備 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require __DIR__.'/src/Exception.php';
require __DIR__.'/src/PHPMailer.php';
require __DIR__.'/src/SMTP.php';

require "conn.php";//db接続
$records=$db->query("SELECT * FROM lists");//recordsにすべてのレコードが代入される

while($record=$records->fetch()){//各データを取り出して、false()になるまでrecordに代入
/* オブジェクト生成 */
$mail = new PHPMailer(true);

try {
	/* サーバー設定 */
	$mail->isSMTP();
	$mail->SMTPAuth = true;
	$mail->Host = "hostname";
	$mail->Username = "";//【SMTPユーザー名】
	$mail->Password = "";
	$mail->SMTPSecure = "";//【暗号化の種類：`tls`or`ssl`】
	$mail->Port = "";//【SMTPポート番号】


		/* 送受信者設定 */
		$mail->setFrom("from@gmail.com", "");
		$mail->addAddress($record["mailaddress"]);//【送信先メールアドレス】
		$mail->addReplyTo("fromi@gmail.com", "");
		$mail->addBcc("confirm@gmail.com");
		$mail->addAttachment("./pdf/".$record["code"].".pdf");

		/* コンテンツ設定 */
		$mail->CharSet = "UTF-8";
		$mail->Encoding = "base64";
		$mail->Subject = "testmail";//【メール件名】
		$mail->isHTML("false");//【HTMLメール：`true`or`flase`】
		$mail->Body  = $record["name"]." : hello this is test mail";

		/* メール送信試行 */
		$mail->send();
		echo "send to :".$record["mailaddress"]."<br/>";

} catch (Exception $e) {
	/* 例外処理 */
	die("Message could not be sent. Mailer Error: ".$mail->ErrorInfo);
}
}
