<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Entreprises';

    protected static ?string $navigationGroup = 'Entreprise';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nom de l\'entreprise')
                    ->required()
                    ->maxLength(255),

                FileUpload::make('logo_path')
                    ->label('Logo')
                    ->image()
                    ->directory('logos')
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->label('Description')
                    ->maxLength(1000),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(),

                TextInput::make('phone_number')
                    ->label('Numéro de téléphone')
                    ->tel()
                    ->required(),

                Select::make('industries')
                    ->label('Secteurs d\'activité')
                    ->relationship('industries', 'name')
                    ->multiple()
                    ->searchable(),

                Select::make('addresses')
                    ->label('Adresses')
                    ->relationship('addresses', 'postal_code')
                    ->multiple()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nom')
                    ->sortable()
                    ->searchable(),

                ImageColumn::make('logo_path')
                    ->label('Logo')
                    ->circular(),

                TextColumn::make('email')
                    ->label('Email')
                    ->copyable()
                    ->searchable(),

                TextColumn::make('phone_number')
                    ->label('Téléphone'),
            ])
            ->filters([
                Tables\Filters\Filter::make('high_rating')
                    ->label('Top Noté')
                    ->query(fn ($query) => $query->whereHas('evaluations', fn ($q) => $q->havingRaw('AVG(rating) >= ?', [4]))),
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
