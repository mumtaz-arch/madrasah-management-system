<?php

namespace App\Livewire\Admin\Cms;

use App\Models\LandingPageContent;
use App\Models\Banner;
use App\Models\Guru;
use App\Models\Program;
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
    
    // Guru for Landing Page
    public $selectedGuruIds = [];

    // Statistics
    public $statSantri;
    public $statAlumni;
    public $statPengajar;
    public $statAkreditasi;

    // Vision / Quote
    public $visionText;
    public $visionSubtext;

    // Map Embed
    public $mapEmbed;

    // Banner Management
    public $banners = [];
    public $editingBannerId = null;
    public $bannerTitle = '';
    public $bannerSubtitle = '';
    public $bannerCtaText = '';
    public $bannerCtaLink = '';
    public $bannerImage;
    public $bannerSortOrder = 0;

    // Program Management
    public $programs = [];
    public $editingProgramId = null;
    public $programTitle = '';
    public $programSlug = '';
    public $programDescription = '';
    public $programIcon = '';
    public $programImage;
    public $newProgramImage;
    public $programIsFeatured = true;
    public $programSortOrder = 0;

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
        $this->socialWhatsapp = $this->getContent('social_whatsapp', '');
        
        // Footer
        $this->footerText = $this->getContent('footer_text', 'Mewujudkan generasi Islam yang kaffah.');
        
        // Favicon
        $this->favicon = $this->getContent('favicon');
        
        // Testimoni
        $testimonialsJson = $this->getContent('testimonials', '[]');
        $this->testimonials = json_decode($testimonialsJson, true) ?: [];
        
        // Prestasi
        $achievementsJson = $this->getContent('achievements', '[]');
        $this->achievements = json_decode($achievementsJson, true) ?: [];
        
        // Selected Guru IDs
        $guruIdsJson = $this->getContent('landing_guru_ids', '[]');
        $this->selectedGuruIds = json_decode($guruIdsJson, true) ?: [];

        // Statistics
        $this->statSantri = $this->getContent('stat_santri', '500+');
        $this->statAlumni = $this->getContent('stat_alumni', '1.200+');
        $this->statPengajar = $this->getContent('stat_pengajar', '45+');
        $this->statAkreditasi = $this->getContent('stat_akreditasi', 'A');

        // Vision
        $this->visionText = $this->getContent('vision_text', '"Wujudkan generasi islami berkarakter yang seimbang secara spiritual, intelektual, moral dan keterampilan."');
        $this->visionSubtext = $this->getContent('vision_subtext', 'Visi Pondok Pesantren Pancasila Reo');

        // Map
        $this->mapEmbed = $this->getContent('map_embed', '');

        // Load Banners
        $this->loadBanners();
        
        // Load Programs
        $this->loadPrograms();
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

    // Statistics
    public function saveStatistics()
    {
        $this->saveContent('stat_santri', $this->statSantri);
        $this->saveContent('stat_alumni', $this->statAlumni);
        $this->saveContent('stat_pengajar', $this->statPengajar);
        $this->saveContent('stat_akreditasi', $this->statAkreditasi);
        session()->flash('success', 'Statistik berhasil disimpan!');
    }

    // Vision
    public function saveVision()
    {
        $this->saveContent('vision_text', $this->visionText);
        $this->saveContent('vision_subtext', $this->visionSubtext);
        session()->flash('success', 'Visi & Misi berhasil disimpan!');
    }

    // Map
    public function saveMap()
    {
        $this->saveContent('map_embed', $this->mapEmbed);
        session()->flash('success', 'Google Map berhasil disimpan!');
    }

    // Banner Management
    public function loadBanners()
    {
        $this->banners = Banner::orderBy('sort_order')->get()->toArray();
    }

    public function saveBanner()
    {
        $data = [
            'title' => $this->bannerTitle,
            'subtitle' => $this->bannerSubtitle,
            'cta_text' => $this->bannerCtaText,
            'cta_link' => $this->bannerCtaLink,
            'sort_order' => $this->bannerSortOrder,
            'is_active' => true,
        ];

        if ($this->bannerImage) {
            $data['image'] = $this->bannerImage->store('cms/banners', 'public');
        }

        if ($this->editingBannerId) {
            Banner::find($this->editingBannerId)->update($data);
            session()->flash('success', 'Banner berhasil diperbarui!');
        } else {
            Banner::create($data);
            session()->flash('success', 'Banner berhasil ditambahkan!');
        }

        $this->resetBannerForm();
        $this->loadBanners();
    }

    public function editBanner($id)
    {
        $banner = Banner::find($id);
        if ($banner) {
            $this->editingBannerId = $banner->id;
            $this->bannerTitle = $banner->title;
            $this->bannerSubtitle = $banner->subtitle;
            $this->bannerCtaText = $banner->cta_text;
            $this->bannerCtaLink = $banner->cta_link;
            $this->bannerSortOrder = $banner->sort_order;
        }
    }

    public function deleteBanner($id)
    {
        Banner::find($id)?->delete();
        $this->loadBanners();
        session()->flash('success', 'Banner berhasil dihapus!');
    }

    public function resetBannerForm()
    {
        $this->editingBannerId = null;
        $this->bannerTitle = '';
        $this->bannerSubtitle = '';
        $this->bannerCtaText = '';
        $this->bannerCtaLink = '';
        $this->bannerImage = null;
        $this->bannerSortOrder = 0;
    }
    
    // Program Management
    public function loadPrograms()
    {
        $this->programs = Program::orderBy('sort_order')->get()->toArray();
    }

    public function saveProgram()
    {
        $data = [
            'title' => $this->programTitle,
            'slug' => \Illuminate\Support\Str::slug($this->programTitle),
            'description' => $this->programDescription,
            'icon' => $this->programIcon,
            'is_featured' => $this->programIsFeatured,
            'sort_order' => $this->programSortOrder,
        ];

        if ($this->newProgramImage) {
            $data['image'] = $this->newProgramImage->store('cms/programs', 'public');
        }

        if ($this->editingProgramId) {
            Program::find($this->editingProgramId)->update($data);
            session()->flash('success', 'Program berhasil diperbarui!');
        } else {
            Program::create($data);
            session()->flash('success', 'Program berhasil ditambahkan!');
        }

        $this->resetProgramForm();
        $this->loadPrograms();
    }

    public function editProgram($id)
    {
        $program = Program::find($id);
        if ($program) {
            $this->editingProgramId = $program->id;
            $this->programTitle = $program->title;
            $this->programSlug = $program->slug;
            $this->programDescription = $program->description;
            $this->programIcon = $program->icon;
            $this->programIsFeatured = $program->is_featured;
            $this->programSortOrder = $program->sort_order;
        }
    }

    public function deleteProgram($id)
    {
        Program::find($id)?->delete();
        $this->loadPrograms();
        session()->flash('success', 'Program berhasil dihapus!');
    }

    public function resetProgramForm()
    {
        $this->editingProgramId = null;
        $this->programTitle = '';
        $this->programSlug = '';
        $this->programDescription = '';
        $this->programIcon = '';
        $this->programImage = null;
        $this->newProgramImage = null;
        $this->programIsFeatured = true;
        $this->programSortOrder = 0;
    }
    
    // Testimonials
    public function addTestimonial()
    {
        if (empty($this->newTestimonialName) || empty($this->newTestimonialText)) return;
        
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
    
    // Achievements
    public function addAchievement()
    {
        if (empty($this->newAchievementTitle)) return;
        
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
