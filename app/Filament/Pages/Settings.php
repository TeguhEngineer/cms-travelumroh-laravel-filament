<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Pengaturan';

    protected static ?string $navigationGroup = 'Sistem';

    protected static ?int $navigationSort = 99;

    protected static string $view = 'filament.pages.settings';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = Setting::first();
        $this->form->fill($settings ? $settings->toArray() : []);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('SettingsTabs')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Informasi Perusahaan')
                            ->icon('heroicon-o-building-office')
                            ->schema([
                                Forms\Components\TextInput::make('company_name')
                                    ->label('Nama Perusahaan')
                                    ->maxLength(255),

                                Forms\Components\Textarea::make('company_description')
                                    ->label('Deskripsi')
                                    ->rows(3),

                                Forms\Components\FileUpload::make('company_logo')
                                    ->label('Logo')
                                    ->image()
                                    ->directory('company'),

                                Forms\Components\TextInput::make('nomor_sk_umroh')
                                    ->label('Nomor SK Umroh')
                                    ->maxLength(100),

                                Forms\Components\TextInput::make('nomor_sk_haji')
                                    ->label('Nomor SK Haji')
                                    ->maxLength(100),
                            ]),

                        Forms\Components\Tabs\Tab::make('Kontak')
                            ->icon('heroicon-o-phone')
                            ->schema([
                                Forms\Components\TextInput::make('telepon_1')
                                    ->label('Telepon 1')
                                    ->tel()
                                    ->maxLength(20),

                                Forms\Components\TextInput::make('telepon_2')
                                    ->label('Telepon 2')
                                    ->tel()
                                    ->maxLength(20),

                                Forms\Components\TextInput::make('telepon_3')
                                    ->label('Telepon 3')
                                    ->tel()
                                    ->maxLength(20),

                                Forms\Components\TextInput::make('telepon_4')
                                    ->label('Telepon 4')
                                    ->tel()
                                    ->maxLength(20),

                                Forms\Components\TextInput::make('telepon_5')
                                    ->label('Telepon 5')
                                    ->tel()
                                    ->maxLength(20),

                                Forms\Components\TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('alamat')
                                    ->label('Alamat')
                                    ->maxLength(255),

                                Forms\Components\Textarea::make('detail_alamat')
                                    ->label('Detail Alamat')
                                    ->rows(3),
                            ]),

                        Forms\Components\Tabs\Tab::make('Social Media')
                            ->icon('heroicon-o-share')
                            ->schema([
                                Forms\Components\TextInput::make('whatsapp')
                                    ->label('WhatsApp')
                                    ->tel()
                                    ->maxLength(20)
                                    ->helperText('Format: 628123456789'),

                                Forms\Components\TextInput::make('facebook')
                                    ->label('Facebook URL')
                                    ->url()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('instagram')
                                    ->label('Instagram URL')
                                    ->url()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('youtube')
                                    ->label('YouTube URL')
                                    ->url()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('tiktok')
                                    ->label('TikTok URL')
                                    ->url()
                                    ->maxLength(255),
                            ]),

                        Forms\Components\Tabs\Tab::make('SEO')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Forms\Components\TextInput::make('seo_title')
                                    ->label('SEO Title')
                                    ->maxLength(255),

                                Forms\Components\Textarea::make('seo_description')
                                    ->label('SEO Description')
                                    ->rows(3)
                                    ->maxLength(500),

                                Forms\Components\Textarea::make('seo_keywords')
                                    ->label('SEO Keywords')
                                    ->rows(2)
                                    ->helperText('Pisahkan dengan koma'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Hero Cover')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Forms\Components\FileUpload::make('cover_image')
                                    ->label('Cover Image')
                                    ->image()
                                    ->directory('cover'),

                                Forms\Components\TextInput::make('cover_title')
                                    ->label('Cover Title')
                                    ->maxLength(255),

                                Forms\Components\Textarea::make('cover_subtitle')
                                    ->label('Cover Subtitle')
                                    ->rows(2),
                            ]),

                        Forms\Components\Tabs\Tab::make('Tentang Kami')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\RichEditor::make('deskripsi_perusahaan')
                                    ->label('Deskripsi Perusahaan')
                                    ->columnSpanFull(),

                                Forms\Components\Textarea::make('visi')
                                    ->label('Visi')
                                    ->rows(3),

                                Forms\Components\Textarea::make('misi')
                                    ->label('Misi')
                                    ->rows(5),
                            ]),
                    ])
                    ->columnSpanFull()
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $settings = Setting::first();

        if ($settings) {
            $settings->update($data);
        } else {
            Setting::create($data);
        }

        Notification::make()
            ->title('Pengaturan berhasil disimpan')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            \Filament\Actions\Action::make('save')
                ->label('Simpan Pengaturan')
                ->submit('save')
                ->color('primary'),
        ];
    }
}
