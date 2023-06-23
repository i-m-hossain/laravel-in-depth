<?php
namespace Database\Factories\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class FactoryHelper
{

    public static function getRandomModelId(string $model)
    {
        $count = $model::query()->count();
        if ($count === 0) {
            return $model::factory()->create()->id;

        } else {
            return rand(1, $count);
        }
    }

}
