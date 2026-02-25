<?php

namespace App\Livewire\Admin\Cms;

use App\Models\LandingPageContent;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

class LandingPageSettings extends Component
{
    use WithFileUploads;

    public $settings = [];
    public $heroImage;
    public $aboutImage;

    public function mount()
    {
        // Load all settings into array
        $contents = LandingPageContent::all();
        foreach ($contents as $content) {
            $this->settings[$content->key] = $content->value;
        }

        // Set defaults if key doesn't exist
        $defaults = [
            'hero_title' => 'Menyiapkan Generasi Rabbani Berprestasi',
            'hero_subtitle' => 'Pondok Pesantren Pancasila Reo berkomitmen mencetak kader ulama yang intelek dan intelek yang ulama.',
            'hero_cta_text' => 'Daftar Sekarang',
            'hero_cta_link' => '/ppdb',
            'about_title' => 'Tentang Kami',
            'about_text' => 'Deskripsi singkat tentang pesantren...',
            'footer_text' => 'Pondok Pesantren Pancasila Reo',
            'contact_phone' => '+62 812 3456 7890',
            'contact_email' => 'info@ponpespancasila.sch.id',
            'contact_address' => 'Jl. Pesantren No. 1, Reo',
            'social_facebook' => '#',
            'social_instagram' => '#',
            'social_youtube' => '#',
        ];

        foreach ($defaults as $key => $value) {
            if (!isset($this->settings[$key])) {
                $this->settings[$key] = $value;
            }
        }
    }

    public function save()
    {
        // Handle Image Uploads
        if ($this->heroImage) {
            $path = $this->heroImage->store('cms/hero', 'public');
            $this->updateSetting('hero_image', $path, 'image');
        }
        
        if ($this->aboutImage) {
            $path = $this->aboutImage->store('cms/about', 'public');
            $this->updateSetting('about_image', $path, 'image');
        }

        // Save Text Settings
        foreach ($this->settings as $key => $value) {
            // Skip images here, handled above
            if (in_array($key, ['hero_image', 'about_image'])) continue;
            
            $section = $this->determineSection($key);
            $this->updateSetting($key, $value, 'text', $section);
        }

        session()->flash('message', 'Pengaturan berhasil disimpan!');
    }

    private function updateSetting($key, $value, $type = 'text', $section = 'general')
    {
        LandingPageContent::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'section' => $section
            ]
        );
    }

    private function determineSection($key)
    {
        if (str_starts_with($key, 'hero_')) return 'hero';
        if (str_starts_with($key, 'about_')) return 'about';
        if (str_starts_with($key, 'contact_') || str_starts_with($key, 'social_') || str_starts_with($key, 'footer_')) return 'footer';
        return 'general';
    }

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.cms.landing-page-settings');
    }
}
