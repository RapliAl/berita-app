<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Content Management';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Post Details')
                    ->schema([
                        Select::make('author_id')
                            ->label('Author')
                            ->relationship('author', 'name')
                            ->required(),
                        Select::make('categories_id')
                            ->label('Category')
                            ->relationship('categories', 'name')
                            ->required(),
                       TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->maxLength(255)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                            ->label('Post Title'),
                        TextInput::make('slug')
                            ->readOnly(),
                    ]),
                Section::make('content')
                    ->description('Write your post content below.')
                    ->schema([
                        RichEditor::make('content')
                            ->required()
                            ->label('Content')
                            ->columnSpanFull(),
                        FileUpload::make('image_content')
                            ->columnSpanFull()
                    ]),
                Section::make('Published Date')
                    ->description('Set Your Published date.')
                    ->schema([
                        DatePicker::make('published_date')
                            ->required()
                            ->default(now())
                            ->label('Published Date')
                            ->displayFormat('Y-m-d'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_content')
                    ->label('Image')
                    ->size(50),
                TextColumn::make('title')
                    ->label('Post Title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('content')
                    ->label('Content')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable(),
                TextColumn::make('author.name')
                    ->label('Author')
                    ->searchable(),
                TextColumn::make('categories.name')
                    ->label('Category')
                    ->searchable(),
                TextColumn::make('published_date')
                    ->label('Published Date')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
