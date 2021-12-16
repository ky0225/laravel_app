<?php

namespace App\Constants;

// 定数を管理するためのクラス
class Common
{
	const ID_OLDER = '0';
	const ID_LATER = '1';

	const SORT_ID = [
		'older' => self::ID_OLDER,
		'later' => self::ID_LATER,
	];

	const PREFECTURE_TOKYO = '0';
	const PREFECTURE_FUKUOKA = '1';
	const PREFECTURE_SAGA = '2';

	const SORT_PREFECTURE = [
		'tokyo' => self::PREFECTURE_TOKYO,
		'fukuoka' => self::PREFECTURE_FUKUOKA,
		'saga' => self::PREFECTURE_SAGA,
	];
}
