<?php

namespace App\Livewire\Admin\Cms;

use App\Models\LandingPageContent;
use App\Models\Guru;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
class LandingPageBuilder extends Component
{
    use WithFileUploads;

    public $activeTab = 'hero';
    
    // Hero Section
    public $heroTitle;
    public $heroSubtitle;
    public $heroImage;
    public $newHeroImage;
    
    // About Section
    public $aboutTitle;
    public $aboutText;
    public $aboutImage;
    public $newAboutImage;
    
    // Contact Info
    public $contactAddress;
    public $contactPhone;
    public $contactEmail;
    
    // Social Links
    public $socialFacebook;
    public $socialInstagram;
    public $socialYoutube;
    public $socialWhatsapp;
    
    // Footer
    public $footerText;
    
    // Favicon
    public $favicon;
    public $newFavicon;
    
    // Testimoni
    public $testimonials = [];
    public $newTestimonialName = '';
    public $newTestimonialText = '';
    public $newTestimonialRole = '';
    
    // Prestasi
    public $achievements = [];
    public $newAchievementTitle = '';
    public $newAchievementYear = '';
    public $newAchievementDesc = '';
    
    // Guru for Landing Page (selected from existing Guru)
    public $selectedGuruIds = [];

    public function mount()
    {
        $this->loadAllContent();
    }

    public function loadAllContent()
    {
        // Hero
        $this->heroTitle = $this->getContent('hero_title', 'Mewujudkan Generasi Rabbani');
        $this->heroSubtitle = $this->getContent('hero_subtitle', 'Pondok Pesantren Pancasila Reo mencetak kader ulama yang berakhlak mulia.');
        $this->heroImage = $this->getContent('hero_image');
        
        // About
        $this->aboutTitle = $this->getContent('about_title', 'Membangun Peradaban dengan Al-Quran');
        $this->aboutText = $this->getContent('about_text', 'Pondok Pesantren Pancasila Reo adalah lembaga pendidikan Islam modern.');
        $this->aboutImage = $this->getContent('about_image');
        
        // Contact
        $this->contactAddress = $this->getContent('contact_address', 'Jl. Pesantren No. 1, Reo, Manggarai, NTT');
        $this->contactPhone = $this->getContent('contact_phone', '+62 812 3456 7890');
        $this->contactEmail = $this->getContent('contact_email', 'info@ponpespancasila.sch.id');
        
        // Social
        $this->socialFacebook = $this->getContent('social_facebook', '#');
        $this->socialInstagram = $this->getContent('social_instagram', '#');
        $this->socialYoutube = $this->getContent('social_youtube', '#');
        $this->socialWhatsapp = $this->getContent('social_whatsapp', '#');
        
        // Footer
        $this->footerText = $this->getContent('footer_text', 'Mewujudkan generasi Islam yang kaffah.');
        
        // Favicon
        $this->favicon = $this->getContent('favicon');
        
        // Testimoni (JSON stored)
        $testimonialsJson = $this->getContent('testimonials', '[]');
        $this->testimonials = json_decode($testimonialsJson, true) ?: [];
        
        // Prestasi (JSON stored)
        $achievementsJson = $this->getContent('achievements', '[]');
        $this->achievements = json_decode($achievementsJson, true) ?: [];
        
        // Selected Guru IDs (JSON stored)
        $guruIdsJson = $this->getContent('landing_guru_ids', '[]');
        $this->selectedGuruIds = json_decode($guruIdsJson, true) ?: [];
    }

    protected function getContent($key, $default = '')
    {
        return LandingPageContent::where('key', $key)->value('value') ?? $default;
    }

    public function saveHero()
    {
        $this->saveContent('hero_title', $this->heroTitle);
        $this->saveContent('hero_subtitle', $this->heroSubtitle);
        
        if ($this->newHeroImage) {
            $path = $this->newHeroImage->store('cms/hero', 'public');
            $this->saveContent('hero_image', $path, 'image');
            $this->heroImage = $path;
            $this->newHeroImage = null;
        }
        
        session()->flash('success', 'Hero section berhasil disimpan!');
    }

