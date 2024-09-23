<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KaryawankeluarResource\Pages;
use App\Filament\Resources\KaryawankeluarResource\RelationManagers;
use App\Models\Karyawan;
use App\Models\Karyawankeluar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KaryawankeluarResource extends Resource
{
    protected static ?string $model = Karyawankeluar::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Menu Karyawan';
    protected static ?string $navigationLabel = 'Karyawan Keluar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('karyawans_id')
                    ->options(Karyawan::where('is_active', true)->pluck('nama', 'id'))
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_keluar')
                    ->required(),
                Forms\Components\TextInput::make('alasan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('berkas')
                    ->disk('public')
                    ->directory('berkas_keluar')
                    ->acceptedFileTypes(['application/pdf'])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('karyawan.Nama')->label('Nama'),
                Tables\Columns\TextColumn::make('karyawan.NIK')
                    ->label('NIK'),
                Tables\Columns\TextColumn::make('karyawan.Jabatan')
                    ->label('Jabatan'),
                Tables\Columns\TextColumn::make('karyawan.Departemen')
                    ->label('Departemen'),
                Tables\Columns\TextColumn::make('karyawan.lokasi.nama_lokasi')
                    ->label('Lokasi'),
                Tables\Columns\TextColumn::make('tanggal_keluar')
                    ->date(),
                Tables\Columns\TextColumn::make('alasan')
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
            'index' => Pages\ManageKaryawankeluars::route('/'),
        ];
    }
}
