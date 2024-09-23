<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KaryawanResource\Pages;
use App\Filament\Resources\KaryawanResource\RelationManagers;
use App\Models\Karyawan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KaryawanResource extends Resource
{
    protected static ?string $model = Karyawan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('Nama')
                    ->helperText('Nama Sesuai KTP')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('NIK')
                    ->label('NIK Karyawan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('Status_Karyawan')
                    ->options([
                        'Tetap' => 'Tetap',
                        'Kontrak' => 'Kontrak',
                        'Harian' => 'Harian',
                        'Borong' => 'Borong',
                    ])
                    ->required(),
                Forms\Components\Select::make('Jenis_Kelamin')
                    ->options([
                        'Laki Laki' => 'Laki Laki',
                        'Perempuan' => 'Perempuan'
                    ])
                    ->required(),
                Forms\Components\Select::make('Status_Perkawinan')
                    ->options([
                        'Single / Perempuan' => 'Single / Perempuan',
                        'Nikah belum ada anak' => 'Nikah belum ada anak',
                        'Nikah Anak 1' => 'Nikah Anak 1',
                        'Nikah Anak 2' => 'Nikah Anak 2',
                        'Nikah Anak 3 / lebih' => 'Nikah Anak 3 / lebih',
                        'Janda / Duda Anak 1' => 'Janda / Duda Anak 1',
                        'Janda / Duda Anak 2' => 'Janda / Duda Anak 2',
                        'Janda / Duda Anak 3 / lebih' => 'Janda / Duda Anak 3 / lebih',
                    ])
                    ->required(),
                Forms\Components\DatePicker::make('Tanggal_masuk')
                    ->required(),
                Forms\Components\DatePicker::make('Tanggal_lahir')
                    ->required(),
                Forms\Components\TextInput::make('Tempat_lahir')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('Departemen')
                    ->options([
                        'Directorate' => 'Directorate',
                        'Finance' => 'Finance',
                        'Accounting' => 'Accounting',
                        'HRD & GA' => 'HRD & GA',
                        'Legal & Permit' => 'Legal & Permit',
                        'Marketing' => 'Marketing',
                        'Project' => 'Project',
                        'PPIC' => 'PPIC',
                        'Procurement' => 'Procurement',
                        'Information Technology' => 'Information Technology',
                        'AMP' => 'AMP',
                        'CMP' => 'CMP',
                        'SCP' => 'SCP',
                        'Precast' => 'Precast',
                        'Peralatan dan Kendaraan' => 'Peralatan dan Kendaraan',
                        'Technical' => 'Technical',
                        'Mining' => 'Mining',
                        'Operasional' => 'Operasional',
                        'Unit' => 'Unit',
                        'CKC' => 'CKC',
                        'PT ADITYA' => 'PT ADITYA'
                    ])
                    ->required(),
                Forms\Components\Select::make('lokasi_id')
                    ->relationship('lokasi', 'nama_lokasi')
                    ->required(),
                Forms\Components\Select::make('Jabatan')
                    ->options([
                        'CEO' => 'CEO',
                        'Direktur' => 'Direktur',
                        'General Manager' => 'General Manager',
                        'Manager' => 'Manager',
                        'Section Head' => 'Section Head',
                        'Staf' => 'Staf',
                        'Support' => 'Support'
                    ])
                    ->required(),
                Forms\Components\TextInput::make('Tugas_Jabatan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('Jenjang_pendidikan')
                    ->options([
                        'SD' => 'SD',
                        'SLTP' => 'SLTP',
                        'SLTA' => 'SLTA',
                        'SMK' => 'SMK',
                        'S1' => 'S1',
                        'S2' => 'S2',
                        'S3' => 'S3',
                        'Tidak Selesai Sekolah' => 'Tidak Selesai Sekolah'
                    ])
                    ->required(),
                Forms\Components\TextInput::make('Jurusan_pendidikan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('Tahun_lulus')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('Nama_sekolah')
                    ->maxLength(255),
                Forms\Components\TextInput::make('Alamat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('No_Hp')
                    ->maxLength(255),
                Forms\Components\TextInput::make('NIK_KTP')
                    ->label('NIK KTP')
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_kk')
                    ->label('NO KK')
                    ->maxLength(255),
                Forms\Components\TextInput::make('npwp')
                    ->maxLength(255),
                Forms\Components\TextInput::make('Email')
                    ->maxLength(255),
                Forms\Components\TextInput::make('Agama')
                    ->maxLength(255),
                Forms\Components\TextInput::make('gol_darah')
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
                Forms\Components\FileUpload::make('Foto')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('foto_diri')
                    ->maxSize(1024),
                Forms\Components\FileUpload::make('Berkas')
                    ->disk('public')
                    ->directory('berkas')
                    ->acceptedFileTypes(['application/pdf'])
            ])->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('Foto')->circular()->label('Avatar'),
                Tables\Columns\TextColumn::make('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('NIK')
                    ->label('NIK')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Departemen')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lokasi.nama_lokasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Jabatan')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('active')
                    ->boolean(),
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
            'index' => Pages\ListKaryawans::route('/'),
            'create' => Pages\CreateKaryawan::route('/create'),
            'edit' => Pages\EditKaryawan::route('/{record}/edit'),
        ];
    }
}
