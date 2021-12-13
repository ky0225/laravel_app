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
}
