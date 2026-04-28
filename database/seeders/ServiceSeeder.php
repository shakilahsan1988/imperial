<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ServiceSeeder extends Seeder
{
    private array $subCategorySortOrders = [];

    public function run(): void
    {
        $basePath = base_path('lab-test');

        DB::transaction(function () use ($basePath) {
            $categories = $this->seedCategories();

            // Replace the visible catalog without deleting historical service rows.
            Service::query()->update([
                'status' => false,
                'show_on_frontend' => false,
            ]);

            ServiceSubCategory::query()->update(['status' => false]);
            ServiceCategory::query()->update(['status' => false]);

            ServiceCategory::whereIn('id', $categories->pluck('id'))->update(['status' => true]);

            $this->importLaboratoryServices(
                $categories['laboratory'],
                $basePath.DIRECTORY_SEPARATOR.'TEST_NAME_WITH_PRICE.xlsx'
            );

            $this->importImagingServices(
                $categories['imaging'],
                $categories['procedure'],
                $basePath.DIRECTORY_SEPARATOR.'USG, Echo, ECG.xlsx'
            );

            $this->importDuplexStudies(
                $categories['imaging'],
                $basePath.DIRECTORY_SEPARATOR.'DuplexStudy.xlsx'
            );

            $this->disableEmptySubCategories();
            $this->disableEmptyCategories();
        });
    }

    private function seedCategories(): Collection
    {
        $definitions = [
            [
                'name' => 'Laboratory',
                'slug' => 'laboratory',
                'type' => 'laboratory',
                'description' => 'Medical laboratory tests and analysis',
                'sort_order' => 1,
            ],
            [
                'name' => 'Imaging',
                'slug' => 'imaging',
                'type' => 'imaging',
                'description' => 'Radiology and diagnostic imaging services',
                'sort_order' => 2,
            ],
            [
                'name' => 'Procedures',
                'slug' => 'procedures',
                'type' => 'procedure',
                'description' => 'Medical procedures and intervention-based services',
                'sort_order' => 3,
            ],
        ];

        return collect($definitions)->mapWithKeys(function (array $definition) {
            $category = ServiceCategory::updateOrCreate(
                ['slug' => $definition['slug']],
                [
                    'name' => $definition['name'],
                    'type' => $definition['type'],
                    'description' => $definition['description'],
                    'status' => true,
                    'sort_order' => $definition['sort_order'],
                ]
            );

            return [$definition['type'] => $category];
        });
    }

    private function importLaboratoryServices(ServiceCategory $category, string $filePath): void
    {
        $rows = $this->readSheetRows($filePath);
        $currentSubCategory = null;

        foreach ($rows as $row) {
            $serial = $this->cell($row, 'A');
            $name = $this->cell($row, 'B');
            $price = $this->toPrice($this->cell($row, 'C'));

            if (Str::upper($serial) === 'S/N' || Str::upper($name) === 'TEST NAME') {
                continue;
            }

            if ($serial === '' && $name !== '' && $price === null) {
                $currentSubCategory = $this->firstOrCreateSubCategory($category, $name);
                continue;
            }

            if ($currentSubCategory && $name !== '' && $price !== null) {
                $this->upsertService([
                    'service_category' => $category,
                    'service_sub_category' => $currentSubCategory,
                    'name' => $name,
                    'price' => $price,
                    'home_visit_available' => true,
                ]);
            }
        }
    }

    private function importImagingServices(
        ServiceCategory $imagingCategory,
        ServiceCategory $procedureCategory,
        string $filePath
    ): void {
        $rows = $this->readSheetRows($filePath);

        foreach ($rows as $index => $row) {
            if ($index === 0) {
                continue;
            }

            $itemName = $this->cell($row, 'E');
            $itemType = $this->cell($row, 'H');
            $department = $this->cell($row, 'J');
            $price = $this->toPrice($this->cell($row, 'I'));

            if ($itemName === '' || $price === null) {
                continue;
            }

            [$targetCategory, $subCategoryName] = $this->mapImagingRow(
                $imagingCategory,
                $procedureCategory,
                $itemName,
                $itemType,
                $department
            );

            $subCategory = $this->firstOrCreateSubCategory($targetCategory, $subCategoryName);

            $this->upsertService([
                'service_category' => $targetCategory,
                'service_sub_category' => $subCategory,
                'name' => $itemName,
                'price' => $price,
                'home_visit_available' => false,
            ]);
        }
    }

    private function importDuplexStudies(ServiceCategory $category, string $filePath): void
    {
        $rows = $this->readSheetRows($filePath);
        $subCategory = $this->firstOrCreateSubCategory($category, 'Duplex Study');

        foreach ($rows as $index => $row) {
            if ($index === 0) {
                continue;
            }

            $name = $this->cell($row, 'B');
            $price = $this->toPrice($this->cell($row, 'C'));

            if ($name === '' || $price === null) {
                continue;
            }

            $this->upsertService([
                'service_category' => $category,
                'service_sub_category' => $subCategory,
                'name' => $name,
                'price' => $price,
                'home_visit_available' => false,
            ]);
        }
    }

    private function mapImagingRow(
        ServiceCategory $imagingCategory,
        ServiceCategory $procedureCategory,
        string $itemName,
        string $itemType,
        string $department
    ): array {
        $normalizedDepartment = Str::upper(trim($department));
        $normalizedItemType = Str::upper(trim($itemType));
        $normalizedItemName = Str::upper(trim($itemName));

        if (
            $normalizedDepartment === 'CYTOPATHOLOGY' ||
            $normalizedItemType === 'PATHOLOGY' ||
            Str::contains($normalizedItemName, 'FNAC')
        ) {
            return [$procedureCategory, 'Cytopathology'];
        }

        return match ($normalizedDepartment) {
            'ECHOCARDIOGRAPHY' => [$imagingCategory, 'Echocardiography'],
            'ECG' => [$imagingCategory, 'ECG'],
            'USG' => [$imagingCategory, 'USG'],
            default => [$imagingCategory, $department !== '' ? $department : 'Imaging'],
        };
    }

    private function firstOrCreateSubCategory(ServiceCategory $category, string $name): ServiceSubCategory
    {
        $slug = Str::slug($name);
        $key = $category->id.'-'.$slug;

        if (! array_key_exists($key, $this->subCategorySortOrders)) {
            $maxSortOrder = ServiceSubCategory::where('service_category_id', $category->id)->max('sort_order') ?? 0;
            $this->subCategorySortOrders[$key] = $maxSortOrder + 1;
        }

        return ServiceSubCategory::updateOrCreate(
            [
                'service_category_id' => $category->id,
                'slug' => $slug,
            ],
            [
                'name' => $name,
                'status' => true,
                'sort_order' => $this->subCategorySortOrders[$key],
            ]
        );
    }

    private function upsertService(array $data): void
    {
        /** @var ServiceCategory $category */
        $category = $data['service_category'];
        /** @var ServiceSubCategory $subCategory */
        $subCategory = $data['service_sub_category'];

        Service::updateOrCreate(
            [
                'name' => $data['name'],
                'service_category_id' => $category->id,
                'service_sub_category_id' => $subCategory->id,
            ],
            [
                'category' => $category->type,
                'sub_category' => $subCategory->name,
                'price' => $data['price'],
                'home_visit_available' => $data['home_visit_available'],
                'home_visit_price' => null,
                'status' => true,
                'show_on_frontend' => true,
                'sort_order' => 0,
            ]
        );
    }

    private function disableEmptySubCategories(): void
    {
        ServiceSubCategory::query()->each(function (ServiceSubCategory $subCategory) {
            $hasActiveServices = Service::where('service_sub_category_id', $subCategory->id)
                ->where('status', true)
                ->exists();

            if (! $hasActiveServices) {
                $subCategory->update(['status' => false]);
            }
        });
    }

    private function disableEmptyCategories(): void
    {
        ServiceCategory::query()->each(function (ServiceCategory $category) {
            $hasActiveServices = Service::where('service_category_id', $category->id)
                ->where('status', true)
                ->exists();

            if (! $hasActiveServices) {
                $category->update(['status' => false]);
            }
        });
    }

    private function readSheetRows(string $filePath): array
    {
        $sheet = IOFactory::load($filePath)->getActiveSheet();

        return $sheet->toArray('', true, true, true);
    }

    private function cell(array $row, string $column): string
    {
        return trim((string) ($row[$column] ?? ''));
    }

    private function toPrice(string $value): ?float
    {
        $normalized = preg_replace('/[^0-9.]+/', '', $value);

        if ($normalized === '' || ! is_numeric($normalized)) {
            return null;
        }

        return (float) $normalized;
    }
}
