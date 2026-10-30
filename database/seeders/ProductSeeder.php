<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\ProductImage;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::truncate(); // vymaže všetky produkty

        // 1. Create Categories
        $surfboards = Category::firstOrCreate(['name' => 'Surfboards']);
        $equipment = Category::firstOrCreate(['name' => 'Equipment']);
        $accessories = Category::firstOrCreate(['name' => 'Accessories']);

        // 2. Create Subcategories
        $short = $surfboards->subcategories()->firstOrCreate(['name' => 'Short Surfboards']);
        $long = $surfboards->subcategories()->firstOrCreate(['name' => 'Long Surfboards']);
        $mid = $surfboards->subcategories()->firstOrCreate(['name' => 'Mid-length Surfboards']);

        $neopren = $equipment->subcategories()->firstOrCreate(['name' => 'Neoprens']);
        $fins = $equipment->subcategories()->firstOrCreate(['name' => 'Fins']);
        $leashes = $equipment->subcategories()->firstOrCreate(['name' => 'Leashes']);

        $tshirts = $accessories->subcategories()->firstOrCreate(['name' => 'T-shirts']);
        $hats = $accessories->subcategories()->firstOrCreate(['name' => 'Hats']);

        // 3. Products IMAGES
        // SURFBOARD
        $product1 = Product::create([
            'name' => 'Wave rider Pro',
            'short_description' => 'Fast and responsive shortboard for your daily surfing sesh',
            'description' => 'High-quality surfboard for experienced surfers.',
            'price' => 499.99,
            'color' => 'green',
            'size' => 'S',
            'stock' => 10,
            'features' => 'Carbon fiber rails, Tri-fin setup',
            'category_id' => $surfboards->id,
            'subcategory_id' => $short->id,
        ]);

        $product1->images()->createMany([
            [
                'image_path' => 'images/products/surf1.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/surf1_detail1.jpg',
                'is_main' => false,
            ],
            [
                'image_path' => 'images/products/surf1_detail2.jpg',
                'is_main' => false,
            ],
            [
                'image_path' => 'images/products/surf1_detail3.jpg',
                'is_main' => false,
            ],
        ]);

        $product2 = Product::create([
            'name' => 'Wave Hunter',
            'short_description' => 'Conquer every wave with the WaveHunters responsive shape and speed.',
            'description' => 'The WaveHunter is designed for thrill-seekers who want control and agility in every turn. Whether youre cutting through clean lines or tackling choppy waves, this board delivers unmatched precision. Its hybrid construction combines strength with lightweight performance for the ultimate surf experience.',
            'price' => 399.99,
            'color' => 'red',
            'size' => 'S',
            'stock' => 12,
            'features' => 'Ultra-light carbon fiber core, Streamlined fish tail for added maneuverability, Double concave base for speed, Durable epoxy coating,
            Balanced for stability and control, Works in small to medium surf, Custom grip pad included, FCS fin system, Slick bottom finish',
            'category_id' => $surfboards->id,
            'subcategory_id' => $short->id,
        ]);

        $product2->images()->createMany([
            [
                'image_path' => 'images/products/surf2.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/surf10_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product3 = Product::create([
            'name' => 'ABC rider',
            'short_description' => 'Smooth rides guaranteed, even on mellow tides.',
            'description' => 'Perfect for beginners and intermediate surfers, the TideGlide delivers stability and ease of use without sacrificing performance. With a wide nose and rounded tail, it floats well and turns effortlessly, making every session enjoyable.',
            'price' => 199.99,
            'color' => 'green',
            'size' => 'S',
            'stock' => 120,
            'features' => 'Ideal for smaller waves, EPS foam core, Soft-top deck for added comfort, Rounded rails for smoother turns,
            Excellent buoyancy, Single fin setup',
            'category_id' => $surfboards->id,
            'subcategory_id' => $short->id,
        ]);

        $product3->images()->createMany([
            [
                'image_path' => 'images/products/surf3.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/surf10_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product4 = Product::create([
            'name' => 'StormSurge',
            'short_description' => 'Charge the biggest waves with confidence.',
            'description' => 'Made for big wave surfers and adrenaline junkies, the StormSurge is reinforced with layered fiberglass and built to handle intense drops and speed. This board provides maximum grip, balance, and power when it matters most.',
            'price' => 899.99,
            'color' => 'white',
            'size' => 'M',
            'stock' => 3,
            'features' => 'Big-wave tested shape, Quad-fin configuration, Triple stringer strength, Textured grip pad, 
                Reinforced nose guard, Excellent paddling power, Designed for hollow breaks, Custom graphics, Heat-laminated finish, Advanced skill level',
            'category_id' => $surfboards->id,
            'subcategory_id' => $mid->id,
        ]);

        $product4->images()->createMany([
            [
                'image_path' => 'images/products/surf4.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/surf10_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product5 = Product::create([
            'name' => 'SunDrifter',
            'short_description' => 'Feel the freedom of longboard cruising',
            'description' => 'The SunDrifter is all about flow and glide. Its longboard shape makes it perfect for catching even the smallest waves, giving riders a relaxed and stylish surf experience. Perfect for noseriding and beach breaks.',
            'price' => 349.99,
            'color' => 'blue',
            'size' => 'M',
            'stock' => 12,
            'features' => 'Excellent noseriding potential, Durable PU foam construction, Smooth bottom contours, Retro-style leash loop, Comes with travel bag',
            'category_id' => $surfboards->id,
            'subcategory_id' => $mid->id,
        ]);

        $product5->images()->createMany([
            [
                'image_path' => 'images/products/surf5.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/surf10_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product6 = Product::create([
            'name' => 'Reef Rider',
            'short_description' => 'Get close to the reef with precision turns and tight control.',
            'description' => 'Made for technical surfers, the ReefRider is designed for fast, responsive turns and aggressive lines. Short and sharp, its ideal for reef breaks and challenging conditions.',
            'price' => 1999.99,
            'color' => 'blue',
            'size' => 'M',
            'stock' => 2,
            'features' => 'Excellent noseriding potential, Durable PU foam construction, Smooth bottom contours, Retro-style leash loop, Comes with travel bag',
            'category_id' => $surfboards->id,
            'subcategory_id' => $mid->id,
        ]);

        $product6->images()->createMany([
            [
                'image_path' => 'images/products/surf6.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/surf10_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product7 = Product::create([
            'name' => 'Ocean pulse',
            'short_description' => 'Sync your rhythm with the oceans pulse.',
            'description' => 'The OceanPulse adapts to your flow. Its versatile enough for various conditions, making it a great choice for all-rounders. A mix of stability, control, and speed in one stylish board.',
            'price' => 1199.99,
            'color' => 'yellow',
            'size' => 'L',
            'stock' => 12,
            'features' => 'Soft rails for smooth transitions, Dual-fin setup, Anti-slip wax finish, V-bottom for easy paddling, Perfect travel board, Color fade design, For intermediate level',
            'category_id' => $surfboards->id,
            'subcategory_id' => $long->id,
        ]);

        $product7->images()->createMany([
            [
                'image_path' => 'images/products/surf7.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/surf10_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product8 = Product::create([
            'name' => 'BlueEcho',
            'short_description' => 'Hear the call of the sea with every ride.',
            'description' => 'BlueEcho is designed for soulful riders who surf with feeling. Its design emphasizes flow, allowing for expressive turns and a relaxed stance. Great for point breaks and long sessions.',
            'price' => 783,
            'color' => 'red',
            'size' => 'L',
            'stock' => 10,
            'features' => 'Soft rails for smooth transitions, Dual-fin setup, Anti-slip wax finish, V-bottom for easy paddling, Perfect travel board, Color fade design, For intermediate level',
            'category_id' => $surfboards->id,
            'subcategory_id' => $long->id,
        ]);

        $product8->images()->createMany([
            [
                'image_path' => 'images/products/surf8.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/surf10_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product9 = Product::create([
            'name' => 'SaltSprint',
            'short_description' => 'Speed through saltwater with aerodynamic ease.',
            'description' => 'A board for those who love fast, energetic surfing. SaltSprint gives you the burst and speed needed for fast maneuvers and quick paddles into steep waves.',
            'price' => 1299.99,
            'color' => 'white',
            'size' => 'L',
            'stock' => 45,
            'features' => 'Excellent noseriding potential, Durable PU foam construction, Smooth bottom contours, Retro-style leash loop, Comes with travel bag',
            'category_id' => $surfboards->id,
            'subcategory_id' => $long->id,
        ]);

        $product9->images()->createMany([
            [
                'image_path' => 'images/products/surf9.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/surf10_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product10 = Product::create([
            'name' => 'SeaZen',
            'short_description' => 'Calm, connected, and balanced rides await.',
            'description' => 'SeaZen is built for peaceful days and fluid surfing. Perfect for yoga-surfers or cruisers, this board focuses on balance, control, and flow—without rushing.',
            'price' => 199.99,
            'color' => 'yellow',
            'size' => 'S',
            'stock' => 120,
            'features' => 'Carbon fiber rails, Tri-fin setup',
            'category_id' => $surfboards->id,
            'subcategory_id' => $short->id,
        ]);

        $product10->images()->createMany([
            [
                'image_path' => 'images/products/surf10.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/surf10_detail1.jpg',
                'is_main' => false,
            ],
            [
                'image_path' => 'images/products/surf10_detail2.jpg',
                'is_main' => false,
            ],
        ]);

        $product11 = Product::create([
            'name' => 'DriftNovan',
            'short_description' => 'Modern style meets cosmic glide.',
            'description' => 'The DriftNova combines futuristic design with timeless surf physics. Fast down the line with just the right flex, it’s made for style-conscious surfers who care about feel as much as looks.',
            'price' => 399.99,
            'color' => 'other',
            'size' => 'S',
            'stock' => 12,
            'features' => 'Big-wave tested shape, Quad-fin configuration, Triple stringer strength, Textured grip pad, Reinforced nose guard, Excellent paddling power, Designed for hollow breaks',
            'category_id' => $surfboards->id,
            'subcategory_id' => $short->id,
        ]);

        $product11->images()->createMany([
            [
                'image_path' => 'images/products/surf11.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/surf10_detail1.jpg',
                'is_main' => false,
            ],
            [
                'image_path' => 'images/products/surf10_detail2.jpg',
                'is_main' => false,
            ],
        ]);

        $product12 = Product::create([
            'name' => 'Maui go',
            'short_description' => 'Modern style meets cosmic glide.',
            'description' => 'The DriftNova combines futuristic design with timeless surf physics. Fast down the line with just the right flex, it’s made for style-conscious surfers who care about feel as much as looks.',
            'price' => 1399.99,
            'color' => 'black',
            'size' => 'S',
            'stock' => 12,
            'features' => 'Big-wave tested shape, Quad-fin configuration, Triple stringer strength, Textured grip pad, Reinforced nose guard, Excellent paddling power, Designed for hollow breaks',
            'category_id' => $surfboards->id,
            'subcategory_id' => $short->id,
        ]);

        $product12->images()->createMany([
            [
                'image_path' => 'images/products/surf12.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/surf10_detail1.jpg',
                'is_main' => false,
            ],
            [
                'image_path' => 'images/products/surf10_detail2.jpg',
                'is_main' => false,
            ],
        ]);

        $product13 = Product::create([
            'name' => 'Wave rider Pro super',
            'short_description' => 'Fast and responsive shortboard for your daily surfing sesh',
            'description' => 'High-quality surfboard for experienced surfers.',
            'price' => 1499.99,
            'color' => 'green',
            'size' => 'S',
            'stock' => 10,
            'features' => 'Carbon fiber rails, Tri-fin setup',
            'category_id' => $surfboards->id,
            'subcategory_id' => $short->id,
        ]);

        $product13->images()->createMany([
            [
                'image_path' => 'images/products/surf1.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/surf1_detail1.jpg',
                'is_main' => false,
            ],
            [
                'image_path' => 'images/products/surf1_detail2.jpg',
                'is_main' => false,
            ],
            [
                'image_path' => 'images/products/surf1_detail3.jpg',
                'is_main' => false,
            ],
        ]);

        $product14 = Product::create([
            'name' => 'Wave Hunter Super',
            'short_description' => 'Conquer every wave with the WaveHunters responsive shape and speed.',
            'description' => 'The WaveHunter is designed for thrill-seekers who want control and agility in every turn. Whether youre cutting through clean lines or tackling choppy waves, this board delivers unmatched precision. Its hybrid construction combines strength with lightweight performance for the ultimate surf experience.',
            'price' => 1399.99,
            'color' => 'red',
            'size' => 'S',
            'stock' => 12,
            'features' => 'Ultra-light carbon fiber core, Streamlined fish tail for added maneuverability, Double concave base for speed, Durable epoxy coating,
            Balanced for stability and control, Works in small to medium surf, Custom grip pad included, FCS fin system, Slick bottom finish',
            'category_id' => $surfboards->id,
            'subcategory_id' => $short->id,
        ]);

        $product14->images()->createMany([
            [
                'image_path' => 'images/products/surf2.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/surf10_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product15 = Product::create([
            'name' => 'ABC rider pro super',
            'short_description' => 'Smooth rides guaranteed, even on mellow tides.',
            'description' => 'Perfect for beginners and intermediate surfers, the TideGlide delivers stability and ease of use without sacrificing performance. With a wide nose and rounded tail, it floats well and turns effortlessly, making every session enjoyable.',
            'price' => 1199.99,
            'color' => 'green',
            'size' => 'S',
            'stock' => 120,
            'features' => 'Ideal for smaller waves, EPS foam core, Soft-top deck for added comfort, Rounded rails for smoother turns,
            Excellent buoyancy, Single fin setup',
            'category_id' => $surfboards->id,
            'subcategory_id' => $short->id,
        ]);

        $product15->images()->createMany([
            [
                'image_path' => 'images/products/surf3.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/surf10_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product16 = Product::create([
            'name' => 'StormSurge top',
            'short_description' => 'Charge the biggest waves with confidence.',
            'description' => 'Made for big wave surfers and adrenaline junkies, the StormSurge is reinforced with layered fiberglass and built to handle intense drops and speed. This board provides maximum grip, balance, and power when it matters most.',
            'price' => 1899.99,
            'color' => 'white',
            'size' => 'M',
            'stock' => 3,
            'features' => 'Big-wave tested shape, Quad-fin configuration, Triple stringer strength, Textured grip pad, 
                Reinforced nose guard, Excellent paddling power, Designed for hollow breaks, Custom graphics, Heat-laminated finish, Advanced skill level',
            'category_id' => $surfboards->id,
            'subcategory_id' => $mid->id,
        ]);

        $product16->images()->createMany([
            [
                'image_path' => 'images/products/surf4.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/surf10_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product17 = Product::create([
            'name' => 'SunDrifter num.1',
            'short_description' => 'Feel the freedom of longboard cruising',
            'description' => 'The SunDrifter is all about flow and glide. Its longboard shape makes it perfect for catching even the smallest waves, giving riders a relaxed and stylish surf experience. Perfect for noseriding and beach breaks.',
            'price' => 1349.99,
            'color' => 'blue',
            'size' => 'M',
            'stock' => 12,
            'features' => 'Excellent noseriding potential, Durable PU foam construction, Smooth bottom contours, Retro-style leash loop, Comes with travel bag',
            'category_id' => $surfboards->id,
            'subcategory_id' => $mid->id,
        ]);

        $product17->images()->createMany([
            [
                'image_path' => 'images/products/surf5.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/surf10_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product18 = Product::create([
            'name' => 'Pro Reef Rider',
            'short_description' => 'Get close to the reef with precision turns and tight control.',
            'description' => 'Made for technical surfers, the ReefRider is designed for fast, responsive turns and aggressive lines. Short and sharp, its ideal for reef breaks and challenging conditions.',
            'price' => 1999.99,
            'color' => 'blue',
            'size' => 'M',
            'stock' => 2,
            'features' => 'Excellent noseriding potential, Durable PU foam construction, Smooth bottom contours, Retro-style leash loop, Comes with travel bag',
            'category_id' => $surfboards->id,
            'subcategory_id' => $mid->id,
        ]);

        $product18->images()->createMany([
            [
                'image_path' => 'images/products/surf6.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/surf10_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product19 = Product::create([
            'name' => 'Ocean pulse pro',
            'short_description' => 'Sync your rhythm with the oceans pulse.',
            'description' => 'The OceanPulse adapts to your flow. Its versatile enough for various conditions, making it a great choice for all-rounders. A mix of stability, control, and speed in one stylish board.',
            'price' => 1499.99,
            'color' => 'yellow',
            'size' => 'L',
            'stock' => 12,
            'features' => 'Soft rails for smooth transitions, Dual-fin setup, Anti-slip wax finish, V-bottom for easy paddling, Perfect travel board, Color fade design, For intermediate level',
            'category_id' => $surfboards->id,
            'subcategory_id' => $long->id,
        ]);

        $product19->images()->createMany([
            [
                'image_path' => 'images/products/surf7.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/surf10_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product20 = Product::create([
            'name' => 'BlueEcho 1',
            'short_description' => 'Hear the call of the sea with every ride.',
            'description' => 'BlueEcho is designed for soulful riders who surf with feeling. Its design emphasizes flow, allowing for expressive turns and a relaxed stance. Great for point breaks and long sessions.',
            'price' => 1783,
            'color' => 'red',
            'size' => 'L',
            'stock' => 10,
            'features' => 'Soft rails for smooth transitions, Dual-fin setup, Anti-slip wax finish, V-bottom for easy paddling, Perfect travel board, Color fade design, For intermediate level',
            'category_id' => $surfboards->id,
            'subcategory_id' => $long->id,
        ]);

        $product20->images()->createMany([
            [
                'image_path' => 'images/products/surf8.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/surf10_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product21 = Product::create([
            'name' => 'SaltSprint Uno',
            'short_description' => 'Speed through saltwater with aerodynamic ease.',
            'description' => 'A board for those who love fast, energetic surfing. SaltSprint gives you the burst and speed needed for fast maneuvers and quick paddles into steep waves.',
            'price' => 299.99,
            'color' => 'white',
            'size' => 'L',
            'stock' => 45,
            'features' => 'Excellent noseriding potential, Durable PU foam construction, Smooth bottom contours, Retro-style leash loop, Comes with travel bag',
            'category_id' => $surfboards->id,
            'subcategory_id' => $long->id,
        ]);

        $product21->images()->createMany([
            [
                'image_path' => 'images/products/surf9.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/surf10_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product22 = Product::create([
            'name' => 'SeaZen Pro',
            'short_description' => 'Calm, connected, and balanced rides await.',
            'description' => 'SeaZen is built for peaceful days and fluid surfing. Perfect for yoga-surfers or cruisers, this board focuses on balance, control, and flow—without rushing.',
            'price' => 1199.99,
            'color' => 'yellow',
            'size' => 'S',
            'stock' => 120,
            'features' => 'Carbon fiber rails, Tri-fin setup',
            'category_id' => $surfboards->id,
            'subcategory_id' => $short->id,
        ]);

        $product22->images()->createMany([
            [
                'image_path' => 'images/products/surf10.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/surf10_detail1.jpg',
                'is_main' => false,
            ],
            [
                'image_path' => 'images/products/surf10_detail2.jpg',
                'is_main' => false,
            ],
        ]);

        $product23 = Product::create([
            'name' => 'DriftNovan Pro',
            'short_description' => 'Modern style meets cosmic glide.',
            'description' => 'The DriftNova combines futuristic design with timeless surf physics. Fast down the line with just the right flex, it’s made for style-conscious surfers who care about feel as much as looks.',
            'price' => 1399.99,
            'color' => 'other',
            'size' => 'S',
            'stock' => 12,
            'features' => 'Big-wave tested shape, Quad-fin configuration, Triple stringer strength, Textured grip pad, Reinforced nose guard, Excellent paddling power, Designed for hollow breaks',
            'category_id' => $surfboards->id,
            'subcategory_id' => $short->id,
        ]);

        $product23->images()->createMany([
            [
                'image_path' => 'images/products/surf11.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/surf10_detail1.jpg',
                'is_main' => false,
            ],
            [
                'image_path' => 'images/products/surf10_detail2.jpg',
                'is_main' => false,
            ],
        ]);

        $product24 = Product::create([
            'name' => 'Maui go now',
            'short_description' => 'Modern style meets cosmic glide.',
            'description' => 'The DriftNova combines futuristic design with timeless surf physics. Fast down the line with just the right flex, it’s made for style-conscious surfers who care about feel as much as looks.',
            'price' => 1299.99,
            'color' => 'black',
            'size' => 'S',
            'stock' => 12,
            'features' => 'Big-wave tested shape, Quad-fin configuration, Triple stringer strength, Textured grip pad, Reinforced nose guard, Excellent paddling power, Designed for hollow breaks',
            'category_id' => $surfboards->id,
            'subcategory_id' => $short->id,
        ]);

        $product24->images()->createMany([
            [
                'image_path' => 'images/products/surf12.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/surf10_detail1.jpg',
                'is_main' => false,
            ],
            [
                'image_path' => 'images/products/surf10_detail2.jpg',
                'is_main' => false,
            ],
        ]);

        // EQUIPMENT
        $product100 = Product::create([
            'name' => 'Wetsuit exclusive',
            'short_description' => 'Stay warm in cold waters',
            'description' => 'Durable wetsuit for cold water surfing.',
            'price' => 599.99,
            'color' => 'black',
            'size' => 'S, L, XL, M',
            'stock' => 25,
            'features' => '3mm neoprene, Seam-sealed',
            'category_id' => $equipment->id,
            'subcategory_id' => $neopren->id,
        ]);


        $product100->images()->createMany([
            [
                'image_path' => 'images/products/neopren1.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/neopren4_detail1.jpg',
                'is_main' => false,
            ],
            [
                'image_path' => 'images/products/neopren4_detail2.jpg',
                'is_main' => false,
            ],
        ]);

        $product101 = Product::create([
            'name' => 'Cool wetsuit',
            'short_description' => 'Stay warm in cold waters',
            'description' => 'Durable wetsuit for cold water surfing.',
            'price' => 159.99,
            'color' => 'black',
            'size' => 'S, L, XL, M',
            'stock' => 30,
            'features' => '3mm neoprene, Seam-sealed, Glued and blind stitched seams, Flexible underarm panels, Reinforced knee pads, Easy back-zip entry',
            'category_id' => $equipment->id,
            'subcategory_id' => $neopren->id,
        ]);

        $product101->images()->createMany([
            [
                'image_path' => 'images/products/neopren2.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/neopren4_detail1.jpg',
                'is_main' => false,
            ],
            [
                'image_path' => 'images/products/neopren4_detail2.jpg',
                'is_main' => false,
            ],
        ]);

        $product102 = Product::create([
            'name' => 'Neopren exclusive',
            'short_description' => 'Stay warm and surf longer in extra cold waters.',
            'description' => 'High-quality wetsuit offering excellent insulation and flexibility, perfect for cold water surfing and extended sessions.',
            'price' => 399.99,
            'color' => 'red',
            'size' => 'S, L, XL, M',
            'stock' => 105,
            'features' => '3mm neoprene, Seam-sealed, Glued and blind stitched seams, Flexible underarm panels, Reinforced knee pads, Easy back-zip entry',
            'category_id' => $equipment->id,
            'subcategory_id' => $neopren->id,
        ]);

        $product102->images()->createMany([
            [
                'image_path' => 'images/products/neopren3.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/neopren4_detail1.jpg',
                'is_main' => false,
            ],
            [
                'image_path' => 'images/products/neopren4_detail2.jpg',
                'is_main' => false,
            ],
        ]);

        $product103 = Product::create([
            'name' => 'Maui neo',
            'short_description' => 'Stay warm in cold waters with our high quality neopren',
            'description' => 'High-quality wetsuit offering excellent insulation and flexibility, perfect for cold water surfing and extended sessions.',
            'price' => 499.99,
            'color' => 'black',
            'size' => 'S, L, XL, M',
            'stock' => 25,
            'features' => '3mm neoprene, Seam-sealed, Glued and blind stitched seams, Flexible underarm panels, Reinforced knee pads, Easy back-zip entry',
            'category_id' => $equipment->id,
            'subcategory_id' => $neopren->id,
        ]);

        $product103->images()->createMany([
            [
                'image_path' => 'images/products/neopren4.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/neopren4_detail1.jpg',
                'is_main' => false,
            ],
            [
                'image_path' => 'images/products/neopren4_detail2.jpg',
                'is_main' => false,
            ],
        ]);

        $product104 = Product::create([
            'name' => 'Fast leash',
            'short_description' => ' Secure connection between you and your board.',
            'description' => 'A strong, tangle-free surfboard leash designed to keep your board close even in heavy surf. Built with comfort and durability in mind.',
            'price' => 9,
            'color' => 'other',
            'size' => 'S, M',
            'stock' => 250,
            'features' => '7mm urethane cord, Double swivel system, Padded ankle cuff, Quick-release pull tab, Anti-tangle design',
            'category_id' => $equipment->id,
            'subcategory_id' => $leashes->id,
        ]);

        $product104->images()->createMany([
            [
                'image_path' => 'images/products/leash1.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/leash1_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product105 = Product::create([
            'name' => 'Leash exclusive',
            'short_description' => ' Secure connection between you and your board.',
            'description' => 'A strong, tangle-free surfboard leash designed to keep your board close even in heavy surf. Built with comfort and durability in mind.',
            'price' => 19,
            'color' => 'blue',
            'size' => 'L',
            'stock' => 250,
            'features' => '7mm urethane cord, Double swivel system, Padded ankle cuff, Quick-release pull tab, Anti-tangle design',
            'category_id' => $equipment->id,
            'subcategory_id' => $leashes->id,
        ]);

        $product105->images()->createMany([
            [
                'image_path' => 'images/products/leash2.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/leash1_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product106 = Product::create([
            'name' => 'Maui freedom',
            'short_description' => ' Secure connection between you and your board.',
            'description' => 'A strong, tangle-free surfboard leash designed to keep your board close even in heavy surf. Built with comfort and durability in mind.',
            'price' => 37.5,
            'color' => 'black',
            'size' => 'S, M',
            'stock' => 105,
            'features' => '7mm urethane cord, Double swivel system, Padded ankle cuff, Quick-release pull tab, Anti-tangle design',
            'category_id' => $equipment->id,
            'subcategory_id' => $leashes->id,
        ]);

        $product106->images()->createMany([
            [
                'image_path' => 'images/products/leash3.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/leash1_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product107 = Product::create([
            'name' => 'Fin fan fun',
            'short_description' => 'Boost your control and speed in the water.',
            'description' => 'Precision-molded surfboard fins that provide enhanced maneuverability and stability in all wave conditions. Ideal for both beginners and pros.',
            'price' => 199.99,
            'color' => 'white',
            'size' => 'L, S',
            'stock' => 25,
            'features' => 'Fiberglass-reinforced construction, Standard FCS-compatible base, Designed for balanced turns, Lightweight yet durable, Available in multiple sizes',
            'category_id' => $equipment->id,
            'subcategory_id' => $fins->id,
        ]);

        $product107->images()->createMany([
            [
                'image_path' => 'images/products/fin1.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/fin1_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product108 = Product::create([
            'name' => 'Super fin',
            'short_description' => 'Boost your control and speed in the water.',
            'description' => 'Precision-molded surfboard fins that provide enhanced maneuverability and stability in all wave conditions. Ideal for both beginners and pros.',
            'price' => 19.99,
            'color' => 'yellow',
            'size' => 'L, S',
            'stock' => 25,
            'features' => '3mm neoprene, Seam-sealed',
            'category_id' => $equipment->id,
            'subcategory_id' => $fins->id,
        ]);

        $product108->images()->createMany([
            [
                'image_path' => 'images/products/fin2.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/fin1_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product109 = Product::create([
            'name' => 'Maui fast Fin',
            'short_description' => 'Boost your control and speed in the water.',
            'description' => 'Precision-molded surfboard fins that provide enhanced maneuverability and stability in all wave conditions. Ideal for both beginners and pros.',
            'price' => 109.99,
            'color' => 'other',
            'size' => 'L, S',
            'stock' => 25,
            'features' => '3mm neoprene, Seam-sealed',
            'category_id' => $equipment->id,
            'subcategory_id' => $fins->id,
        ]);
        
        $product109->images()->createMany([
            [
                'image_path' => 'images/products/fin3.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/fin3_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product110 = Product::create([
            'name' => 'Wetsuit exclusive Pro',
            'short_description' => 'Stay warm in cold waters',
            'description' => 'Durable wetsuit for cold water surfing.',
            'price' => 699.99,
            'color' => 'black',
            'size' => 'S, L, XL, M',
            'stock' => 25,
            'features' => '3mm neoprene, Seam-sealed',
            'category_id' => $equipment->id,
            'subcategory_id' => $neopren->id,
        ]);


        $product110->images()->createMany([
            [
                'image_path' => 'images/products/neopren1.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/neopren4_detail1.jpg',
                'is_main' => false,
            ],
            [
                'image_path' => 'images/products/neopren4_detail2.jpg',
                'is_main' => false,
            ],
        ]);

        $product111 = Product::create([
            'name' => 'Cool wetsuit pro',
            'short_description' => 'Stay warm in cold waters',
            'description' => 'Durable wetsuit for cold water surfing.',
            'price' => 359.99,
            'color' => 'black',
            'size' => 'S, L, XL, M',
            'stock' => 30,
            'features' => '3mm neoprene, Seam-sealed, Glued and blind stitched seams, Flexible underarm panels, Reinforced knee pads, Easy back-zip entry',
            'category_id' => $equipment->id,
            'subcategory_id' => $neopren->id,
        ]);

        $product111->images()->createMany([
            [
                'image_path' => 'images/products/neopren2.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/neopren4_detail1.jpg',
                'is_main' => false,
            ],
            [
                'image_path' => 'images/products/neopren4_detail2.jpg',
                'is_main' => false,
            ],
        ]);

        $product112 = Product::create([
            'name' => 'Neopren pro',
            'short_description' => 'Stay warm and surf longer in extra cold waters.',
            'description' => 'High-quality wetsuit offering excellent insulation and flexibility, perfect for cold water surfing and extended sessions.',
            'price' => 459.99,
            'color' => 'red',
            'size' => 'S, L, XL, M',
            'stock' => 105,
            'features' => '3mm neoprene, Seam-sealed, Glued and blind stitched seams, Flexible underarm panels, Reinforced knee pads, Easy back-zip entry',
            'category_id' => $equipment->id,
            'subcategory_id' => $neopren->id,
        ]);

        $product112->images()->createMany([
            [
                'image_path' => 'images/products/neopren3.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/neopren4_detail1.jpg',
                'is_main' => false,
            ],
            [
                'image_path' => 'images/products/neopren4_detail2.jpg',
                'is_main' => false,
            ],
        ]);

        $product113 = Product::create([
            'name' => 'Maui neo sun',
            'short_description' => 'Stay warm in cold waters with our high quality neopren',
            'description' => 'High-quality wetsuit offering excellent insulation and flexibility, perfect for cold water surfing and extended sessions.',
            'price' => 699.99,
            'color' => 'black',
            'size' => 'S, L, XL, M',
            'stock' => 25,
            'features' => '3mm neoprene, Seam-sealed, Glued and blind stitched seams, Flexible underarm panels, Reinforced knee pads, Easy back-zip entry',
            'category_id' => $equipment->id,
            'subcategory_id' => $neopren->id,
        ]);

        $product113->images()->createMany([
            [
                'image_path' => 'images/products/neopren4.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/neopren4_detail1.jpg',
                'is_main' => false,
            ],
            [
                'image_path' => 'images/products/neopren4_detail2.jpg',
                'is_main' => false,
            ],
        ]);

        $product114 = Product::create([
            'name' => 'Fast leash pro',
            'short_description' => ' Secure connection between you and your board.',
            'description' => 'A strong, tangle-free surfboard leash designed to keep your board close even in heavy surf. Built with comfort and durability in mind.',
            'price' => 19,
            'color' => 'other',
            'size' => 'L',
            'stock' => 250,
            'features' => '7mm urethane cord, Double swivel system, Padded ankle cuff, Quick-release pull tab, Anti-tangle design',
            'category_id' => $equipment->id,
            'subcategory_id' => $leashes->id,
        ]);

        $product114->images()->createMany([
            [
                'image_path' => 'images/products/leash1.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/leash1_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product115 = Product::create([
            'name' => 'Pro Leash exclusive',
            'short_description' => ' Secure connection between you and your board.',
            'description' => 'A strong, tangle-free surfboard leash designed to keep your board close even in heavy surf. Built with comfort and durability in mind.',
            'price' => 190,
            'color' => 'blue',
            'size' => 'XL',
            'stock' => 250,
            'features' => '7mm urethane cord, Double swivel system, Padded ankle cuff, Quick-release pull tab, Anti-tangle design',
            'category_id' => $equipment->id,
            'subcategory_id' => $leashes->id,
        ]);

        $product115->images()->createMany([
            [
                'image_path' => 'images/products/leash2.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/leash1_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product116 = Product::create([
            'name' => 'Maui freedom pro',
            'short_description' => ' Secure connection between you and your board.',
            'description' => 'A strong, tangle-free surfboard leash designed to keep your board close even in heavy surf. Built with comfort and durability in mind.',
            'price' => 57.5,
            'color' => 'black',
            'size' => 'S, M',
            'stock' => 105,
            'features' => '7mm urethane cord, Double swivel system, Padded ankle cuff, Quick-release pull tab, Anti-tangle design',
            'category_id' => $equipment->id,
            'subcategory_id' => $leashes->id,
        ]);

        $product116->images()->createMany([
            [
                'image_path' => 'images/products/leash3.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/leash1_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product117 = Product::create([
            'name' => 'Fin pro fun',
            'short_description' => 'Boost your control and speed in the water.',
            'description' => 'Precision-molded surfboard fins that provide enhanced maneuverability and stability in all wave conditions. Ideal for both beginners and pros.',
            'price' => 190.99,
            'color' => 'white',
            'size' => 'L, S',
            'stock' => 25,
            'features' => 'Fiberglass-reinforced construction, Standard FCS-compatible base, Designed for balanced turns, Lightweight yet durable, Available in multiple sizes',
            'category_id' => $equipment->id,
            'subcategory_id' => $fins->id,
        ]);

        $product117->images()->createMany([
            [
                'image_path' => 'images/products/fin1.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/fin1_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product118 = Product::create([
            'name' => 'Super fast fin',
            'short_description' => 'Boost your control and speed in the water.',
            'description' => 'Precision-molded surfboard fins that provide enhanced maneuverability and stability in all wave conditions. Ideal for both beginners and pros.',
            'price' => 109.99,
            'color' => 'yellow',
            'size' => 'L, S',
            'stock' => 25,
            'features' => '3mm neoprene, Seam-sealed',
            'category_id' => $equipment->id,
            'subcategory_id' => $fins->id,
        ]);

        $product118->images()->createMany([
            [
                'image_path' => 'images/products/fin2.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/fin1_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product119 = Product::create([
            'name' => 'Maui Fin',
            'short_description' => 'Boost your control and speed in the water.',
            'description' => 'Precision-molded surfboard fins that provide enhanced maneuverability and stability in all wave conditions. Ideal for both beginners and pros.',
            'price' => 100.99,
            'color' => 'other',
            'size' => 'L, S',
            'stock' => 25,
            'features' => '3mm neoprene, Seam-sealed',
            'category_id' => $equipment->id,
            'subcategory_id' => $fins->id,
        ]);
        
        $product119->images()->createMany([
            [
                'image_path' => 'images/products/fin3.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/fin3_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        // ACCESSORIES
        $product1000 = Product::create([
            'name' => 'Surf Locos',
            'short_description' => 'Casual surfwear for everyday vibes.',
            'description' => 'Soft cotton t-shirt with a minimalist surf design, great for post-session chill or beachside hangs. Designed for comfort and style.',
            'price' => 29.99,
            'color' => 'black',
            'size' => 'XS, S, M, L, XL',
            'stock' => 100,
            'features' => '100% organic cotton, Pre-shrunk fit, Screen-printed graphic, Unisex sizing, Lightweight & breathable',
            'category_id' => $accessories->id,
            'subcategory_id' => $tshirts->id,
        ]);

        $product1000->images()->createMany([
            [
                'image_path' => 'images/products/tshirt1.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/hat1.jpg',
                'is_main' => false,
            ],
        ]);

        $product1001 = Product::create([
            'name' => 'Flowers',
            'short_description' => 'Casual surfwear for everyday vibes.',
            'description' => 'Soft cotton t-shirt with a minimalist surf design, great for post-session chill or beachside hangs. Designed for comfort and style.',
            'price' => 19.80,
            'color' => 'green',
            'size' => 'XS, S, M, L, XL',
            'stock' => 100,
            'features' => '100% organic cotton, Pre-shrunk fit, Screen-printed graphic, Unisex sizing, Lightweight & breathable',
            'category_id' => $accessories->id,
            'subcategory_id' => $tshirts->id,
        ]);

        $product1001->images()->createMany([
            [
                'image_path' => 'images/products/tshirt2.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/hat1.jpg',
                'is_main' => false,
            ],
        ]);

        $product1002 = Product::create([
            'name' => 'Maui vibes',
            'short_description' => 'Casual surfwear for everyday vibes.',
            'description' => 'Soft cotton t-shirt with a minimalist surf design, great for post-session chill or beachside hangs. Designed for comfort and style.',
            'price' => 129.99,
            'color' => 'white',
            'size' => 'XS, S, M, L, XL',
            'stock' => 100,
            'features' => '100% organic cotton, Pre-shrunk fit, Screen-printed graphic, Unisex sizing, Lightweight & breathable',
            'category_id' => $accessories->id,
            'subcategory_id' => $tshirts->id,
        ]);

        $product1002->images()->createMany([
            [
                'image_path' => 'images/products/tshirt3.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/hat1.jpg',
                'is_main' => false,
            ],
        ]);

        $product1003 = Product::create([
            'name' => 'Sun and chill',
            'short_description' => 'Casual surfwear for everyday vibes.',
            'description' => 'Soft cotton t-shirt with a minimalist surf design, great for post-session chill or beachside hangs. Designed for comfort and style.',
            'price' => 29.99,
            'color' => 'white',
            'size' => 'XS, M, L',
            'stock' => 100,
            'features' => '100% organic cotton, Pre-shrunk fit, Screen-printed graphic, Unisex sizing, Lightweight & breathable',
            'category_id' => $accessories->id,
            'subcategory_id' => $tshirts->id,
        ]);

        $product1003->images()->createMany([
            [
                'image_path' => 'images/products/tshirt4.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/tshirt4_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product1004 = Product::create([
            'name' => 'Maui customs',
            'short_description' => 'Casual surfwear for everyday vibes.',
            'description' => 'Soft cotton t-shirt with a minimalist surf design, great for post-session chill or beachside hangs. Designed for comfort and style.',
            'price' => 108,
            'color' => 'blue',
            'size' => 'XS, S, M, L, XL',
            'stock' => 100,
            'features' => '100% organic cotton, Pre-shrunk fit, Screen-printed graphic, Unisex sizing, Lightweight & breathable',
            'category_id' => $accessories->id,
            'subcategory_id' => $tshirts->id,
        ]);

        $product1004->images()->createMany([
            [
                'image_path' => 'images/products/tshirt5.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/tshirt5_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product1005 = Product::create([
            'name' => 'Hat hut hot',
            'short_description' => 'Sun protection meets surf style.',
            'description' => 'Lightweight surf hat made with water-resistant materials, keeping your head protected from the sun without compromising comfort.',
            'price' => 79.99,
            'color' => 'blue',
            'size' => 'S, L',
            'stock' => 100,
            'features' => 'UPF 50+ protection, Adjustable chin strap, Floatable brim, Quick-dry fabric, Breathable mesh panels',
            'category_id' => $accessories->id,
            'subcategory_id' => $hats->id,
        ]);

        $product1005->images()->createMany([
            [
                'image_path' => 'images/products/hat1.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/hat1.jpg',
                'is_main' => false,
            ],
        ]);

        $product1006 = Product::create([
            'name' => 'Crazy hat',
            'short_description' => 'Sun protection meets surf style.',
            'description' => 'Lightweight surf hat made with water-resistant materials, keeping your head protected from the sun without compromising comfort.',
            'price' => 29.99,
            'color' => 'blue',
            'size' => 'M, L',
            'stock' => 100,
            'features' => 'UPF 50+ protection, Adjustable chin strap, Floatable brim, Quick-dry fabric, Breathable mesh panels',
            'category_id' => $accessories->id,
            'subcategory_id' => $hats->id,
        ]);

        $product1006->images()->createMany([
            [
                'image_path' => 'images/products/hat2.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/hat1.jpg',
                'is_main' => false,
            ],
        ]);

        $product1007 = Product::create([
            'name' => 'Sun Cap',
            'short_description' => 'Sun protection meets surf style.',
            'description' => 'Lightweight surf hat made with water-resistant materials, keeping your head protected from the sun without compromising comfort.',
            'price' => 19.99,
            'color' => 'green',
            'size' => 'S, M, L',
            'stock' => 100,
            'features' => 'UPF 50+ protection, Adjustable chin strap, Floatable brim, Quick-dry fabric, Breathable mesh panels',
            'category_id' => $accessories->id,
            'subcategory_id' => $hats->id,
        ]);

        $product1007->images()->createMany([
            [
                'image_path' => 'images/products/hat3.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/hat1.jpg',
                'is_main' => false,
            ],
        ]);

        $product1008 = Product::create([
            'name' => 'Global Hat',
            'short_description' => 'Sun protection meets surf style.',
            'description' => 'Lightweight surf hat made with water-resistant materials, keeping your head protected from the sun without compromising comfort.',
            'price' => 29.99,
            'color' => 'other',
            'size' => 'S, M',
            'stock' => 100,
            'features' => 'UPF 50+ protection, Adjustable chin strap, Floatable brim, Quick-dry fabric, Breathable mesh panels',
            'category_id' => $accessories->id,
            'subcategory_id' => $hats->id,
        ]);

        $product1008->images()->createMany([
            [
                'image_path' => 'images/products/hat4.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/hat1.jpg',
                'is_main' => false,
            ],
        ]);

        $product1009 = Product::create([
            'name' => 'Surffffin cap',
            'short_description' => 'Sun protection meets surf style.',
            'description' => 'Lightweight surf hat made with water-resistant materials, keeping your head protected from the sun without compromising comfort.',
            'price' => 29.99,
            'color' => 'other',
            'size' => 'S, M, L',
            'stock' => 100,
            'features' => 'UPF 50+ protection, Adjustable chin strap, Floatable brim, Quick-dry fabric, Breathable mesh panels',
            'category_id' => $accessories->id,
            'subcategory_id' => $hats->id,
        ]);

        $product1009->images()->createMany([
            [
                'image_path' => 'images/products/hat5.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/hat1.jpg',
                'is_main' => false,
            ],
        ]);
    


        $product1010 = Product::create([
            'name' => 'Great Surf Locos',
            'short_description' => 'Casual surfwear for everyday vibes.',
            'description' => 'Soft cotton t-shirt with a minimalist surf design, great for post-session chill or beachside hangs. Designed for comfort and style.',
            'price' => 19.99,
            'color' => 'black',
            'size' => 'XS, S, M, L, XL',
            'stock' => 100,
            'features' => '100% organic cotton, Pre-shrunk fit, Screen-printed graphic, Unisex sizing, Lightweight & breathable',
            'category_id' => $accessories->id,
            'subcategory_id' => $tshirts->id,
        ]);

        $product1010->images()->createMany([
            [
                'image_path' => 'images/products/tshirt1.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/hat1.jpg',
                'is_main' => false,
            ],
        ]);

        $product1011 = Product::create([
            'name' => 'Flowers Go',
            'short_description' => 'Casual surfwear for everyday vibes.',
            'description' => 'Soft cotton t-shirt with a minimalist surf design, great for post-session chill or beachside hangs. Designed for comfort and style.',
            'price' => 16.80,
            'color' => 'green',
            'size' => 'XS, S, M, L, XL',
            'stock' => 100,
            'features' => '100% organic cotton, Pre-shrunk fit, Screen-printed graphic, Unisex sizing, Lightweight & breathable',
            'category_id' => $accessories->id,
            'subcategory_id' => $tshirts->id,
        ]);

        $product1011->images()->createMany([
            [
                'image_path' => 'images/products/tshirt2.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/hat1.jpg',
                'is_main' => false,
            ],
        ]);

        $product1012 = Product::create([
            'name' => 'Maui daysn',
            'short_description' => 'Casual surfwear for everyday vibes.',
            'description' => 'Soft cotton t-shirt with a minimalist surf design, great for post-session chill or beachside hangs. Designed for comfort and style.',
            'price' => 109.99,
            'color' => 'white',
            'size' => 'XS, S, M, L, XL',
            'stock' => 100,
            'features' => '100% organic cotton, Pre-shrunk fit, Screen-printed graphic, Unisex sizing, Lightweight & breathable',
            'category_id' => $accessories->id,
            'subcategory_id' => $tshirts->id,
        ]);

        $product1012->images()->createMany([
            [
                'image_path' => 'images/products/tshirt3.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/hat1.jpg',
                'is_main' => false,
            ],
        ]);

        $product1013 = Product::create([
            'name' => 'Sun and chill zone',
            'short_description' => 'Casual surfwear for everyday vibes.',
            'description' => 'Soft cotton t-shirt with a minimalist surf design, great for post-session chill or beachside hangs. Designed for comfort and style.',
            'price' => 29.99,
            'color' => 'white',
            'size' => 'XS, S, M, L, XL',
            'stock' => 100,
            'features' => '100% organic cotton, Pre-shrunk fit, Screen-printed graphic, Unisex sizing, Lightweight & breathable',
            'category_id' => $accessories->id,
            'subcategory_id' => $tshirts->id,
        ]);

        $product1013->images()->createMany([
            [
                'image_path' => 'images/products/tshirt4.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/tshirt4_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product1014 = Product::create([
            'name' => 'Maui customs surfiiiiiin',
            'short_description' => 'Casual surfwear for everyday vibes.',
            'description' => 'Soft cotton t-shirt with a minimalist surf design, great for post-session chill or beachside hangs. Designed for comfort and style.',
            'price' => 78,
            'color' => 'blue',
            'size' => 'XS, S, M, L, XL',
            'stock' => 100,
            'features' => '100% organic cotton, Pre-shrunk fit, Screen-printed graphic, Unisex sizing, Lightweight & breathable',
            'category_id' => $accessories->id,
            'subcategory_id' => $tshirts->id,
        ]);

        $product1014->images()->createMany([
            [
                'image_path' => 'images/products/tshirt5.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/tshirt5_detail1.jpg',
                'is_main' => false,
            ],
        ]);

        $product1015 = Product::create([
            'name' => 'Hat hut hot pro',
            'short_description' => 'Sun protection meets surf style.',
            'description' => 'Lightweight surf hat made with water-resistant materials, keeping your head protected from the sun without compromising comfort.',
            'price' => 99.99,
            'color' => 'blue',
            'size' => 'S, M, L',
            'stock' => 100,
            'features' => 'UPF 50+ protection, Adjustable chin strap, Floatable brim, Quick-dry fabric, Breathable mesh panels',
            'category_id' => $accessories->id,
            'subcategory_id' => $hats->id,
        ]);

        $product1015->images()->createMany([
            [
                'image_path' => 'images/products/hat1.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/hat1.jpg',
                'is_main' => false,
            ],
        ]);

        $product1016 = Product::create([
            'name' => 'Crazy hat pro',
            'short_description' => 'Sun protection meets surf style.',
            'description' => 'Lightweight surf hat made with water-resistant materials, keeping your head protected from the sun without compromising comfort.',
            'price' => 18.99,
            'color' => 'blue',
            'size' => 'S, M, L',
            'stock' => 100,
            'features' => 'UPF 50+ protection, Adjustable chin strap, Floatable brim, Quick-dry fabric, Breathable mesh panels',
            'category_id' => $accessories->id,
            'subcategory_id' => $hats->id,
        ]);

        $product1016->images()->createMany([
            [
                'image_path' => 'images/products/hat2.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/hat1.jpg',
                'is_main' => false,
            ],
        ]);

        $product1017 = Product::create([
            'name' => 'Sun Cap A',
            'short_description' => 'Sun protection meets surf style.',
            'description' => 'Lightweight surf hat made with water-resistant materials, keeping your head protected from the sun without compromising comfort.',
            'price' => 15.99,
            'color' => 'green',
            'size' => 'S, M, L',
            'stock' => 100,
            'features' => 'UPF 50+ protection, Adjustable chin strap, Floatable brim, Quick-dry fabric, Breathable mesh panels',
            'category_id' => $accessories->id,
            'subcategory_id' => $hats->id,
        ]);

        $product1017->images()->createMany([
            [
                'image_path' => 'images/products/hat3.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/hat1.jpg',
                'is_main' => false,
            ],
        ]);

        $product1018 = Product::create([
            'name' => 'Global Hat exclusive',
            'short_description' => 'Sun protection meets surf style.',
            'description' => 'Lightweight surf hat made with water-resistant materials, keeping your head protected from the sun without compromising comfort.',
            'price' => 19.99,
            'color' => 'other',
            'size' => 'S, M, L',
            'stock' => 100,
            'features' => 'UPF 50+ protection, Adjustable chin strap, Floatable brim, Quick-dry fabric, Breathable mesh panels',
            'category_id' => $accessories->id,
            'subcategory_id' => $hats->id,
        ]);

        $product1018->images()->createMany([
            [
                'image_path' => 'images/products/hat4.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/hat1.jpg',
                'is_main' => false,
            ],
        ]);

        $product1019 = Product::create([
            'name' => 'Surffffin exclusive cap',
            'short_description' => 'Sun protection meets surf style.',
            'description' => 'Lightweight surf hat made with water-resistant materials, keeping your head protected from the sun without compromising comfort.',
            'price' => 19.99,
            'color' => 'other',
            'size' => 'S, M, L',
            'stock' => 100,
            'features' => 'UPF 50+ protection, Adjustable chin strap, Floatable brim, Quick-dry fabric, Breathable mesh panels',
            'category_id' => $accessories->id,
            'subcategory_id' => $hats->id,
        ]);

        $product1019->images()->createMany([
            [
                'image_path' => 'images/products/hat5.jpg',
                'is_main' => true,
            ],
            [
                'image_path' => 'images/products/hat1.jpg',
                'is_main' => false,
            ],
        ]);
    }
}
