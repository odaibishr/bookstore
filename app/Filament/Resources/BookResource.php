<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Filament\Resources\BookResource\RelationManagers;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'الكتب';
    protected static ?string $pluralLabel = 'الكتب';

    protected static ?string $modelLabel = 'كتاب';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->label('الصنف'),
                Forms\Components\Select::make('publisher_id')
                    ->relationship('publisher', 'name')
                    ->label('الناشر'),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('العنوان'),
                Forms\Components\Select::make('author_id')
                    ->multiple()
                    ->relationship('authors', 'name')
                    ->label('المؤلفون'),
                Forms\Components\TextInput::make('isbn')
                    ->maxLength(255)->label('الرقم التسلسلي'),
                Forms\Components\TextInput::make('publish_year')
                    ->numeric()
                    ->label('سنة النشر'),
                Forms\Components\TextInput::make('number_of_pages')
                    ->required()
                    ->numeric()
                    ->label('عدد الصفحات'),
                Forms\Components\TextInput::make('number_of_copies')
                    ->required()
                    ->numeric()
                    ->label('عدد النسخ'),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->label('السعر'),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull()
                    ->autosize(false)
                    ->rows(2)
                    ->label('الوصف'),
                Forms\Components\FileUpload::make('cover_image')
                    ->image()
                    ->directory('images/covers')
                    ->required()
                    ->label('صورة الغلاف'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label('العنوان')
                    ->words(5),
                Tables\Columns\TextColumn::make('authors.name')
                    ->separator(', ')
                    ->label('المؤلفون'),
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable()
                    ->label('الصنف'),
                Tables\Columns\TextColumn::make('publisher.name')
                    ->numeric()
                    ->sortable()
                    ->label('الناشر'),
                Tables\Columns\TextColumn::make('description')
                    ->words(10)
                    ->label('الوصف')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('isbn')
                    ->searchable()
                    ->label('الرقم التسلسلي')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('publish_year')
                    ->numeric()
                    ->sortable()
                    ->label('سنة النشر')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('number_of_pages')
                    ->numeric()
                    ->sortable()
                    ->label('عدد الصفحات')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('number_of_copies')
                    ->numeric()
                    ->sortable()
                    ->label('عدد النسخ'),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('cover_image')
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListBooks::route('/'),
            // 'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
