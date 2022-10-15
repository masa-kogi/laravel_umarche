<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shops')->insert([
            [
                'owner_id' => 1,
                'name' => 'アルフレッサ',
                'information' => 'アルフレッサは医薬品/医療機器の卸売業界の大手で、医薬品などの製造販売・輸出入なども手掛けるアルフレッサホールディングスの中核企業です。 アルフレッサは、医療機関や研究所向けに医薬品などの物流機能・情報提供機能を発揮しています。',
                'filename' => 'sample1.jpg',
                'is_selling' => true
            ],
            [
                'owner_id' => 2,
                'name' => 'メディセオ',
                'information' => '株式会社メディセオは、東京都中央区に本社を置く、医療用医薬品や医療機器等の卸売事業を行う企業で、メディパルホールディングスグループの中枢を担っている。2009年10月に株式会社クラヤ三星堂（くらやさんせいどう、KURAYA SANSEIDO Inc.）から社名変更した。',
                'filename' => 'sample2.jpg',
                'is_selling' => true
            ],
            [
                'owner_id' => 3,
                'name' => '栗原医療器械',
                'information' => '医療総合商社として消耗品から医療機器、福祉用具、さらには開業支援まで医療にかかわる多彩なサービスを提供しています。',
                'filename' => 'sample3.jpg',
                'is_selling' => true
            ],
            [
                'owner_id' => 4,
                'name' => '日本ライフライン',
                'information' => '循環器領域を専門とする独立系の医療機器商社であり医療機器メーカーです。 私たちは、心臓ペースメーカの輸入販売を開始した1981年から、循環器領域を専門とする企業として、今では消化器領域も加え国内の医療現場をサポートしています。',
                'filename' => 'sample4.jpg',
                'is_selling' => true
            ],
            [
                'owner_id' => 5,
                'name' => '小西医療器',
                'information' => '小西医療器は、お客様のニーズに対応する総合医療機器商社としてサービスのあり方を常に見直し良きパートナーとして「付加価値」を提供できる企業を目指します。',
                'filename' => 'sample5.jpg',
                'is_selling' => true
            ],
        ]);
    }
}
