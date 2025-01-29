<?php

namespace App\Filament\Resources\WidgetResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InteractionsRelationManager extends RelationManager
{
    protected static string $relationship = 'interactions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('question')
                    ->required()
                    ->maxLength(255)
                    ->autosize(),
                Forms\Components\Textarea::make('answer')
                    ->required()
                    ->maxLength(255)
                    ->autosize(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                Tables\Columns\TextColumn::make('question')->limit(60),
                Tables\Columns\TextColumn::make('answer')->limit(60),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make('View')
                    ->infolist([
                        Fieldset::make('Question')
                            ->schema([
                                TextEntry::make('question')
                                    ->hiddenLabel(),
                            ])->columns(1),
                        Fieldset::make('Answer')
                            ->schema([
                                TextEntry::make('answer')
                                    ->hiddenLabel(),
                            ])->columns(1),
                    ]),
                // Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
