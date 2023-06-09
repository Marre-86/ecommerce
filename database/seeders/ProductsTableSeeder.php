<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::truncate();

        Product::create([
            'name' => 'ANRABESS Casual Loose Short Sleeve Long Dress',
            'description' => 'Split Maxi Summer Beach Dress with Pockets',
            'price' => 30.59,
            'weight' => 1,
            'category_id' => 4,
            'image' => 'anrabess-casual-loose-short-sleeve-long-dress.jpg'
        ]);

        Product::create([
            'name' => 'Vince Camuto Women\'s Hamden Slingback Pump',
            'price' => 86.12,
            'weight' => 2,
            'category_id' => 8,
            'image' => 'vince-camuto-womens-hamden-slingback-pump.jpg'
        ]);

        Product::create([
            'name' => 'Franco Sarto Women\'s Milano Pointed Toe Slingback Pump',
            'price' => 89.99,
            'weight' => 0.5,
            'category_id' => 8,
            'image' => 'franco-sarto-womens-milano-pointed-toe-slingback-pump.jpg'
        ]);

        Product::create([
            'name' => 'DREAM PAIRS Women\'s High Stilettos Heels',
            'description' => 'Fashion women high heel sandals features in elegant open toe with sexy one-word strap design, elegant and avant-garde, which create an optical illusion for your legline appearing longer.',
            'price' => 12.90,
            'weight' => 0.74,
            'category_id' => 6,
            'image' => 'dream-pairs-womens-high-stilettos-heels.jpg'
        ]);

        Product::create([
            'name' => 'The Drop Women\'s Avery Square High Heels',
            'price' => 49.90,
            'weight' => 0.58,
            'category_id' => 6,
            'image' => 'the-drop-womens-avery-square-high-heels.jpg'
        ]);

        Product::create([
            'name' => 'Syktkmx Womens\' Braided Heeled Sandals',
            'price' => 49.88,
            'weight' => 0.95,
            'category_id' => 6,
            'image' => 'syktkmx-womens-braided-heeled-sandals.jpg'
        ]);

        Product::create([
            'name' => 'Amazon Essentials Women\'s Buckle Mule',
            'price' => 19.41,
            'weight' => 0.36,
            'category_id' => 7,
            'image' => 'amazon-essentials-womens-buckle-mule.jpg'
        ]);

        Product::create([
            'name' => 'The Drop Women\'s Troy Pointed Toe Mule Slide',
            'price' => 21.49,
            'weight' => 0.48,
            'width' => 1.12,
            'length' => 2.13,
            'category_id' => 7,
            'image' => 'the-drop-womens-troy-pointed-toe-mule-slide.jpg'
        ]);

        Product::create([
            'name' => 'Slocyclub Flat Mules',
            'price' => 33.99,
            'weight' => 0.64,
            'width' => 1.50,
            'length' => 1.56,
            'category_id' => 7,
            'image' => 'slocyclub-flat-mules.jpg'
        ]);

        Product::create([
            'name' => 'CZDYUF Summer New Square Toe Ladies Slippers Set Toe High Heels Ladies Mules',
            'description' => 'Simple and elegant shoe design.',
            'price' => 245.61,
            'weight' => 0.48,
            'width' => 1.15,
            'length' => 2.04,
            'category_id' => 7
        ]);

        Product::create([
            'name' => 'Ellie Shoes Women\'s 253-Elizabeth Ankle Bootie',
            'description' => 'Fashion women high heel sandals features in elegant open toe with sexy one-word strap design, elegant and avant-garde, which create an optical illusion for your legline appearing longer.',
            'price' => 44.46,
            'weight' => 1.67,
            'width' => 1.56,
            'length' => 1.25,
            'category_id' => 9,
            'image' => 'ellie-shoes-womens-253-elizabeth-ankle-bootie.jpg'
        ]);

        Product::create([
            'name' => 'Betsey Johnson Women\'s Sb-Cady Ankle Boot',
            'description' => 'Fashion women high heel sandals features in elegant open toe with sexy one-word strap design, elegant and avant-garde, which create an optical illusion for your legline appearing longer.',
            'price' => 119.00,
            'weight' => 2.16,
            'width' => 1.70,
            'length' => 1.46,
            'category_id' => 9,
            'image' => 'betsey-johnson-womens-sb-cady-ankle-boot.jpg'
        ]);

        Product::create([
            'name' => 'BTFBM Women Summer Bohemian Floral Casual Dress',
            'description' => 'I strongly feel once I put on my “good” bra which has some lift and a small amount of padding that the top will be too tight.',
            'price' => 34.84,
            'weight' => 0.89,
            'width' => 1.12,
            'length' => 1.80,
            'category_id' => 4,
            'image' => 'btfbm-women-summer-bohemian-floral-casual-dress.jpg'
        ]);

        Product::create([
            'name' => 'Amoretu Women Summer Tunic Dress',
            'description' => 'Comfortable dress, v neckline with lantern long sleeve/short sleeve/sleeveless, super flattering, fashionable and elegant.',
            'price' => 33.98,
            'weight' => 0.89,
            'width' => 0.76,
            'length' => 1.86,
            'category_id' => 4,
            'image' => 'amoretu-women-summer-tunic-dress.jpg'
        ]);

        Product::create([
            'name' => 'Dress the Population Women\'s Dress',
            'description' => 'When I first open the package I thought the dress looked a little weird and even on the hanger still didn\'t look right but once it was on, it\'s absolutely gorgeous.',
            'price' => 248.00,
            'weight' => 1.08,
            'width' => 0.80,
            'length' => 1.54,
            'category_id' => 4
        ]);

        Product::create([
            'name' => 'ZESICA Women\'s 2023 Summer Casual Flutter Dress',
            'description' => 'This women solid color long maxi dress suitable for women of all shapes and length. Perfect for holidays and everyday wear. It will be a stand out piece in your closet!',
            'price' => 49.99,
            'weight' => 1.13,
            'width' => 0.53,
            'length' => 1.07,
            'category_id' => 4,
            'image' => 'zesica-womens-2023-summer-casual-flutter-dress.jpg'
        ]);

        Product::create([
            'name' => 'Dress the Population Women\'s Alicia Dress',
            'description' => 'Offering textural contrast in a tonal color story, this versatile party dress pairs a fitted crepe bodice with a softly gathered chiffon skirt. Its slender straps and a plunging neckline highlight your decolletage, while the scalloped lace hem make for a romantic finish.',
            'price' => 198.00,
            'weight' => 1.19,
            'width' => 1.02,
            'length' => 2.14,
            'category_id' => 4,
            'image' => 'dress-the-population-womens-alicia-dress.jpg'
        ]);

        Product::create([
            'name' => 'Alex Evenings Women\'s Tea Length Sequin Mock Dress',
            'description' => 'Feel your absolute best in this updated yet classic mock dress, featuring gorgeous emboidery, illusion sleeves, and the perfect party skirt. Pair with your favorite heels for a stunning head to toe look!',
            'price' => 120.70,
            'weight' => 0.54,
            'width' => 0.71,
            'length' => 1.80,
            'category_id' => 4,
            'image' => 'alex-evenings-womens-tea-length-sequin-mock-dress.jpg'
        ]);

        Product::create([
            'name' => 'Valenki Russian Traditional Winter Felt Boots',
            'description' => 'ONE OF THE WARMEST TYPES OF SHOES IN THE WORLD. Reliable protection against the cold. Recommended temperature range : -40 to 23 °F [-40 to -5 ºC]',
            'price' => 2.09,
            'weight' => 3.16,
            'width' => 0.98,
            'length' => 1.80,
            'category_id' => 11,
            'image' => 'valenki-russian-traditional-winter-felt-boots.jpg'
        ]);

        Product::create([
            'name' => 'Valenki Russian Traditional Rubberized Winter Felt Boots',
            'description' => 'Valenki made of 100% natural sheep\'s wool. Rubberized',
            'price' => 12.09,
            'weight' => 3.58,
            'width' => 0.98,
            'length' => 1.84,
            'category_id' => 11,
            'image' => 'valenki-russian-traditional-rubberized-winter-felt-boots.jpg'
        ]);

        Product::create([
            'name' => 'Accutime Kids Marvel Spider-Man Digital Quartz Plastic Watch',
            'description' => 'This Spiderman digital kids watch is the perfect gift for your little one! With a clear, easy to read digital display and accurate Quartz movement, this digital watch is a great accessory that your child will love to wear and use!',
            'price' => 12.83,
            'weight' => 0.42,
            'width' => 0.23,
            'length' => 0.19,
            'category_id' => 3,
            'image' => 'accutime-kids-marvel-spider-man-digital-quartz-plastic-watch.jpg'
        ]);

        Product::create([
            'name' => 'Under Armour Boys\' Heathered Blitzing 3.0 Cap',
            'description' => 'UA Classic Fit features a pre-curved visor & structured front panels that maintain shape with a low profile fit.',
            'price' => 15.97,
            'weight' => 0.31,
            'width' => 0.23,
            'length' => 0.26,
            'category_id' => 3,
            'image' => 'under-armour-boys-heathered-blitzing-30-cap.jpg'
        ]);

        Product::create([
            'name' => 'Spyder Baby Boy\'s Overweb Ski Gloves (Toddler)',
            'description' => 'The waterproof Spyder® Kids Overweb (Little Kids/Big Kids) gloves will give you the protection you need to tackle the wind and snow. These full-coverage gloves are designed with a seam-sealed softshell featuring a 10K laminate Repreve®',
            'price' => 48.29,
            'weight' => 0.96,
            'width' => 0.45,
            'length' => 0.37,
            'category_id' => 3,
            'image' => 'spyder-baby-boys-overweb-ski-gloves-toddler.jpg'
        ]);

        Product::create([
            'name' => 'Disney Girls Toddler Winter Hat and Mittens Set Ages 2-4',
            'description' => 'Soft and comfortable fleece Materials, naturally Warm. The toddler Beanie Hat and Mittens are all double layered with soft and fuzzy Sherpa lining for comfort and extra warmth. Outside: 100% Acrylic. Lining: Soft Fleece Lining.',
            'price' => 15.99,
            'weight' => 0.54,
            'width' => 0.28,
            'length' => 0.26,
            'category_id' => 3,
            'image' => 'disney-girls-toddler-winter-hat-and-mittens-set-ages-2-4.jpg'
        ]);        
    }
}
