<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfferResource\Pages;
use App\Filament\Resources\OfferResource\RelationManagers;
use App\Models\Offer;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OfferResource extends Resource
{
    protected static ?string $model = Offer::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = 'Offres';

    protected static ?string $navigationGroup = 'Offres';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Titre')
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('Description')
                    ->rows(5)
                    ->maxLength(1000)
                    ->columnSpanFull(),

                TextInput::make('base_salary')
                    ->label('Salaire de base')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->maxValue(1000000)
                    ->placeholder('Entrez le salaire de base'),

                Select::make('company_id')
                    ->label('Entreprise')
                    ->relationship('companies', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('type')
                    ->label('Type de contrat')
                    ->options([
                        'CDI' => 'CDI',
                        'CDD' => 'CDD',
                        'Stage' => 'Stage',
                        'Alternance' => 'Alternance',
                    ])
                    ->required(),

                Select::make('sector_id')
                    ->label('Secteur')
                    ->relationship('sector', 'name')
                    ->searchable()
                    ->preload(),

                Select::make('skills')
                    ->label('Compétences requises')
                    ->relationship('skills', 'skill_name')
                    ->multiple()
                    ->searchable(),

                DatePicker::make('start_offer')
                    ->label('Date de début')
                    ->required(),

                DatePicker::make('end_offer')
                    ->label('Date de fin'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Titre')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('companies.name')
                    ->label('Entreprise')
                    ->sortable()
                    ->searchable()
                    ->default('Non attribuée')
                    ->formatStateUsing(fn ($state) => $state ?? 'Non attribuée'),

                TextColumn::make('sector.name')
                    ->label('Secteur')
                    ->sortable()
                    ->searchable()
                    ->default('Aucun secteur')
                    ->formatStateUsing(fn ($state) => $state ?? 'Aucun secteur'),

                TextColumn::make('start_date')
                    ->label('Début')
                    ->date()
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label('Fin')
                    ->date()
                    ->sortable()
                    ->default(null)
                    ->formatStateUsing(fn ($state) => $state ? \Carbon\Carbon::parse($state)->format('d/m/Y') : 'Indéfini'),
            ])
            ->filters([
                Tables\Filters\Filter::make('active_offers')
                    ->label('Offres Actives')
                    ->query(fn ($query) => $query->where('end_date', '>=', now())),
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
            'index' => Pages\ListOffers::route('/'),
            'create' => Pages\CreateOffer::route('/create'),
            'edit' => Pages\EditOffer::route('/{record}/edit'),
        ];
    }
}
