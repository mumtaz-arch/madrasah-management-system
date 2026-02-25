<x-layouts.landing>
    <x-slot:title>{{ $page->title }}</x-slot:title>
    
    <!-- Hero -->
    <section class="pt-32 pb-16 bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="font-heading text-4xl md:text-5xl font-bold text-white mb-4">{{ $page->title }}</h1>
            <div class="flex justify-center items-center text-primary-200 text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ $page->updated_at->format('d F Y') }}
            </div>
        </div>
    </section>

    <!-- Content -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <article class="prose prose-lg max-w-none prose-primary prose-headings:font-heading prose-a:text-primary-600 prose-a:no-underline hover:prose-a:underline">
                {!! $page->content !!}
            </article>
        </div>
    </section>
</x-layouts.landing>
