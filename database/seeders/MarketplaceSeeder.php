<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Setting;
use App\Models\Subcategory;
use App\Models\Vehicle;
use App\Models\VehicleGallery;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class MarketplaceSeeder extends Seeder
{
    public function run(): void
    {
        Setting::updateOrCreate(['id' => 1], [
            'site_name' => 'ftech',
            'whatsapp_number' => '7339316563',
            'email' => 'info@ftech.local',
            'address' => 'Chennai, Tamil Nadu',
        ]);

        $sampleImages = $this->publishSampleImages();

        $categories = [
            'bikes' => ['name' => 'Bikes', 'icon' => 'Bike'],
            'cars' => ['name' => 'Cars', 'icon' => 'Car'],
            'buses' => ['name' => 'Buses', 'icon' => 'Bus'],
            'vans' => ['name' => 'Vans', 'icon' => 'Van'],
            'trucks' => ['name' => 'Trucks', 'icon' => 'Truck'],
        ];

        foreach ($categories as $slug => $data) {
            Category::updateOrCreate(['slug' => $slug], $data + ['status' => true]);
        }

        $brands = [
            'bikes' => ['Hero', 'Honda', 'TVS', 'Yamaha'],
            'cars' => ['Hyundai', 'Maruti Suzuki', 'Tata', 'Mahindra'],
            'buses' => ['Ashok Leyland', 'Eicher'],
            'vans' => ['Force', 'Maruti Suzuki'],
            'trucks' => ['Tata', 'BharatBenz'],
        ];

        foreach ($brands as $categorySlug => $names) {
            $category = Category::where('slug', $categorySlug)->first();
            foreach ($names as $name) {
                Subcategory::updateOrCreate(
                    ['category_id' => $category->id, 'slug' => str()->slug($name)],
                    ['name' => $name, 'status' => true]
                );
            }
        }

        $vehicles = [
            ['bikes', 'Hero', 'Hero Splendor Plus', 78000, 72000, 2022, 'Petrol', 18000, true],
            ['bikes', 'Honda', 'Honda Shine', 95000, 88000, 2021, 'Petrol', 22000, true],
            ['cars', 'Hyundai', 'Hyundai i20 Sportz', 650000, 620000, 2020, 'Petrol', 42000, true],
            ['cars', 'Tata', 'Tata Nexon XZ', 850000, 820000, 2021, 'Diesel', 39000, false],
            ['vans', 'Force', 'Force Traveller 12 Seater', 1250000, 1180000, 2019, 'Diesel', 76000, false],
            ['trucks', 'Tata', 'Tata Ace Gold', 430000, 410000, 2022, 'Diesel', 26000, false],
        ];

        foreach ($vehicles as $index => [$categorySlug, $brand, $title, $price, $discount, $year, $fuel, $km, $featured]) {
            $category = Category::where('slug', $categorySlug)->first();
            $subcategory = Subcategory::where('category_id', $category->id)->where('name', $brand)->first();
            $thumbnail = $sampleImages[$index % count($sampleImages)] ?? null;

            $vehicle = Vehicle::updateOrCreate(
                ['category_id' => $category->id, 'subcategory_id' => $subcategory->id, 'slug' => str()->slug($title)],
                [
                    'title' => $title,
                    'price' => $price,
                    'discount_price' => $discount,
                    'manufacturer_year' => $year,
                    'fuel_type' => $fuel,
                    'km_driven' => $km,
                    'thumbnail' => $thumbnail,
                    'description' => "{$title} in good condition. Documents clear. Ready for inspection and WhatsApp enquiry.",
                    'featured' => $featured,
                    'status' => true,
                ]
            );

            foreach (array_slice($sampleImages, $index * 3, 3) as $sortOrder => $image) {
                VehicleGallery::updateOrCreate(
                    ['vehicle_id' => $vehicle->id, 'file' => $image],
                    ['type' => 'image', 'sort_order' => $sortOrder]
                );
            }
        }
    }

    private function publishSampleImages(): array
    {
        $sourceDirectory = base_path('sample/images');
        $targetDirectory = storage_path('app/public/vehicles/sample');

        if (! File::isDirectory($sourceDirectory)) {
            return [];
        }

        File::ensureDirectoryExists($targetDirectory);

        $paths = File::files($sourceDirectory);
        usort($paths, fn ($first, $second) => strnatcmp($first->getFilename(), $second->getFilename()));

        $published = [];

        foreach ($paths as $index => $path) {
            $filename = 'sample-'.str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT).'.'.$path->getExtension();
            File::copy($path->getPathname(), $targetDirectory.DIRECTORY_SEPARATOR.$filename);
            $published[] = 'vehicles/sample/'.$filename;
        }

        return $published;
    }
}
