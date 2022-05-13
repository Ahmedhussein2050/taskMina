<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Bll;

use App\Modules\Admin\Models\Product\Classification;
use App\Modules\Admin\Models\Product\ClassificationData;
use App\Modules\Admin\Models\Products\Brand;
use App\Modules\Admin\Models\Products\BrandData;
use App\Modules\Admin\Models\Products\Category;
use App\Modules\Admin\Models\Products\CategoryData;
use App\Modules\Admin\Models\Products\ProductCategory;
use App\Modules\Admin\Models\Products\ProductData;
use App\Modules\Admin\Models\Products\products;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Description of Const
 *
 * @author fz
 */
class ExcelProducts
{


    public function import($the_file)
    {

        $spreadsheet = IOFactory::load($the_file);
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        for ($i = 3; $i < count($row_range); $i++){
            //classification id
            $classData = ClassificationData::query()
                ->where('title', $sheet->getCell('A' . $row_range[$i])->getValue())
                ->first();
            if (!$classData){
                $class = Classification::query()->create();
                $classData = ClassificationData::query()->create([
                    'classification_id' => $class->id,
                    'lang_id' => 1,
                    'title' => $sheet->getCell('A' . $row_range[$i])->getValue()
                ]);
            }
            $class_id = $classData->classification_id;
            //-----------------------------------------------
            //Brand id
            $brandData = BrandData::query()
                ->where('name', $sheet->getCell('D' . $row_range[$i])->getValue())
                ->first();
            if (!$brandData){
                $brand = Brand::query()->create();
                $brandData = BrandData::query()->create([
                    'brand_id' => $brand->id,
                    'lang_id' => 1,
                    'name' => $sheet->getCell('D' . $row_range[$i])->getValue()
                ]);
            }
            $brand_id = $brandData->brand_id;

            //------------------------------------------------
            //cate level 1

            $cate = Category::query()->where('level', 1)->get()->pluck('id');
            $catData = CategoryData::query()
                ->whereIn('category_id', $cate)
                ->where('title', $sheet->getCell('F' . $row_range[$i])->getValue())
                ->first();
            if (!$catData){
                $category = Category::query()->create([
                    'level' => 1
                ]);
                $catData = CategoryData::query()->create([
                    'category_id' => $category->id,
                    'lang_id' => 1,
                    'title' => $sheet->getCell('F' . $row_range[$i])->getValue()
                ]);
            }
            $cate_id = $catData->category_id;

            //------------------------------------------------
            //cate level 2
            $cate2 = Category::query()->where('level', 2)->get()->pluck('id');
            $catData2 = CategoryData::query()
                ->whereIn('category_id', $cate2)
                ->where('title', $sheet->getCell('G' . $row_range[$i])->getValue())
                ->first();
            if (!$catData2){
                $category2 = Category::query()->create([
                    'level' => 2
                ]);
                $catData2 = CategoryData::query()->create([
                    'category_id' => $category2->id,
                    'lang_id' => 1,
                    'title' => $sheet->getCell('G' . $row_range[$i])->getValue()
                ]);
            }
            $cate_id2 = $catData2->category_id;

            //------------------------------------------------------
            // product
            $product = products::query()->create([
                'price' => $sheet->getCell('C' . $row_range[$i])->getValue(),
                'sku' => $sheet->getCell('I' . $row_range[$i])->getValue(),
                'ordered' => $sheet->getCell('E' . $row_range[$i])->getValue(),
                'brand_id' => $brand_id,
                'stock' => $sheet->getCell('B' . $row_range[$i])->getValue(),
                'classification_id' => $class_id
            ]);
            $cat_data = [
                [
                    'product_id' => $product->id,
                    'category_id' => $cate_id,
                ],
                [
                    'product_id' => $product->id,
                    'category_id' => $cate_id2,
                ]
            ];
            ProductCategory::query()->insert($cat_data);
            $prod_data = [
                [
                    'product_id' => $product->id,
                    'title' => $sheet->getCell('J' . $row_range[$i])->getValue(),
                    'lang_id' => 1
                ],
                [
                    'product_id' => $product->id,
                    'title' => $sheet->getCell('K' . $row_range[$i])->getValue(),
                    'lang_id' => 2
                ]
            ];
            ProductData::query()->insert($prod_data);
        }
    }
}