    public function saveAbout()
    {
        $this->saveContent('about_title', $this->aboutTitle);
        $this->saveContent('about_text', $this->aboutText);
        
        if ($this->newAboutImage) {
            $path = $this->newAboutImage->store('cms/about', 'public');
            $this->saveContent('about_image', $path, 'image');
            $this->aboutImage = $path;
            $this->newAboutImage = null;
        }
        
        session()->flash('success', 'About section berhasil disimpan!');
    }

    public function saveContact()
    {
        $this->saveContent('contact_address', $this->contactAddress);
        $this->saveContent('contact_phone', $this->contactPhone);
        $this->saveContent('contact_email', $this->contactEmail);
        
        session()->flash('success', 'Informasi kontak berhasil disimpan!');
    }

    public function saveSocial()
    {
        $this->saveContent('social_facebook', $this->socialFacebook);
        $this->saveContent('social_instagram', $this->socialInstagram);
        $this->saveContent('social_youtube', $this->socialYoutube);
        $this->saveContent('social_whatsapp', $this->socialWhatsapp);
        
        session()->flash('success', 'Link sosial media berhasil disimpan!');
    }

    public function saveFooter()
    {
        $this->saveContent('footer_text', $this->footerText);
        session()->flash('success', 'Footer berhasil disimpan!');
    }
    
    public function saveFavicon()
    {
        if ($this->newFavicon) {
            $path = $this->newFavicon->store('cms/favicon', 'public');
            $this->saveContent('favicon', $path, 'image');
            $this->favicon = $path;
            $this->newFavicon = null;
        }
        
        session()->flash('success', 'Favicon berhasil disimpan!');
    }
    
    public function addTestimonial()
    {
        if (empty($this->newTestimonialName) || empty($this->newTestimonialText)) {
            return;
        }
        
        $this->testimonials[] = [
            'name' => $this->newTestimonialName,
            'text' => $this->newTestimonialText,
            'role' => $this->newTestimonialRole,
        ];
        
        $this->saveContent('testimonials', json_encode($this->testimonials));
        
        $this->newTestimonialName = '';
        $this->newTestimonialText = '';
        $this->newTestimonialRole = '';
        
        session()->flash('success', 'Testimoni berhasil ditambahkan!');
    }
    
    public function removeTestimonial($index)
    {
        unset($this->testimonials[$index]);
        $this->testimonials = array_values($this->testimonials);
        $this->saveContent('testimonials', json_encode($this->testimonials));
        
        session()->flash('success', 'Testimoni berhasil dihapus!');
    }
    
    public function addAchievement()
    {
        if (empty($this->newAchievementTitle)) {
            return;
        }
        
        $this->achievements[] = [
            'title' => $this->newAchievementTitle,
            'year' => $this->newAchievementYear,
            'description' => $this->newAchievementDesc,
        ];
        
        $this->saveContent('achievements', json_encode($this->achievements));
        
        $this->newAchievementTitle = '';
        $this->newAchievementYear = '';
        $this->newAchievementDesc = '';
        
        session()->flash('success', 'Prestasi berhasil ditambahkan!');
    }
    
    public function removeAchievement($index)
    {
        unset($this->achievements[$index]);
        $this->achievements = array_values($this->achievements);
        $this->saveContent('achievements', json_encode($this->achievements));
        
        session()->flash('success', 'Prestasi berhasil dihapus!');
    }
    
    public function saveSelectedGuru()
    {
        $this->saveContent('landing_guru_ids', json_encode($this->selectedGuruIds));
        session()->flash('success', 'Guru yang ditampilkan di landing page berhasil disimpan!');
    }

    protected function saveContent($key, $value, $type = 'text', $section = 'general')
    {
        LandingPageContent::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type, 'section' => $section]
        );
    }

    public function render()
    {
        return view('livewire.admin.cms.landing-page-builder', [
            'allGuru' => Guru::orderBy('nama_lengkap')->get(),
        ]);
    }
}

