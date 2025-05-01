<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use App\Models\Setting;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;
    protected static string $model = \App\Models\Setting::class;
   
    
    protected function mutateFormDataBeforeFill(array $data): array
    {
        
        $setting=Setting::first();
        if ($setting) {
            $data['site_name'] = $setting->site_name ?? 'Your Default Store Name';  
        } else {
            $data['site_name'] = 'Your Default Store Name';
        }

        return $data;
    
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
