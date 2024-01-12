<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CardResource\Pages;
use App\Filament\Resources\CardResource\RelationManagers;
use App\Models\Card;
use App\Models\Rarity;
use App\Models\Type;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CardResource extends Resource
{
    protected static ?string $model = Card::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('user_id')
                ->default(auth()->user()->id)->readOnly()->required(),
                TextInput::make('price')->required(),
                TextInput::make('per_price')->required(),
                TextInput::make('selected')
                ->default(1)->readOnly()->required(),
                TextInput::make('total')
                ->numeric()->required(),
                Select::make('type')
                ->options([
                    'colorles' => 'Colorless',
                    'darkness' => 'Darkness',
                    'dargon' => 'Dargon',
                    'fairy' => 'Fairy',
                    'fighting' => 'Fighting',
                    'fire' => 'Fire',
                    'grass' => 'Grass',
                    'lightning' => 'Lightning',
                    'metal' => 'Metal',
                    'psychic' => 'Psychic',
                    'water' => 'Water',
                ])
                ->live()->required(),
                TextInput::make('rarity')
                ->required(),
                FileUpload::make('img')
                    ->directory('card_images')->columnSpanFull()->required()->label('CARD IMAGE'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('user name'),
                TextColumn::make('name')->label('card name'),
                TextColumn::make('total'),
                ToggleColumn::make('is_active'),
                TextColumn::make('type'),
                TextColumn::make('rarity'),
                TextColumn::make('img'),
                ImageColumn::make('img'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCards::route('/'),
            'create' => Pages\CreateCard::route('/create'),
            'edit' => Pages\EditCard::route('/{record}/edit'),
        ];
    }
}
