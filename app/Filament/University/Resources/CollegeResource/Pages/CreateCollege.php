<?php

namespace App\Filament\University\Resources\CollegeResource\Pages;

use App\Filament\University\Resources\CollegeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCollege extends CreateRecord
{
    protected static string $resource = CollegeResource::class;
        /**
     * 🔒 ربط الكلية تلقائيًا بجامعة المستخدم عند الإنشاء
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['university_id'] = auth()->user()->university()->id;

        return $data;
    }
}
