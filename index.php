<?php
header('Content-Type: text/html; charset=UTF-8');
$host = "localhost";
$username = "hasegawa";
$pass = "hasegawa0515";
$dbname = "lesson";
$sql = "SELECT * FROM `kadai_hasegawa_ziplist`";
$table_sql = "SHOW FULL COLUMNS FROM `kadai_hasegawa_ziplist`";

$link = mysql_connect($host, $username, $pass);
$db = mysql_select_db($dbname, $link);
mysql_query('SET NAMES utf8', $link );

$res = mysql_query($sql);
$column_count = mysql_num_fields($res);

$table_data = mysql_query($table_sql);

$count_th = 0;
?>
<html>
<head>
<title>PHP課題4_2</title>
</head>
<body>
	<p>PHP課題4_2</p>
	<form form action="search_result.php" method="post">
		<p>
			<label>検索項目<br><select name="input_update_reason_post">
				<option value='public_group_code' >全国地方公共団体コード</option>
				<option value='zip_code_old' >旧郵便番号</option>
				<option value='zip_code' >郵便番号</option>
				<option value='prefecture_kana' >都道府県名(半角カタカナ)</option>
				<option value='city_kana' >市区町村名(半角カタカナ)</option>
				<option value='town_kana' >町域名(半角カタカナ)</option>
				<option value='prefecture' >都道府県名(漢字)</option>
				<option value='city' >市区町村名(漢字)</option>
				<option value='town' >町域名(漢字)</option>
				<option value='town_double_zip_code' >一町域で複数の郵便番号か</option>
				<option value='town_multi_address' >小字毎に番地が起番されている町域か</option>
				<option value='town_attach_district' >丁目を有する町域名か</option>
				<option value='zip_code_multi_town' >一郵便番号で複数の町域か</option>
				<option value='update_check' >更新確認</option>
				<option value='update_reason' >更新理由</option>
			</select></label>
		</p>
		<p>
			<label>検索内容<br><input type="text" name="search_value_post"></label>
		</p>
		<p>
			<input type="submit" value="確認ページへ">
		</p>
	</form>
	<table border=1>
		<?php
		printf("<tr></tr>");
		while ($count_th < $column_count) {
			$show_table_data = mysql_fetch_assoc($table_data);
			printf("<th>%s</th>", print_r($show_table_data["Comment"],true));
			$count_th++;
		}
		$count_th = 0;
		while($row = mysql_fetch_assoc($res)) {
			printf("<tr></tr>");
			while ($count_th < $column_count) {
				$column_name = mysql_field_name($res, $count_th);	//カラム名取得
				$count_th++;
				if (10 <= $count_th) {
					if ($count_th <= 13) {
						if ($row[print_r($column_name,true)] == 0) {
							printf("<th>該当せず</th>");
						}else{
							printf("<th>該当</th>");
						}
					}else if ($count_th == 14) {
						switch ($row[print_r($column_name,true)]) {
							case 0:
								printf("<th>変更なし</th>");
								break;
							case 1:
								printf("<th>変更あり</th>");
								break;
							case 2:
								printf("<th>廃止(廃止データのみ使用)</th>");
								break;
						}
					}else{
						switch ($row[print_r($column_name,true)]) {
							case 0:
								printf("<th>変更なし</th>");
								break;
							case 1:
								printf("<th>市政・区政・町政・分区・政令指定都市施行</th>");
								break;
							case 2:
								printf("<th>住居表示の実施</th>");
								break;
							case 3:
								printf("<th>区画整理</th>");
								break;
							case 4:
								printf("<th>郵便区調整等</th>");
								break;
							case 5:
								printf("<th>訂正</th>");
								break;
							case 6:
								printf("<th>廃止(廃止データのみ使用)</th>");
								break;
						}
					}
				}else{
					printf("<th>%s</th>", $row[print_r($column_name,true)]);
				}
			}
			$count_th = 0;
		}
		?>
	</table>
</body>
<?php mysql_close($link); ?>
</html>