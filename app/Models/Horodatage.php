<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Enums\eHorodatage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Horodatage extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'horodatages';
    protected $guarded = ['id'];

    protected $casts = [
        'old_data' => 'array'
    ];

    public function model()
    {
        return $this->morphTo();
    }

    public static function saveAction($model, $type){
        self::create([
            'action' => $type,
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'old_data' => in_array($type, [eHorodatage::_UPDATE, eHorodatage::_DELETE]) ? $model->getOriginal() : NULL,
            'created_by' => auth()->user()->email ?? 'System'
        ]);

    }

}
