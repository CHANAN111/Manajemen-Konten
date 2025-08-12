<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Manajemen;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ManajemenResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ManajemenResource\RelationManagers;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ManajemenResource extends Resource
{
    protected static ?string $model = Manajemen::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $slug = 'menko';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')
                // ->image()
                ->required()
                ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.wordprocessingml.document']) // Hanya menerima file .docx
                ->disk('public')
                ->directory('documents') // Ubah direktori penyimpanan
                ->label('Document') // Ubah label menjadi lebih sesuai
                ->helperText('Upload file DOCX') // Tambahkan teks bantuan
                ->getUploadedFileNameForStorageUsing(
        fn (TemporaryUploadedFile $file): string => 
                    $file->getClientOriginalName()
                ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('image')
                    ->label('Document')
                    ->formatStateUsing(fn ($state) => $state ? basename($state) : 'No file')
                    ->icon('heroicon-o-document-text')
                    ->color('primary'),
            ])
            ->filters([
                
            ])
            ->actions([
                Action::make('download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn ($record) => $record->image ? Storage::disk('public')->url($record->image) : null)
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => $record->image !== null),
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
            'index' => Pages\ListManajemens::route('/'),
            'create' => Pages\CreateManajemen::route('/create'),
            'edit' => Pages\EditManajemen::route('/{record}/edit'),
        ];
    }
}
