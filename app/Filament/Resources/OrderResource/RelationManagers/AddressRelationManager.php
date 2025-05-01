<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AddressRelationManager extends RelationManager
{
    protected static string $relationship = 'address';
    public static function getModelLabel(): string
    {
        return __('custom.address.label');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                ->label(__('custom.address.f_name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                ->label(__('custom.address.l_name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                ->label(__('custom.address.phone'))
                    ->required()
                    ->tel()
                    ->maxLength(15),
                
                Forms\Components\TextInput::make('city')
                ->label(__('custom.address.city'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('state')
                ->label(__('custom.address.state'))
                    ->nullable()
                    ->maxLength(255),
                Forms\Components\TextInput::make('zip_code')
                ->label(__('custom.address.zip_code'))
                    ->nullable()
                    ->numeric()
                    ->maxLength(15),
                    Forms\Components\Textarea::make('street_address')
                    ->label(__('custom.address.street'))
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('street_address')
            ->columns([
                Tables\Columns\TextColumn::make('full_name')->label(__('custom.address.name')),
                Tables\Columns\TextColumn::make('phone')->label(__('custom.address.phone')),
                Tables\Columns\TextColumn::make('city')->label(__('custom.address.city')),
                Tables\Columns\TextColumn::make('state')->label(__('custom.address.state')),
                Tables\Columns\TextColumn::make('zip_code')->label(__('custom.address.zip_code')),
                Tables\Columns\TextColumn::make('street_address')->label(__('custom.address.street'))
                
            ])
            ->filters([
                //
            ])
            ->heading(__('custom.address.title'))
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
