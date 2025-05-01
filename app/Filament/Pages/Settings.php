<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;



class Settings extends Page implements HasForms
{
    use InteractsWithForms;
    public static ?Setting $setting = null;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.settings';

    public ?array $data = [];

    public static function getNavigationLabel(): string
    {
        return __('custom.setting.single_title');
    }

    protected static ?int $navigationSort = 10;

    public function getHeading(): string
    {
        return __('custom.setting.single_title');
    }

    public function mount(): void
    {
     
        self::$setting = Setting::first();

        if (self::$setting && isset(self::$setting->social_links)) {
            self::$setting->social_links = json_decode(self::$setting->social_links, true);
        }

        $this->form->fill(self::$setting?->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->maxLength(255)->label(__('custom.setting.site_name')),
                TextInput::make('phone_number')->nullable()->maxLength(255)->label(__('custom.setting.phone')),
                TextInput::make('email')->email()->nullable()->maxLength(255)->label(__('custom.setting.email')),
                TextInput::make('country')->nullable()->maxLength(255)->label(__('custom.setting.country')),
                TextInput::make('city')->nullable()->maxLength(255)->label(__('custom.setting.city')),
                TextInput::make('street')->nullable()->maxLength(255)->label(__('custom.setting.street')),
                Repeater::make('social_links')
                    ->label(__('custom.setting.social_links'))
                    ->schema([
                        TextInput::make('platform')
                            ->label(__('custom.setting.platform'))
                            ->required(),
                        TextInput::make('link')
                            ->label(__('custom.setting.link'))
                            ->url()
                            ->required(),
                    ])
                    ->columns(2)
                    ->nullable(),
                FileUpload::make('logo')->nullable()->directory('logo')->imageEditor()->label(__('custom.setting.logo')),
            ])
            ->columns(2)
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('custom.setting.save'))
                ->submit('save'),
        ];
    }

    public function save()
    {
        try {
            $data = $this->form->getState();

            $setting=Setting::first();
            if (isset($data['social_links']) && is_array($data['social_links'])) {
                $data['social_links'] = array_values($data['social_links']);
                $data['social_links'] = json_encode($data['social_links']);
            }

            $setting->update($data);

        } catch (\Exception $exception) {
            return 'error: ' . $exception->getMessage();
        }

        Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();
    }
}
