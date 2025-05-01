<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderResource\Pages;
use App\Filament\Resources\SliderResource\RelationManagers;
use App\Models\Slider;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Resources\Concerns\Translatable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SliderResource extends Resource
{
    use Translatable;
    protected static ?string $model = Slider::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?int $navigationSort = 6;

    public static function getModelLabel(): string
    {
        return __('custom.slider.single_title');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('custom.slider.title');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')
                ->directory('slider')
                ->imageEditor()
                ->required()->columnSpanFull()->label(__('custom.slider.image')),

                TextInput::make('title')
                ->label(__('custom.slider.image_title')) 
                ->required() 
                ->columnSpanFull(),


                Textarea::make('description')->nullable()->columnSpanFull()->label(__('custom.slider.description')),

                TextInput::make('order')
                ->label(__('custom.slider.order'))
                ->default(0)  
                ->numeric()
                ->required()
                ->minValue(0)
                ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->label(__('custom.slider.image')),
                TextColumn::make('title')->label(__('custom.slider.image_title')) ,
                TextColumn::make('description')->label(__('custom.slider.description')) ,
                TextColumn::make('order')->label(__('custom.slider.order')) ,

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}
