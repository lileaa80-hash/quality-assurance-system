<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnitResource\Pages;
use App\Models\Unit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;

    // Ini untuk ikon di sidebar (opsional bisa diganti)
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    // Nama menu di sidebar
    protected static ?string $navigationLabel = 'Data Unit/Jurusan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('code')
                            ->label('Kode Unit')
                            ->placeholder('Contoh: RPL, TKJ, TU')
                            ->required()
                            ->unique(ignoreRecord: true),

                        TextInput::make('name')
                            ->label('Nama Unit/Jurusan')
                            ->placeholder('Contoh: Rekayasa Perangkat Lunak')
                            ->required(),

                        Select::make('type')
                            ->label('Jenis Unit')
                            ->options([
                                'prodi' => 'Program Studi',
                                'fakultas' => 'Fakultas',
                                'unit_kerja' => 'Unit Kerja',
                                'lembaga' => 'Lembaga',
                            ])
                            ->required(),

                        TextInput::make('head_name')
                            ->label('Nama Kepala/Kaprodi')
                            ->placeholder('Masukkan nama lengkap beserta gelar'),

                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Kode')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Nama Unit')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'prodi' => 'success',
                        'unit_kerja' => 'warning',
                        'lembaga' => 'info',
                        default => 'gray',
                    }),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUnits::route('/'),
            'create' => Pages\CreateUnit::route('/create'),
            'edit' => Pages\EditUnit::route('/{record}/edit'),
        ];
    }
}