<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create([
            'id' => 10,
            'name' => '動画',
            'lang' => 'ja',
            'label_contents' => null,
            'label_chapters' => null,
        ]);

        Type::create([
            'id' => 11,
            'name' => '学習サービス',
            'lang' => 'ja',
            'label_contents' => 'セクション',
            'label_chapters' => 'レクチャー',
        ]);

        Type::create([
            'id' => 12,
            'name' => '海外ドラマ',
            'lang' => 'ja',
            'label_contents' => 'シーズン',
            'label_chapters' => 'エピソード',
        ]);

        Type::create([
            'id' => 13,
            'name' => '映画',
            'lang' => 'ja',
            'label_contents' => null,
            'label_chapters' => null,
        ]);

        Type::create([
            'id' => 14,
            'name' => 'アニメ',
            'lang' => 'ja',
            'label_contents' => 'シーズン',
            'label_chapters' => 'エピソード',
        ]);

        Type::create([
            'id' => 15,
            'name' => 'テレビ',
            'lang' => 'ja',
            'label_contents' => null,
            'label_chapters' => null,
        ]);

        Type::create([
            'id' => 20,
            'name' => '本',
            'lang' => 'ja',
            'label_contents' => null,
            'label_chapters' => null,
        ]);
        Type::create([
            'id' => 21,
            'name' => '参考書',
            'lang' => 'ja',
            'label_contents' => '章',
            'label_chapters' => '節',
        ]);

        Type::create([
            'id' => 22,
            'name' => 'マンガ',
            'lang' => 'ja',
            'label_contents' => '巻',
            'label_chapters' => '話',
        ]);

        Type::create([
            'id' => 23,
            'name' => '小説',
            'lang' => 'ja',
            'label_contents' => '章',
            'label_chapters' => '節',
        ]);

        Type::create([
            'id' => 24,
            'name' => '辞書',
            'lang' => 'ja',
            'label_contents' => '章',
            'label_chapters' => '節',
        ]);

        Type::create([
            'id' => 30,
            'name' => '音源',
            'lang' => 'ja',
            'label_contents' => null,
            'label_chapters' => null,
        ]);

        Type::create([
            'id' => 31,
            'name' => 'ラジオ',
            'lang' => 'ja',
            'label_contents' => null,
            'label_chapters' => null,
        ]);

        Type::create([
            'id' => 32,
            'name' => '音楽',
            'lang' => 'ja',
            'label_contents' => null,
            'label_chapters' => null,
        ]);

        Type::create([
            'id' => 33,
            'name' => 'ポッドキャスト',
            'lang' => 'ja',
            'label_contents' => null,
            'label_chapters' => null,
        ]);

        Type::create([
            'id' => 40,
            'name' => 'その他',
            'lang' => 'ja',
            'label_contents' => null,
            'label_chapters' => null,
        ]);

        Type::create([
            'id' => 41,
            'name' => 'アプリ',
            'lang' => 'ja',
            'label_contents' => null,
            'label_chapters' => null,
        ]);

        Type::create([
            'id' => 42,
            'name' => 'ゲーム',
            'lang' => 'ja',
            'label_contents' => null,
            'label_chapters' => null,
        ]);
    }
}
