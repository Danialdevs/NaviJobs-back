<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyOffice extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'company_id'];

    // Метод для создания нового офиса компании
    public static function createOffice(array $validatedData)
    {
        return static::create($validatedData);
    }

    // Опционально можно определить отношение с компанией
    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
