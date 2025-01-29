<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WidgetResource\Pages;
use App\Filament\Resources\WidgetResource\RelationManagers;
use App\Filament\Resources\WidgetResource\RelationManagers\InteractionsRelationManager;
use App\Models\Widget;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WidgetResource extends Resource
{
    protected static ?string $model = Widget::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('team_id')
                    ->label('Team')
                    ->relationship('team', 'name')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        if ($state) {
                            $teamAcronym = \App\Models\Team::find($state)->acronym ?? '';
                            $randomKey = strtoupper(substr(md5(uniqid()), 0, 9));
                            $set('unique_key', "{$teamAcronym}-{$randomKey}");
                        }
                    })
                    ->columnSpan(1),

                TextInput::make('unique_key')
                    ->label('Key')
                    ->columnSpan(1),

                Forms\Components\Textarea::make('iframe_code')
                    ->label('Code')
                    ->placeholder('Paste your iframe code here...')
                    ->rows(7)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('team.name')->label('Team'),
                Tables\Columns\TextColumn::make('unique_key')->label('Key'),
                Tables\Columns\TextColumn::make('iframe_code')->label('Code'),
                Tables\Columns\TextColumn::make('created_at'),
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
            InteractionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWidgets::route('/'),
            'create' => Pages\CreateWidget::route('/create'),
            'edit' => Pages\EditWidget::route('/{record}/edit'),
        ];
    }
}
