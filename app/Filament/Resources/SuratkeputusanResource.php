<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratkeputusanResource\Pages;
use App\Filament\Resources\SuratkeputusanResource\RelationManagers;
use App\Models\Suratkeputusan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SuratkeputusanResource extends Resource
{
    protected static ?string $model = Suratkeputusan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Menu Form, SK, SOP';
    protected static ?string $navigationLabel = 'Surat Keputusan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('Nama_berkas')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('keterangan_berkas')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('uploaded_file')
                    ->disk('public')
                    ->directory('file_sk')
                    ->acceptedFileTypes(['application/pdf']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Nama_berkas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('keterangan_berkas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('uploaded_file')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSuratkeputusans::route('/'),
        ];
    }
}
