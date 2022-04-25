<?php

class DBclass{
    // DB接続用のDBハンドルを返す
    public static function gethandle(){
        $user = 'root';
        $pass = '';
        $host = 'localhost';
        $dbname = 'study';
        $charset = 'utf8mb4';

        $dsn = "mysql:dbname={$dbname};host={$host};charset={$charset}";
        $options = [
            \PDO::ATTR_EMULATE_PREPARES => false, // エミュレート無効
            \PDO::MYSQL_ATTR_MULTI_STATEMENTS => false, // 複文無効
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, // エラー時に例外を投げる(好み)
        ];
        try {
            $dbh = new \PDO($dsn, $user, $pass, $options);
            return $dbh;
        }catch( \PDOException $e){
            echo $e->getMessage(); // XXX 実際は出力しない(logに書くとか)
            exit;
        }
    }

    /* 
	データ入力 
	@param $data array ['カラム名' => 'パラメータ']
	*/
    public static function Create($data){
        // カラム名を抽出
        $keys = array_keys($data);
        //var_dump($keys);
        // カラム名のセキュリティチェック
		static::checkColumn($keys);
		// カラム名の``でエスケープ
		$keys_string = implode(', ', array_map(function($k) {
			return "`{$k}`";
		}, $keys));

        //プレースホルダを作成
		$holder_keys = array_map(function($k){
			return ":{$k}";
		}, $keys);
        $holder_keys_string = implode(', ', $holder_keys);
		// (':key1',':key2',':key3')みたいな感じ

        // insertの発行 
        $dbh = Dbclass::gethandle();
        $sql = "INSERT INTO beans ({$keys_string}) VALUES({$holder_keys_string});";
		$pre = $dbh->prepare($sql);
		static::bindValues($pre, $data);
        $r = $pre->execute();
        //var_dump($r);
    }

    /*
	カラムチェック(英数またはアンダースコア以外の文字を使っていたらはじく)
	@param $keys array [カラム名]
	*/
	protected static function checkColumn(array $keys){
		foreach($keys as $k){
            // 変数の長さを取得
			$len = strlen($k);
            // ループで1文字ずつ確認
			for($i = 0; $i < $len; ++$i){
				// 英数ならOK
				if(true === ctype_alnum($k[$i])){
					continue;
				}
				// アンダースコアはOK
				if('_' === $k[$i]){
					continue;
				}
				// else
				throw new \Exception("カラム名に英数アンスコ以外が使われています。：{$k}");
			}
		}
	}
    /* 
    プレースホルダにバインドする
    @param $pre プレースホルダ
    @param $data hash [カラム名 => 変数]
    */
	protected static function bindValues($pre, $data){
		foreach($data as $k => $v){
            // 型に合わせて第三引数を変える
			if((true === is_int($v))||(true === is_float($v))){
				$type = \PDO::PARAM_INT;
			}else{
				$type = \PDO::PARAM_STR;
			}
			$pre->bindValue(":{$k}", $v, $type);
		}
	}
}