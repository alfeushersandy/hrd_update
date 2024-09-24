<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Karyawan;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\KaryawanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KaryawanResource\RelationManagers;
use Filament\Infolists\Components\Section;

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
                Tables\Actions\ViewAction::make(),
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
            'view' => Pages\ViewKaryawan::route('/{record}')
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->schema([
                        TextEntry::make('Nama')->size(TextEntry\TextEntrySize::Large)->weight(FontWeight::Bold),
                        TextEntry::make('NIK'),
                        TextEntry::make('Status_Karyawan'),
                        TextEntry::make('Jenis_Kelamin'),
                        TextEntry::make('Status_Perkawinan'),
                        TextEntry::make('Tanggal_masuk'),
                        TextEntry::make('Tanggal_lahir'),
                        TextEntry::make('Tempat_lahir'),
                        TextEntry::make('Departemen'),
                        TextEntry::make('lokasi.nama_lokasi'),
                        TextEntry::make('Jabatan'),
                        TextEntry::make('Tugas_Jabatan'),
                        TextEntry::make('Jenjang_pendidikan'),
                        TextEntry::make('Jurusan_pendidikan'),
                        TextEntry::make('Tahun_lulus'),
                        TextEntry::make('Nama_sekolah'),
                        TextEntry::make('Alamat'),
                        TextEntry::make('No_HP'),
                        TextEntry::make('NIK_KTP'),
                        TextEntry::make('no_kk'),
                        TextEntry::make('npwp'),
                        TextEntry::make('Email'),
                        TextEntry::make('Agama'),
                        TextEntry::make('gol_darah'),
                        IconEntry::make('is_active')
                            ->boolean(),
                    ])->columns(4)
            ]);
    }
}
