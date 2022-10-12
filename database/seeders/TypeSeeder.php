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
            'name' => '動画',
            'lang' => 'ja',
            'label_parent' => null,
            'label_child' => null,
        ]);

        Type::create([
            'name' => '本',
            'lang' => 'ja',
            'label_parent' => null,
            'label_child' => null,
        ]);

        Type::create([
            'name' => '音源',
            'lang' => 'ja',
            'label_parent' => null,
            'label_child' => null,
        ]);

        Type::create([
            'name' => 'その他',
            'lang' => 'ja',
            'label_parent' => null,
            'label_child' => null,
        ]);

        Type::create([
            'name' => '学習サービス',
            'lang' => 'ja',
            'parent_id' => '1',
            'label_parent' => 'セクション',
            'label_child' => 'レクチャー',
        ]);

        Type::create([
            'name' => '海外ドラマ',
            'lang' => 'ja',
            'parent_id' => '1',
            'label_parent' => 'シーズン',
            'label_child' => 'エピソード',
        ]);

        Type::create([
            'name' => '映画',
            'lang' => 'ja',
            'parent_id' => '1',
            'label_parent' => null,
            'label_child' => null,
        ]);

        Type::create([
            'name' => 'アニメ',
            'lang' => 'ja',
            'parent_id' => '1',
            'label_parent' => 'シーズン',
            'label_child' => 'エピソード',
        ]);

        Type::create([
            'name' => 'テレビ',
            'lang' => 'ja',
            'parent_id' => '1',
            'label_parent' => null,
            'label_child' => null,
        ]);

        Type::create([
            'name' => '参考書',
            'lang' => 'ja',
            'parent_id' => '2',
            'label_parent' => '章',
            'label_child' => '節',
        ]);

        Type::create([
            'name' => 'マンガ',
            'lang' => 'ja',
            'parent_id' => '2',
            'label_parent' => '巻',
            'label_child' => '話',
        ]);

        Type::create([
            'name' => '小説',
            'lang' => 'ja',
            'parent_id' => '2',
            'label_parent' => '章',
            'label_child' => '節',
        ]);

        Type::create([
            'name' => '辞書',
            'lang' => 'ja',
            'parent_id' => '2',
            'label_parent' => '章',
            'label_child' => '節',
        ]);

        Type::create([
            'name' => 'ラジオ',
            'lang' => 'ja',
            'parent_id' => '3',
            'label_parent' => null,
            'label_child' => null,
        ]);

        Type::create([
            'name' => '音楽',
            'lang' => 'ja',
            'parent_id' => '3',
            'label_parent' => null,
            'label_child' => null,
        ]);

        Type::create([
            'name' => 'ポッドキャスト',
            'lang' => 'ja',
            'parent_id' => '3',
            'label_parent' => null,
            'label_child' => null,
        ]);

        Type::create([
            'name' => 'アプリ',
            'lang' => 'ja',
            'parent_id' => '4',
            'label_parent' => null,
            'label_child' => null,
        ]);

        Type::create([
            'name' => 'ゲーム',
            'lang' => 'ja',
            'parent_id' => '4',
            'label_parent' => null,
            'label_child' => null,
        ]);
    }
}
