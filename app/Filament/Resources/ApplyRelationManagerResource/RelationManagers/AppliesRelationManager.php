<?php

namespace App\Filament\Resources\ApplyRelationManagerResource\RelationManagers;

use App\Models\Offer;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class AppliesRelationManager extends RelationManager
{
    protected static string $relationship = 'applies';

    protected static ?string $recordTitleAttribute = 'title';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('offer_id')
                    ->label('Offre')
                    ->options(Offer::pluck('title', 'id'))
                    ->searchable()
                    ->required(),

                FileUpload::make('curriculum_vitae')
                    ->label('CV')
                    ->directory('cvs')
                    ->acceptedFileTypes(['application/pdf'])
                    ->required(),

                Textarea::make('cover_letter')
                    ->label('Lettre de motivation')
                    ->maxLength(2000)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')->label('Offre'),
                TextColumn::make('pivot.curriculum_vitae')
                    ->label('CV')
                    ->url(fn ($record) => Storage::url($record->pivot->curriculum_vitae))
                    ->openUrlInNewTab()
                    ->limit(20),
                TextColumn::make('pivot.cover_letter')->label('Lettre de motivation')->limit(50),
            ])
            ->filters([
                //
            ])
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
