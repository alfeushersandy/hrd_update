<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormResource\Pages;
use App\Filament\Resources\FormResource\RelationManagers;
use App\Models\Form as FormKaryawan;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FormResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = FormKaryawan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Menu Form, SK, SOP';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('Nama_form')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('keterangan_form')
                    ->required(),
                Forms\Components\FileUpload::make('uploaded_file')
                    ->disk('public')
                    ->directory('file_form')
                    ->acceptedFileTypes(['application/pdf'])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Nama_form')
                    ->searchable(),
                Tables\Columns\TextColumn::make('keterangan_form')
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
                Tables\Actions\Action::make('open_pdf')
                    ->label('Berkas')
                    ->icon('heroicon-o-document-text') // Ikon opsional
                    ->url(function ($record) {
                        // Buat URL file PDF
                        return asset('storage/' . $record->uploaded_file);
                    })
                    ->openUrlInNewTab() // Buka URL di tab baru
                    ->visible(function () {
                        // Cek apakah user punya izin "view_pdf"
                        return auth()->user()->can('view_berkas_form');
                    }), //
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
            'index' => Pages\ManageForms::route('/'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'view_berkas'
        ];
    }
}
