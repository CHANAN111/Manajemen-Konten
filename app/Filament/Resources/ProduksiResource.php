<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Produksi;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProduksiResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProduksiResource\RelationManagers;

class ProduksiResource extends Resource
{
    protected static ?string $model = Produksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
{
    return 'Produksi';
}

public static function getNavigationIcon(): string
{
    return 'heroicon-o-video-camera'; // bisa pakai ikon lain
}


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul')->required(),
            Forms\Components\Textarea::make('deskripsi'),
            Forms\Components\Select::make('status')
                ->options([
                    'Ide' => 'Ide',
                    'Scripting' => 'Scripting',
                    'Shooting' => 'Shooting',
                    'Editing' => 'Editing',
                    'Publish' => 'Publish',
                ]),
            Forms\Components\DatePicker::make('deadline'),
            Forms\Components\Textarea::make('tugas')->label('Pembagian Tugas'),
            Forms\Components\FileUpload::make('resource')
                ->multiple()
                ->directory('produksi/aset')
                ->label('File Aset'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul'),
                TextColumn::make('deskripsi'),
                SelectColumn::make('status')
                    ->options([
                        'Ide' => 'Ide',
                        'Scripting' => 'Scripting',
                        'Shooting' => 'Shooting',
                        'Editing' => 'Editing',
                        'Publish' => 'Publish',
                    ]),
                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
                    ->sortable(),
                TextColumn::make('tugas'),

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
            'index' => Pages\ListProduksis::route('/'),
            'create' => Pages\CreateProduksi::route('/create'),
            'edit' => Pages\EditProduksi::route('/{record}/edit'),
        ];
    }
}
