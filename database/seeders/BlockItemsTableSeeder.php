<?php

namespace Database\Seeders;

use App\Models\BlockedItem;
use App\Models\BlockedType;
use Illuminate\Database\Seeder;

class BlockItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $BlockedItems = [
            [
                'type'  => 'domain',
                'value' => 'test.com',
                'note'  => 'Block all domains/emails @test.com',
            ],
            [
                'type'  => 'domain',
                'value' => 'test.ca',
                'note'  => 'Block all domains/emails @test.ca',
            ],
            [
                'type'  => 'domain',
                'value' => 'fake.com',
                'note'  => 'Block all domains/emails @fake.com',
            ],
            [
                'type'  => 'domain',
                'value' => 'example.com',
                'note'  => 'Block all domains/emails @example.com',
            ],
            [
                'type'  => 'domain',
                'value' => 'mailinator.com',
                'note'  => 'Block all domains/emails @mailinator.com',
            ],
        ];

        if (config('laravelblocker.seedPublishedBlockedItems')) {
            foreach ($BlockedItems as $BlockedItem) {
                $blockType = BlockedType::where('slug', $BlockedItem['type'])->first();
                $newBlockedItem = BlockedItem::where('typeId', '=', $blockType->id)
                                             ->where('value', '=', $BlockedItem['value'])
                                             ->withTrashed()
                                             ->first();
                if ($newBlockedItem === null) {
                    $newBlockedItem = BlockedItem::create([
                                                              'typeId'    => $blockType->id,
                                                              'value'     => $BlockedItem['value'],
                                                              'note'      => $BlockedItem['note'],
                                                          ]);
                }
            }
        }
        echo "\e[32mSeeding:\e[0m BlockedItemsTableSeeder\r\n";

    }
}
